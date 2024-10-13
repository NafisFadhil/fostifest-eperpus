<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookCode;
use App\Models\History;
use App\Models\Level;
use App\Models\Loan;
use App\Models\Review;
use App\Models\Season;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Str;

class LandingPageController extends Controller
{
    public function index(Request $request)
    {
        $books = Book::when($request->get('search'), function ($query) {
            $query->where('title', 'like', '%' . request('search') . '%');
        })
            ->with(['categories', 'codes'])
            ->orderBy('title', 'asc')
            ->get();

        return Inertia::render('Home', [
            'allData' => $books,
        ]);
    }

    public function book(string $id)
    {
        $book = Book::with(['categories', 'codes', 'codes.loan', 'codes.loan.review', 'codes.loan.user'])->find($id);

        return Inertia::render('Book', [
            'book' => $book
        ]);
    }

    public function leaderboard()
    {
        $leaderboard = History::with(['user', 'level', 'season'])->orderBy('poin', 'desc')->limit(3)->get();

        return Inertia::render('Leaderboard', [
            'leaderboard' => $leaderboard
        ]);
    }

    public function mybook()
    {
        $loans = Loan::where('user_id', auth()->user()->id)->with(['code_book', 'code_book.book', 'user', 'review'])->get();

        return Inertia::render('MyBook', [
            'loans' => $loans
        ]);
    }

    public function checkout(Request $request, string $id)
    {
        try {
            if (!Auth::check()) {
                return redirect()->back()->with('message', $e->getMessage());
            }
            $book_code_id = $id ?? Uuid::uuid7();
            // create data peminjaman didalam tb_loan
            DB::beginTransaction();
            if (isset($book_code_id)) {
                //check if code_book is available
                $code_book = BookCode::find($id);
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
                            'book_code_id' => $id,
                            'loan_code' => $loan_code,
                            'status' => 0,
                        ];
                        // store data loan
                        Loan::create($loan);

                        // update status code book
                        $code_book->update(['status' => 0]);
                        DB::commit();
                    }
                }

                if (isset($loan) && $loan) {
                    return redirect()->back()->with(
                        [
                            'status' => true,
                            'message' => 'Data peminjaman berhasil ditambahkan',
                            'data' => $loan
                        ]
                    );
                }
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    public function peminjaman(string $id)
    {
        $loan = Loan::where('id', $id)->with(['code_book', 'code_book.book', 'user', 'review'])->first();

        return Inertia::render('Peminjaman', [
            'loan' => $loan
        ]);
    }

    public function kembalikan(Request $request, string $id)
    {
        if (Auth::check()) {
            $validated = $request->validate([
                'review' => 'required',
                'rating' => 'required',
                'summary' => 'required',
            ]);

            $loan = Loan::where('id', $id)->with(['code_book', 'code_book.book', 'user', 'review'])->first();
            $book_code_id = $loan->book_code_id ?? Uuid::uuid7();

            // create data peminjaman didalam tb_loan
            DB::beginTransaction();
            try {
                if (isset($book_code_id)) {
                    //check if code_book is available
                    $code_book = BookCode::find($book_code_id);
                    if ($code_book) {
                        if ($code_book->status == 0) {
                            //Generate loan code
                            //Format loan code : book_code - user_id - date (string)
                            // $loan_code = $code_book->code . '-' . strtoupper(str_replace(' ', '', User::first()->name)) . '-' . date('dmyHis');
                            // $loan_code = $code_book->code . '-' . strtoupper(str_replace(' ', '', auth()->user()->name)) . '-' . date('dmyHis');
                            //Create data loan
                            // $loan->update([
                            //     'return_date' => now(),
                            //     'status' => 1,
                            // ]);

                            $review = Review::create([
                                'id' => Str::uuid(),
                                'loan_id' => $loan->id,
                                'user_id' => $loan->user_id,
                                'review' => $validated['review'],
                                'rating' => $validated['rating'],
                                'summary' => $validated['summary'],
                                'status' => 0,

                            ]);

                            // update status code book
                            DB::commit();
                        } else {
                            return response()->json(['status' => false, 'message' => 'Kode buku sedang dipinjam. Silahkan pilih buku yang lain'], 409);
                        }
                    } else {
                        return response()->json(['status' => false, 'message' => 'Kode buku tidak ditemukan'], 404);
                    }

                    return redirect('/mybook')->with(['status' => true, 'message' => 'Data peminjaman berhasil ditambahkan', 'data' => $loan], 200);
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

    public function profil()
    {
        return Inertia::render('Profil', []);
    }
}
