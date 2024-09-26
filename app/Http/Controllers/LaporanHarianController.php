<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Kelas;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanHarianController extends Controller
{
    public function index()
    {
        $kelas = Kelas::orderBy('name', 'asc')->get();
        return view('laporan.harian', compact( 'kelas'));
    }

    public function data(Request $request)
    {
        $query = Attendance::select('tb_attendance.*');
        $date = $request->date ?? Carbon::now();
        $kelas = $request->kelas ?? "all";
        if($kelas != "all"){
            $query->whereHas('user', function($q) use ($kelas){
                $q->where('kelas_id', $kelas);
            });
        }
        $query->whereDate('date_in', $date);

        $query->orderBy('date_in', 'desc');
        $absen = $query->get()->sortBy('user.name')->values();
        if (!$absen->isEmpty()) {
            foreach ($absen as $item) {
                $in = Carbon::parse($item->date_in);
                $out = Carbon::parse($item->date_out ?? $item->date_in);

                $item->duration = $in->diff($out)->format("%h Jam %i Menit %s Detik");
                $item->student_name = $item->user->name;
                $item->date_attendance = Carbon::parse($item->date_in)->isoFormat('D MMMM Y');
                $item->hour_in = Carbon::parse($item->date_in)->format('H:i:s');
                $item->hour_out = $item->date_out ? Carbon::parse($item->date_out)->format('H:i:s') : '-';
            }
        }


        return response()->json([
            'status' => true,
            'data' => $absen
        ]);
    }
}
