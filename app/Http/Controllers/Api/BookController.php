<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookCode;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::when(request('search'), function ($query) {
            $query->where('title', 'like', '%' . request('search') . '%');
        })->with(['categories'])->orderBy('title', 'asc')->get();
        return response()->json([
            'data' => $books
        ]);
    }

    public function show($id)
    {
        $book = Book::with(['categories', 'codes', 'codes.loan', 'codes.loan.review'])->find($id);

        return response()->json([
            'data' => $book
        ]);
    }

    public function pinjam(Request $request)
    {
        if (Auth::check()) {
            $book_code_id = $request->book_code_id ?? Uuid::uuid7();
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
}
