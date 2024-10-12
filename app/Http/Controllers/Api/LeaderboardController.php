<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\History;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    public function index() {
        $data = History::with(['user', 'season'])->whereHas('season',function($query) {
            $query->where('start_date', '<=', Carbon::now())->where('end_date', '>=', Carbon::now());
        })->orderBy('poin', 'desc')->get();

        return response()->json([
            'data' => $data
        ]);
    }
}
