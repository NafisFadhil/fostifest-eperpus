<?php

namespace App\Http\Controllers;

use App\Models\Season;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class SeasonController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		return view('season.index');
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		return view('season.create');
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
                'start_date' => 'required|date',
                'end_date' => 'required|date',
			]);

			if ($validator->fails()) {
				return response()->json(['status' => false, 'message' => 'Validasi Error', 'error' => $validator->errors()], 422);
			}

			$model = new Season();
			$data = [
				'id' => Uuid::uuid7(),
				'name' => $request->name,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
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
		$data = Season::findOrFail($id);
		return view('season.show', compact('data'));
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(string $id)
	{
		$data = Season::findOrFail($id);
		return view('season.edit', compact('data'));
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
                'start_date' => 'required|date',
                'end_date' => 'required|date',
			]);

			if ($validator->fails()) {
				return response()->json(['status' => false, 'message' => 'Validasi Error', 'error' => $validator->errors()], 422);
			}

			$loker = Season::findOrFail($id);
			$data_loker = [
				'name' => $request->name,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
				'updated_at' => now(),
			];
			$loker->update($data_loker);

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
			$data = Season::find($id);
			if (!$data) {
				return response()->json([
					'status' => 'error',
					'message' => 'Data Loker tidak ditemukan'
				]);
			}

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
		$query = Season::orderBy('name', 'DESC');
		$data = $query->get();
		if (!$data->isEmpty()) {
			foreach ($data as $item) {

				$buttonHtml =
					'<a href="' . route('season.edit', $item->id) . '" class="btn btn-icon btn-warning btn-sm mx-1" title="Edit Data"><i class="fas fa-edit"></i></a>'
					. '<button type="button" data-id="' . $item->id . '" data-nama="' . $item->name . '" class="btn btn-icon btn-danger btn-sm mx-1 btn-hapus" title="Hapus Data"><i class="fas fa-trash"></i></button>'

					. '<a href="' . route('season.show', $item->id) . '" class="btn btn-icon btn-primary btn-sm mx-1" title="Detail Data"><i class="fas fa-eye"></i></a>';

				$item->action = $buttonHtml;
			}
		}
		return response()->json([
			'status' => true,
			'data' => $data
		]);
	}
}
