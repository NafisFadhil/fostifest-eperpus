<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Loan;
use App\Models\User;
use App\Models\BookCode;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    public function index()
    {
        return view('admin.peminjaman.index');
    }

    public function data(Request $request)
    {
        $query = Loan::orderBy('created_at', 'desc');

        // Check if a category filter is provided
        if (isset($request->status) && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Get the filtered or full data
        $data = $query->get();
		if (!$data->isEmpty()) {
			foreach ($data as $item) {
                $item->user_name = $item->user->name;
                $item->book_code = $item->code_book->book->title . ' - ' . $item->code_book->code;
                $button_state = 'disabled';
                $button_review = '';
                if ($item->status == 0) {
                    $status_name = '<span class="badge bg-secondary">Dipesan</span>';
                } elseif ($item->status == 1) {
                    $status_name = '<span class="badge bg-warning">Dipinjam</span>';
                } elseif ($item->status == 2) {
                    $status_name = '<span class="badge bg-success">Dikembalikan</span>';
                    $button_state = '';
                    $button_review = '<a href="' . route('peminjaman.poin', $item->id) . '" class="btn btn-icon btn-primary btn-sm mx-1 ' . $button_state . '"  title="Beri Poin"><i class="fas fa-coins"></i></a>';
                } else {
                    $status_name = '<span class="badge bg-danger">Dibatalkan</span>';
                }
                if ($item->review != null && $item->review->status != 0 ) {
                    $button_state = 'disabled';
                    $button_review = '';
                }
                $item->status_name = $status_name;
                $item->borrow_date = $item->borrow_date ?? 'Belum Dipinjam';
                $item->return_date = $item->return_date ?? 'Belum Dikembalikan';
				$buttonHtml =
					'<a href="' . route('peminjaman.edit', $item->id) . '" class="btn btn-icon btn-warning btn-sm mx-1" title="Edit Data"><i class="fas fa-edit"></i></a>'
					. '<button type="button" data-id="' . $item->id . '" data-nama="' . $item->title . '" class="btn btn-icon btn-danger btn-sm mx-1 btn-hapus" title="Hapus Data"><i class="fas fa-trash"></i></button>'
                    . $button_review;

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
        if (Auth::check()) {
            $book_code_id = $request->book_code_id ?? '03fdf2eb-d5d8-4147-b43c-322e49bdcadf';
            // dd($book_code_id);
            // create data peminjaman didalam tb_loan
            DB::beginTransaction();
            try {
                if (isset($book_code_id)) {
                    //check if code_book is available
                    $code_book = BookCode::find($request->book_code_id);
                    if ($code_book) {
                        if ($code_book->status == 1) {
                            //Generate loan code
                            //Format loan code : book_code - user_id - date (string)
                            $loan_code = $code_book->code . '-' . strtoupper(str_replace(' ', '', User::first()->name)) . '-' . date('dmyHis');
                            // $loan_code = $code_book->code . '-' . strtoupper(str_replace(' ', '', auth()->user()->name)) . '-' . date('dmyHis');
                            //Create data loan
                            $loan = [
                                'id' => Str::uuid(),
                                'user_id' => User::first()->id,
                                // 'user_id' => auth()->user()->id,
                                'book_code_id' => $request->book_code_id,
                                'loan_code' => $loan_code,
                                'status' => 0,
                            ];
                            // store data loan
                            Loan::create($loan);

                            // update status code book
                            $code_book->update(['status' => 0]);
                            DB::commit();
                        } else {
                            return response()->json(['status' => false, 'message' => 'Kode buku sedang dipinjam. Silahkan pilih buku yang lain'], 409);
                        }
                    } else {
                        return response()->json(['status' => false, 'message' => 'Kode buku tidak ditemukan'], 404);
                    }

                    return response()->json(['status' => true, 'message' => 'Data peminjaman berhasil ditambahkan', 'data' => $loan], 200);
                } else {
                    return response()->json(['status' => false, 'message' => 'Data buku tidak ditemukan'], 404);
                }
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Login terlebih dahulu'], 401);
        }
    }

    public function borrow(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $peminjaman = Loan::find($id)->first();
            if ($peminjaman) {
                $peminjaman->update([
                    'status' => 1,
                    'borrow_date' => Carbon::now(),
                ]);
                DB::commit();
                return response()->json(['status' => true, 'message' => 'Data peminjaman berhasil ditambahkan', 'data' => $peminjaman], 200);
            } else {
                DB::rollBack();
                return response()->json(['status' => false, 'message' => 'Data peminjaman tidak ditemukan'], 404);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function return(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $peminjaman = Loan::find($id)->first();
            if ($peminjaman) {
                $peminjaman->update([
                    'status' => 2,
                    'return_date' => Carbon::now(),
                ]);
                DB::commit();
                return response()->json(['status' => true, 'message' => 'Data pengembalian berhasil ditambahkan', 'data' => $peminjaman], 200);
            } else {
                DB::rollBack();
                return response()->json(['status' => false, 'message' => 'Data peminjaman tidak ditemukan'], 404);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function poin($id)
    {
        $peminjaman = Loan::find($id)->with(['review', 'code_book' => function($query) {
            $query->with('book');
        }])->first();
        if ($peminjaman) {
            return view('admin.peminjaman.poin', compact('peminjaman'));
        } else {
            return response()->json(['status' => false, 'message' => 'Data peminjaman tidak ditemukan'], 404);
        }
    }

    public function poinUpdate(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $peminjaman = Loan::find($id)->with('review')->first();
            if ($peminjaman) {
                $peminjaman->review->update([
                    'points' => $request->data_range,
                    'status' => 1,
                ]);
                DB::commit();
                return response()->json(['status' => true, 'message' => 'Data peminjaman berhasil diupdate'], 200);
            } else {
                DB::rollBack();
                return response()->json(['status' => false, 'message' => 'Data peminjaman tidak ditemukan'], 404);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
