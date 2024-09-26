<?php

namespace App\Http\Controllers;

use App\Models\Izin;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class IzinController extends Controller
{
	public function index()
	{
		return view('izin.index');
	}

	public function store(Request $request)
	{
		DB::beginTransaction();

		try {
			$validator = Validator::make($request->all(), [
				'tanggal' => 'required',
				'durasi' => 'required|numeric|min:1|max:3',
				'surat' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
				'keterangan' => 'required',
			]);

			if ($validator->fails()) {
				return response()->json(['status' => false, 'message' => 'Validasi Error', 'error' => $validator->errors()], 422);
			}

			// start::Check Izin
			$weekendMessage = 'Anda tidak bisa mengajukan izin pada akhir pekan';
			$izinMessage = 'Anda sudah mengajukan izin pada tanggal';

			$tanggal = Carbon::parse($request->tanggal);
			for ($i = 1; $i <= $request->durasi; $i++) {
				if ($tanggal->isWeekend()) {
					return response()->json(['status' => false, 'message' => $weekendMessage], 422);
				}

				if ($this->isIzinExists($tanggal)) {
					return response()->json(['status' => false, 'message' => $izinMessage . ' ' . $tanggal->translatedFormat('j F Y')], 422);
				}

				if ($this->isPreviousIzinExists($tanggal)) {
					return response()->json(['status' => false, 'message' => $izinMessage . ' ' . $tanggal->translatedFormat('j F Y')], 422);
				}

				$tanggal->addDay();
			}
			// end::Check Izin

			$model = new Izin();
			$data = [
				'id' => Uuid::uuid7(),
				'user_id' => auth()->user()->id,
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

	private function isIzinExists($tanggal)
	{
		return Izin::where('user_id', auth()->user()->id)
			->whereDate('tanggal', $tanggal)
			->exists();
	}

	private function isPreviousIzinExists($tanggal)
	{
		return Izin::where('user_id', auth()->user()->id)
			->whereIn('tanggal', function ($query) use ($tanggal) {
				$query->select(DB::raw("DATE_SUB('$tanggal', INTERVAL (seq - 1) DAY)"))
					->from(DB::raw("(SELECT 1 as seq UNION SELECT 2 UNION SELECT 3) as seqs"));
			})
			->exists();
	}
}
