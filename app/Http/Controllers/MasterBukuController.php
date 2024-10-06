<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookCode;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MasterBukuController extends Controller
{
    public function index()
    {
        $data_category = Category::orderBy('name')->get();
        return view('admin.buku.index', compact('data_category'));
    }

    public function create()
    {
        return view('admin.buku.create');
    }

    public function data(Request $request)
    {
        $query = Book::orderBy('title');

        // Check if a category filter is provided
        if ($request->category && $request->category !== 'all') {
            $query->whereHas('categories', function($q) use ($request) {
                // Specify the table when using 'id' to remove ambiguity
                $q->where('ms_category.id', $request->category);
            });
        }

        // Get the filtered or full data
        $data = $query->get();
		if (!$data->isEmpty()) {
			foreach ($data as $item) {
                $item->image = '<img src="' . asset( $item->cover) . '" width="100px" />';
                $item->categories_name = $item->categories->pluck('name')->implode(', ');
				$buttonHtml =
					'<a href="' . route('master-buku.edit', $item->id) . '" class="btn btn-icon btn-warning btn-sm mx-1" title="Edit Data"><i class="fas fa-edit"></i></a>'
					. '<button type="button" data-id="' . $item->id . '" data-nama="' . $item->title . '" class="btn btn-icon btn-danger btn-sm mx-1 btn-hapus" title="Hapus Data"><i class="fas fa-trash"></i></button>';

				$item->action = $buttonHtml;
			}
		}
		return response()->json([
			'status' => true,
			'data' => $data
		]);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            // Validate the input
            $validator = Validator::make($request->all(), [
                'nama_buku' => 'required|string|max:255|regex:/^[a-zA-Z0-9\s,]+$/',
                'deskripsi' => 'required|regex:/^[a-zA-Z0-9\s,]+$/',
                'min_poin' => 'required|numeric|min:0',
                'max_poin' => 'required|numeric|min:0',
                'tags' => 'required|string',
                'max_hari_peminjaman' => 'required|numeric|min:1',
                'tanggal_publish' => 'required|date',
                'kode_buku.*' => 'required|string|max:255|regex:/^[a-zA-Z0-9\s,-]+$/|unique:ms_book_code,code',
                'tgl_publish.*' => 'required|date',
                'sampul' => 'required|file|mimes:jpg,jpeg,png,webp|max:2048',
            ], [
                'nama_buku.required' => 'Nama harus diisi.',
                'nama_buku.string' => 'Nama harus berupa teks.',
                'nama_buku.max' => 'Nama tidak boleh melebihi 255 karakter.',
                'nama_buku.regex' => 'Nama harus berupa huruf, angka, spasi, titik, koma.',
                'deskripsi.required' => 'Deskripsi harus diisi.',
                'deskripsi.regex' => 'Deskripsi harus berupa huruf, angka, spasi, titik, koma.',
                'min_poin.required' => 'Minimal poin harus diisi.',
                'min_poin.numeric' => 'Minimal poin harus berupa angka.',
                'min_poin.min' => 'Minimal poin harus lebih dari 0.',
                'max_poin.required' => 'Maksimal poin harus diisi.',
                'max_poin.numeric' => 'Maksimal poin harus berupa angka.',
                'max_poin.min' => 'Maksimal poin harus lebih dari 0.',
                'tags.required' => 'Tag harus diisi.',
                'tags.string' => 'Tag harus berupa teks.',
                'max_hari_peminjaman.required' => 'Maksimal hari peminjaman harus diisi.',
                'max_hari_peminjaman.numeric' => 'Maksimal hari peminjaman harus berupa angka.',
                'max_hari_peminjaman.min' => 'Maksimal hari peminjaman harus lebih dari 0.',
                'tanggal_publish.required' => 'Tgl. Publish harus diisi.',
                'tanggal_publish.date' => 'Tgl. Publish harus berupa tanggal.',
                'kode_buku.*.required' => 'Kode buku harus diisi.',
                'kode_buku.*.string' => 'Kode buku harus berupa teks.',
                'kode_buku.*.max' => 'Kode buku tidak boleh melebihi 255 karakter.',
                'kode_buku.*.regex' => 'Kode buku harus berupa huruf, angka, spasi, titik, koma.',
                'kode_buku.*.unique' => 'Kode buku sudah ada.',
                'tgl_publish.*.required' => 'Tgl. Publish harus diisi.',
                'tgl_publish.*.date' => 'Tgl. Publish harus berupa tanggal.',
                'sampul.required' => 'Sampul harus diisi.',
                'sampul.file' => 'Sampul harus berupa berkas.',
                'sampul.mimes' => 'Sampul harus berekstensi jpg, jpeg, png, webp.',
                'sampul.max' => 'Sampul tidak boleh melebihi 2 MB.',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => true, 'message' => $validator->errors()->first()], 422);
            }

            // Handle file upload for 'sampul'
            $sampul = $request->file('sampul');
            $sampul_name = time() . '_' . $sampul->getClientOriginalName();
            $path_name = 'images/buku/' . $sampul_name;
            $sampul->move(public_path('images/buku'), $sampul_name);

            // Generate a unique ID for the book
            $id_buku = Str::uuid();

            // Convert 'tags' from JSON string to array (no need to uppercase)
            $tags = collect(json_decode($request->tags, true))
                ->pluck('value')
                ->toArray();

            // Retrieve existing categories in a case-insensitive manner
            $existingCategories = Category::pluck('name')->map(fn($name) => strtolower($name))->toArray();

            // Initialize an array to store category IDs
            $categoryIds = [];

            // Loop through the tags and compare with existing categories (case-insensitive comparison)
            foreach ($tags as $tag) {
                $lowerTag = strtolower($tag);

                // If the tag does not exist in the database, create a new category
                if (!in_array($lowerTag, $existingCategories)) {
                    $idCategory = Str::uuid();
                    $newCategory = Category::create([
                        'id' => $idCategory,
                        'name' => $tag, // Store the name exactly as it is in the request
                    ]);
                    $categoryIds[] = $idCategory;
                } else {
                    // Get the ID of the existing category (using case-insensitive comparison)
                    $existingCategory = Category::whereRaw('LOWER(name) = ?', [$lowerTag])->first();
                    $categoryIds[] = $existingCategory->id;
                }
            }

            // Insert the book data into the database
            $book = Book::create([
                'id' => $id_buku,
                'title' => $request->nama_buku,
                'cover' => $path_name,
                'description' => $request->deskripsi,
                'max_points' => $request->max_poin,
                'min_points' => $request->min_poin,
                'max_borrow_day' => $request->max_hari_peminjaman,
                'publish_date' => $request->tanggal_publish,
            ]);

            // Explicitly attach categories with the UUID book_id
            $book->categories()->attach($categoryIds, ['book_id' => $id_buku]);

            // Insert book codes
            foreach ($request->kode_buku as $key => $value) {
                BookCode::create([
                    'id' => Str::uuid(),
                    'book_id' => $id_buku,
                    'code' => $value,
                    'status' => 1,
                    'publish_date' => $request->tgl_publish[$key],
                ]);
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Buku Berhasil Ditambahkan',
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => false, 'message' => 'Terjadi Error', 'error' => $e->getMessage()], 422);
        }
    }

    public function edit($id)
    {
        $data = Book::findOrFail($id);
        $data->image = asset($data->cover);
        $data->tags = $data->categories->pluck('name')->implode(', ');
        return view('admin.buku.edit', compact('data'));
    }

    public function update($id, Request $request)
    {
        DB::beginTransaction();
        try {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'nama_buku' => 'required|string|max:255',
                'deskripsi' => 'required|string|max:255',
                'max_poin' => 'required|integer',
                'min_poin' => 'required|integer',
                'max_hari_peminjaman' => 'required|integer',
                'sampul' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
                'tags' => 'required|string',
                'tanggal_publish' => 'required|date',
                'old_kode_buku.*' => 'required|string|unique:ms_book_code,code,' . $id . ',book_id',
                'old_tgl_publish.*' => 'required|date',
                'kode_buku.*' => 'required|string|unique:ms_book_code,code,',
                'tgl_publish.*' => 'required|date',
            ], [
                'nama_buku.required' => 'Nama harus diisi',
                'nama_buku.max' => 'Maksimal 255 karakter',
                'nama_buku.string' => 'Harus berupa teks',
                'deskripsi.required' => 'Deskripsi harus diisi',
                'deskripsi.max' => 'Maksimal 255 karakter',
                'deskripsi.string' => 'Harus berupa teks',
                'max_poin.required' => 'Max Poin harus diisi',
                'max_poin.integer' => 'Max Poin harus berupa angka',
                'min_poin.required' => 'Min Poin harus diisi',
                'min_poin.integer' => 'Min Poin harus berupa angka',
                'max_hari_peminjaman.required' => 'Max Hari Peminjaman harus diisi',
                'max_hari_peminjaman.integer' => 'Max Hari Peminjaman harus berupa angka',
                'sampul.max' => 'Maksimal 2048 karakter',
                'tags.required' => 'Tag harus diisi',
                'tags.string' => 'Tag harus berupa teks',
                'tanggal_publish.required' => 'Tanggal Publish harus diisi',
                'tanggal_publish.date' => 'Tangal Publish harus berupa tanggal',
                'old_kode_buku.*.required' => 'Kode Buku harus diisi',
                'old_kode_buku.*.string' => 'Kode Buku harus berupa teks',
                'old_kode_buku.*.unique' => 'Kode Buku sudah ada',
                'old_tgl_publish.*.required' => 'Tgl Publish harus diisi',
                'old_tgl_publish.*.date' => 'Tgl Publish harus berupa tanggal',
                'kode_buku.*.required' => 'Kode Buku harus diisi',
                'kode_buku.*.string' => 'Kode Buku harus berupa teks',
                'kode_buku.*.unique' => 'Kode Buku sudah ada',
                'tgl_publish.*.required' => 'Tgl Publish harus diisi',
                'tgl_publish.*.date' => 'Tgl Publish harus berupa tanggal',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => true, 'message' => $validator->errors()->first()], 422);
            }

            // Handle file upload for 'sampul'
            $path_name = null;
            if ($request->hasFile('sampul')) {
                $old_image = Book::find($request->id);
                $image_path = public_path($old_image->cover);

                // Remove old image if it exists
                if (file_exists($image_path)) {
                    unlink($image_path);
                }

                // Save the new cover image
                $sampul = $request->file('sampul');
                $sampul_name = $sampul->getClientOriginalName();
                $path_name = 'images/buku/' . $sampul_name;
                $sampul->move(public_path('images/buku'), $sampul_name);
            } else {
                $old_image = Book::find($id);
                $path_name = $old_image->cover;
            }

            // Process tags and handle categories
            $tags = collect(json_decode($request->tags, true))
                ->pluck('value')
                ->toArray(); // Keep the original case for tags

            // Convert existing categories' names to uppercase for comparison
            $categoryIds = [];

            foreach ($tags as $tag) {
                // Convert the current tag to uppercase for comparison
                $upperTag = strtoupper($tag);

                // Check if the tag exists in the categories
                $existingCategory = Category::whereRaw('UPPER(name) = ?', [$upperTag])->first();

                if (!$existingCategory) {
                    $id_new_category = Str::uuid();
                    // If the category doesn't exist, create a new one
                    $newCategory = Category::create([
                        'id' => $id_new_category,
                        'name' => $tag, // Keep the original name
                    ]);
                    $categoryIds[] = $id_new_category; // Push new category ID
                } else {
                    // If the category exists, use its ID
                    $categoryIds[] = $existingCategory->id; // Push existing category ID
                }
            }

            // Handle book codes update or deletion
            $book_codes = BookCode::where('book_id', $id)->get();
            foreach ($book_codes as $book_code) {
                if (in_array($book_code->id, $request->old_id_kode)) {
                    $key = array_search($book_code->id, $request->old_id_kode);
                    $book_code->update([
                        'code' => $request->old_kode_buku[$key],
                        'publish_date' => $request->old_tgl_publish[$key],
                    ]);
                } else {
                    $book_code->delete();
                }
            }

            // Add new book codes if provided
            if ($request->kode_buku) {
                foreach ($request->kode_buku as $key => $value) {
                    BookCode::create([
                        'id' => Str::uuid(),
                        'book_id' => $id,
                        'code' => $value,
                        'status' => 1,
                        'publish_date' => $request->tgl_publish[$key],
                    ]);
                }
            }

            // Update the book details
            $book = Book::find($id); // Retrieve the book model
            $book->update([
                'title' => $request->nama_buku,
                'cover' => $path_name,
                'description' => $request->deskripsi,
                'max_points' => $request->max_poin,
                'min_points' => $request->min_poin,
                'max_borrow_day' => $request->max_hari_peminjaman,
                'publish_date' => $request->tanggal_publish,
            ]);

            // Detach all current categories
            $book->categories()->detach();

            // Attach the new categories to the book
            $book->categories()->attach($categoryIds, ['book_id' => $id]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Buku Berhasil Diubah',
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => false, 'message' => 'Terjadi Error', 'error' => $e->getMessage()], 422);
        }
    }


    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            // Find the book by ID
            $book = Book::findOrFail($id);

            // Unlink the cover image if it exists
            if ($book->cover && file_exists(public_path($book->cover))) {
                unlink(public_path($book->cover));
            }

            // Detach all related categories
            $book->categories()->detach();

            // Delete all associated book codes
            BookCode::where('book_id', $book->id)->delete();

            // Delete the book itself
            $book->delete();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Buku berhasil dihapus',
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage(),
            ], 422);
        }
    }


}
