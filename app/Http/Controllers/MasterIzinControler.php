<?php

namespace App\Http\Controllers;

use App\Models\Izin;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class MasterIzinControler extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		return view('master-izin.index');
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		$users = User::whereRelation('role', 'code', 'MEMBER')->orderBy('name')->get();
		return view('master-izin.create', compact('users'));
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request)
	{
		DB::beginTransaction();

		try {
			$validator = Validator::make($request->all(), [
				'siswa' => 'required|exists:users,id',
				'tanggal' => 'required',
				'durasi' => 'required|numeric|min:1|max:3',
				'surat' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
				'keterangan' => 'required',
			]);

			if ($validator->fails()) {
				return response()->json(['status' => false, 'message' => 'Validasi Error', 'error' => $validator->errors()], 422);
			}

			// start::Pengecekan Izin
			$tanggal = Carbon::parse($request->tanggal);

			for ($i = 1; $i <= $request->durasi; $i++) {
				if ($tanggal->isWeekend()) {
					return response()->json(['status' => false, 'message' => 'Anda tidak bisa mengajukan izin pada akhir pekan'], 422);
				}

				$izin = Izin::where('user_id', $request->siswa)
					->whereDate('tanggal', $tanggal)
					->first();

				if ($izin) {
					return response()->json(['status' => false, 'message' => 'Siswa sudah mengajukan izin pada tanggal  ' . $tanggal->translatedFormat('j F Y')], 422);
				}

				for ($j = 1; $j <= 3; $j++) {
					$new_tanggal = Carbon::parse($tanggal)->addDays(-$j);
					$izin = Izin::where('user_id', $request->siswa)
						->whereDate('tanggal', $new_tanggal)
						->first();

					if ($izin) {
						return response()->json(['status' => false, 'message' => 'Siswa sudah mengajukan izin pada tanggal ' . $tanggal->translatedFormat('j F Y')], 422);
					}
				}
				$tanggal->addDay();
			}
			// end::Pengecekan Izin

			$model = new Izin();
			$data = [
				'id' => Uuid::uuid7(),
				'user_id' => $request->siswa,
				'tanggal' => $request->tanggal,
				'qty' => $request->durasi,
				'attachment' => $request->file('surat')->store('izin'),
				'keterangan' => $request->keterangan,
				'created_at' => now(),
			];
			$model->insert($data);

			DB::commit();

			return response()->json(['status' => true]);
		} catch (\Exception $e) {
			DB::rollback();
			return response()->json(['status' => false, 'message' => 'Terjadi Error', 'error' => $e->getMessage()], 422);
		}
	}

	/**
	 * Display the specified resource.
	 */
	public function show(string $id)
	{
		$izin = Izin::with('user')->findOrFail($id);
		return view('master-izin.show', compact('izin'));
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(string $id)
	{
		$izin = Izin::with('user')->findOrFail($id);
		$users = User::whereRelation('role', 'code', 'MEMBER')->orderBy('name')->get();
		return view('master-izin.edit', compact('users', 'izin'));
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, string $id)
	{
		DB::beginTransaction();

		try {
			$validator = Validator::make($request->all(), [
				'siswa' => 'required|exists:users,id',
				'tanggal' => 'required',
				'durasi' => 'required|numeric|min:1|max:3',
				'surat' => 'file|mimes:pdf,jpg,jpeg,png|max:2048',
				'keterangan' => 'required',
			]);

			if ($validator->fails()) {
				return response()->json(['status' => false, 'message' => 'Validasi Error', 'error' => $validator->errors()], 422);
			}

			// start::Pengecekan Izin
			$tanggal = Carbon::parse($request->tanggal);

			for ($i = 1; $i <= $request->durasi; $i++) {
				if ($tanggal->isWeekend()) {
					return response()->json(['status' => false, 'message' => 'Anda tidak bisa mengajukan izin pada akhir pekan'], 422);
				}

				$izin = Izin::where('id', '!=', $id)->where('user_id', $request->siswa)
					->whereDate('tanggal', $tanggal)
					->first();

				if ($izin) {
					return response()->json(['status' => false, 'message' => 'Siswa sudah mengajukan izin pada tanggal  ' . $tanggal->translatedFormat('j F Y')], 422);
				}

				for ($j = 1; $j <= 3; $j++) {
					$new_tanggal = Carbon::parse($tanggal)->addDays(-$j);
					$izin = Izin::where('id', '!=', $id)->where('user_id', $request->siswa)
						->whereDate('tanggal', $new_tanggal)
						->first();

					if ($izin) {
						return response()->json(['status' => false, 'message' => 'Siswa sudah mengajukan izin pada tanggal ' . $tanggal->translatedFormat('j F Y')], 422);
					}
				}
				$tanggal->addDay();
			}
			// end::Pengecekan Izin

			$model = Izin::findOrFail($id);
			$data = [
				'id' => Uuid::uuid7(),
				'user_id' => $request->siswa,
				'tanggal' => $request->tanggal,
				'qty' => $request->durasi,
				'keterangan' => $request->keterangan,
				'updated_at' => now(),
			];

			if($request->hasFile('surat')) {
				Storage::delete($model->attachment);
				$data['attachment'] = $request->file('surat')->store('izin');
			}

			$model->update($data);

			DB::commit();

			return response()->json(['status' => true]);
		} catch (\Exception $e) {
			DB::rollback();
			return response()->json(['status' => false, 'message' => 'Terjadi Error', 'error' => $e->getMessage()], 422);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(string $id)
	{
		DB::beginTransaction();

		try {
			$data = izin::find($id);
			if (!$data) {
				return response()->json([
					'status' => 'error',
					'message' => 'Data Izin tidak ditemukan'
				]);
			}
			Storage::delete($data->attachment);

			$data->delete();

			DB::commit();

			return response()->json([
				'status' => 'success',
				'message' => 'Berhasil Menghapus Data'
			]);
		} catch (\Exception $e) {
			DB::rollback();
			return response()->json(['status' => false, 'message' => 'Terjadi Error', 'error' => $e->getMessage()], 422);
		}
	}

	public function data(Request $request)
	{
		$query = Izin::with('user')->orderBy('tanggal', 'desc');
		$date_start = $request->input('date_start') ?? date('Y-m-01');
		$date_end = $request->input('date_end') ?? date('Y-m-t');
		$query->whereDate('tanggal', '>=', $date_start);
		$query->whereDate(DB::raw("DATE_ADD(tanggal, INTERVAL (qty - 1) DAY)"), '<=', $date_end);
		// $data = $query->get()->sortBy('user.name')->values();
		$data = $query->get();
		if (!$data->isEmpty()) {
			foreach ($data as $item) {

				$item->siswa = $item->user->name;
				$item->durasi = $item->qty . ' Hari';
				$item->tanggal = Carbon::parse($item->tanggal)->translatedFormat('j F Y');

				$buttonHtml =
					'<a href="' . route('master-izin.edit', $item->id) . '" class="btn btn-icon btn-warning btn-sm mx-1" title="Edit Data"><i class="fas fa-edit"></i></a>'
					. '<button type="button" data-id="' . $item->id . '" data-nama="' . $item->siswa . '" class="btn btn-icon btn-danger btn-sm mx-1 btn-hapus" title="Hapus Data"><i class="fas fa-trash"></i></button>'

					. '<a href="' . route('master-izin.show', $item->id) . '" class="btn btn-icon btn-primary btn-sm mx-1" title="Detail Data"><i class="fas fa-eye"></i></a>';

				$item->action = $buttonHtml;
			}
		}
		return response()->json([
			'status' => true,
			'data' => $data
		]);
	}
}
