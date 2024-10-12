<?php

namespace App\Http\Controllers;

use App\Models\Level;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MasterLevelController extends Controller
{
    public function index()
    {
        return view('admin.master_level.index');
    }

    public function data(Request $request)
    {
        $query = Level::orderBy('point_requirement', 'asc')->get();
        if (!$query->isEmpty()) {
            foreach ($query as $item) {
                $buttonHtml =
                '<a href="' . route('master-level.edit', $item->id) . '" class="btn btn-icon btn-warning btn-sm mx-1" title="Edit Data"><i class="fas fa-edit"></i></a>'
                . '<button type="button" data-id="' . $item->id . '" data-nama="' . $item->title . '" class="btn btn-icon btn-danger btn-sm mx-1 btn-hapus" title="Hapus Data"><i class="fas fa-trash"></i></button>';

                $item->action = $buttonHtml;
            }
        }

        return response()->json([
			'status' => true,
			'data' => $query
		]);
    }

    public function create()
    {
        return view('admin.master_level.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'min_poin' => 'required|numeric',
            'max_pinjam_buku' => 'required|numeric',
            'reset_poin' => 'required|numeric',
        ],
        [
            'name.required' => 'Nama wajib diisi',
            'min_poin.required' => 'Minimal poin wajib diisi',
            'min_poin.numeric' => 'Minimal poin harus berupa angka',
            'max_pinjam_buku.required' => 'Maksimal peminjaman buku wajib diisi',
            'max_pinjam_buku.numeric' => 'Maksimal peminjaman buku harus berupa angka',
            'reset_poin.required' => 'Reset poin wajib diisi',
            'reset_poin.numeric' => 'Reset poin harus berupa angka',
        ]);
        DB::beginTransaction();
        try {

            $data = Level::create([
                'id' => Str::uuid(),
                'name' => $request->name,
                'point_requirement' => $request->min_poin,
                'max_borrow' => $request->max_pinjam_buku,
                'reset_point' => $request->reset_poin,
            ]);

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Data berhasil ditambahkan',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function edit($id)
    {
        $data = Level::find($id);
        return view('admin.master_level.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'min_poin' => 'required|numeric',
            'max_pinjam_buku' => 'required|numeric',
            'reset_poin' => 'required|numeric',
        ],
        [
            'name.required' => 'Nama wajib diisi',
            'min_poin.required' => 'Minimal poin wajib diisi',
            'min_poin.numeric' => 'Minimal poin harus berupa angka',
            'max_pinjam_buku.required' => 'Maksimal peminjaman buku wajib diisi',
            'max_pinjam_buku.numeric' => 'Maksimal peminjaman buku harus berupa angka',
            'reset_poin.required' => 'Reset poin wajib diisi',
            'reset_poin.numeric' => 'Reset poin harus berupa angka',
        ]);
        DB::beginTransaction();
        try {
            $data = Level::find($id);
            $data->update([
                'name' => $request->name,
                'point_requirement' => $request->min_poin,
                'max_borrow' => $request->max_pinjam_buku,
                'reset_point' => $request->reset_poin,
            ]);

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Data berhasil diubah',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $data = Level::find($id);
            $data->delete();
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Data berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
