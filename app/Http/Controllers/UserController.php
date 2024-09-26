<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Ramsey\Uuid\Uuid;

class UserController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		return view('user.index');
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		$role = Role::where('code', '!=', 'SUPADMIN')->get();
		$kelas = Kelas::orderBy('name')->get();
		return view('user.create', compact('role', 'kelas'));
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request)
	{
		DB::beginTransaction();

		try {
			$validator = Validator::make($request->all(), [
				'name' => 'required|string|max:255',
			]);

			if ($validator->fails()) {
				return response()->json(['status' => false, 'message' => 'Validasi Error', 'error' => $validator->errors()], 422);
			}

			$model = new User();
			$data = [
				'id' => Uuid::uuid7(),
				'name' => $request->name,
				'username' => $request->username,
				'password' => Hash::make($request->password),
				'role_id' => $request->role,
				'kelas_id' => $request->kelas,
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
		$user = User::findOrFail($id);
		return view('user.show', compact('user'));
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(string $id)
	{
		$user = User::findOrFail($id);
		$role = Role::where('code', '!=', 'SUPADMIN')->get();
		$kelas = Kelas::orderBy('name')->get();
		return view('user.edit', compact('user', 'role', 'kelas'));
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, string $id)
	{
		DB::beginTransaction();

		try {
			$validator = Validator::make($request->all(), [
				'name' => 'required|string|max:255',
			]);

			if ($validator->fails()) {
				return response()->json(['status' => false, 'message' => 'Validasi Error', 'error' => $validator->errors()], 422);
			}

			$model = User::findOrFail($id);
			$data = [
				'id' => Uuid::uuid7(),
				'name' => $request->name,
				'username' => $request->username,
				'role_id' => $request->role,
				'kelas_id' => $request->kelas,
				'updated_at' => now(),
			];

			if ($request->password) {
				$data['password'] = Hash::make($request->password);
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
			$data = User::find($id);
			if (!$data) {
				return response()->json([
					'status' => 'error',
					'message' => 'Data User tidak ditemukan'
				]);
			}

			$data->izin()->delete();

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
		$query = User::orderBy('name')->whereHas('role', function ($q) {
			$q->where('code', '!=', 'SUPADMIN');
		});
		$data = $query->get();
		if (!$data->isEmpty()) {
			foreach ($data as $item) {
				$item->user_role = $item->role->name;
				$buttonHtml =
					'<a href="' . route('user.edit', $item->id) . '" class="btn btn-icon btn-warning btn-sm mx-1" title="Edit Data"><i class="fas fa-edit"></i></a>'
					. '<button type="button" data-id="' . $item->id . '" data-nama="' . $item->name . '" class="btn btn-icon btn-danger btn-sm mx-1 btn-hapus" title="Hapus Data"><i class="fas fa-trash"></i></button>'

					. '<a href="' . route('user.show', $item->id) . '" class="btn btn-icon btn-primary btn-sm mx-1" title="Detail Data"><i class="fas fa-eye"></i></a>';

				$item->action = $buttonHtml;
			}
		}
		return response()->json([
			'status' => true,
			'data' => $data
		]);
	}

	public function import(Request $request)
	{
		DB::beginTransaction();
		try {
			// Validate the request
			$request->validate([
				'file' => 'required|mimes:xls,xlsx',
			]);

			// Get the file from the request
			$file = $request->file('file');

			// Load the spreadsheet
			$spreadsheet = IOFactory::load($file);

			// Get the active sheet
			$sheet = $spreadsheet->getActiveSheet();

			// Get the highest row and column numbers referenced in the worksheet
			$highestRow = $sheet->getHighestRow();
			$highestColumn = $sheet->getHighestColumn();

			// Initialize an empty array to store the data
			$data = [];

			// Iterate through rows and columns to extract data
			for ($row = 2; $row <= $highestRow; $row++) {
				$rowData = [];
				for ($col = 'A'; $col <= $highestColumn; $col++) {
					$cellValue = $sheet->getCell($col . $row)->getValue();
					$rowData[] = $cellValue;
				}
				if ($rowData[0] == '') continue;
				if ($rowData[1] == '') continue;
				// if($rowData[2] == '') continue;

				$role = Role::where('code', $rowData[3])->firstOrFail();

				$user = new User();
				$user->id = Uuid::uuid4()->toString();
				$user->name = $rowData[0];
				$user->username = $rowData[1];
				$user->password = Hash::make($rowData[2]);
				$user->role_id = $role->id;
				if ($rowData[4] != '' && $role->code == 'MEMBER') {
					$kelas = Kelas::firstOrCreate([
						'name' => $rowData[4]
					], [
						'id' => Uuid::uuid7()->toString(),
						'created_at' => now()
					]);
					$user->kelas_id = $kelas->id;
				}
				$user->save();

				$data[] = $rowData;
			}
			DB::commit();
			//exclude header

			return response()->json([
				'message' => 'Data berhasil diproses',
			]);
		} catch (\Throwable $th) {
			DB::rollBack();
			return response()->json([
				'error' => 'Terjadi kesalahan saat proses data ' . $th->getMessage(),
			], 500);
		}
	}
}
