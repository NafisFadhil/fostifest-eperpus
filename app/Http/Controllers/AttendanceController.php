<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class AttendanceController extends Controller
{
    public function index()
    {
        return view('absen.index');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $user = auth()->user();
            $absen = Attendance::where('user_id', $user->id)->whereDate('date_in', Carbon::now())->first();
            if ($absen && $absen?->date_in != null && $absen?->date_out != null) {
                return response()->json([
                    'status' => 'error',
                    'errors' => [
                        'name' => ['Sudah absen']
                    ],
                    'message' => 'Anda sudah absen hari ini'
                ], 422);
            }

            if (!$absen && $request->photo_attendance == null) {
                return response()->json([
                    'status' => 'error',
                    'errors' => [
                        'name' => ['Foto harus diisi']
                    ],
                    'message' => 'Foto harus diisi'
                ], 422);
            }

            // Jarak lokasi absen
            $company_location = Setting::where('key', 'location')->first()->value;
            $lat_company = explode(",", $company_location)[0];
            $long_company = explode(",", $company_location)[1];
            $distance = $this->attendance_distance($lat_company, $long_company, $request->lat, $request->long, 'MT', true, 1);
            // dd($lat_company, $long_company, $request->lat, $request->long, $distance);
            if ($distance > 50) {
                //500 meter
                return response()->json([
                    'status' => 'error',
                    'errors' => [
                        'name' => ['Jarak Melebihi Batas']
                    ],
                    'message' => 'Jarak absensi anda melebihi batas'
                ], 422);
            }


            $path_photo = null;
            if ($request->file('photo_attendance')) {
                $path_photo = $request->file('photo_attendance')->store('attendance');
            }

            $attendance_id = Uuid::uuid4();

            $location = $request->lat . ', ' . $request->long;
            if ($absen && $absen?->date_in != null) {
                $absen->update([
                    'date_out' => now(),
                    'location_out' => $location,
                    'photo_out' => $path_photo,
                    'noted_out' => $request->keterangan,
                    'updated_at' => now(),
                ]);
            } else {
                $attendance = new Attendance();
                $data_attendance = [
                    'id' => $attendance_id,
                    'user_id' => $user->id,
                    'date_in' => now(),
                    'location_in' => $location,
                    'photo_in' => $path_photo,
                    'noted_in' => $request->keterangan,
                    'created_at' => now()
                ];
                $attendance->insert($data_attendance);
            }


            DB::commit();

            return response()->json(['status' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => false, 'message' => 'Terjadi Error', 'error' => $e->getMessage()], 422);
        }
    }

    private function attendance_distance($latitudeOne = '', $longitudeOne = '', $latitudeTwo = '', $longitudeTwo = '', $distanceUnit = '', $round = false, $decimalPoints = '')
    {
        if (empty($decimalPoints)) {
            $decimalPoints = '3';
        }
        if (empty($distanceUnit)) {
            $distanceUnit = 'KM';
        }
        $distanceUnit = strtolower($distanceUnit);
        $pointDifference = $longitudeOne - $longitudeTwo;
        $toSin = (sin(deg2rad($latitudeOne)) * sin(deg2rad($latitudeTwo))) + (cos(deg2rad($latitudeOne)) * cos(deg2rad($latitudeTwo)) * cos(deg2rad($pointDifference)));
        $toAcos = acos($toSin);
        $toRad2Deg = rad2deg($toAcos);

        $toMiles = $toRad2Deg * 60 * 1.1515;
        $toKilometers = $toMiles * 1.609344;
        $toNauticalMiles = $toMiles * 0.8684;
        $toMeters = $toKilometers * 1000;
        $toFeets = $toMiles * 5280;
        $toYards = $toFeets / 3;


        switch (strtoupper($distanceUnit)) {
            case 'ML': //miles
                $toMiles = ($round == true ? round($toMiles) : round($toMiles, $decimalPoints));
                return $toMiles;
                break;
            case 'KM': //Kilometers
                $toKilometers = ($round == true ? round($toKilometers) : round($toKilometers, $decimalPoints));
                return $toKilometers;
                break;
            case 'MT': //Meters
                $toMeters = ($round == true ? round($toMeters) : round($toMeters, $decimalPoints));
                return $toMeters;
                break;
            case 'FT': //feets
                $toFeets = ($round == true ? round($toFeets) : round($toFeets, $decimalPoints));
                return $toFeets;
                break;
            case 'YD': //yards
                $toYards = ($round == true ? round($toYards) : round($toYards, $decimalPoints));
                return $toYards;
                break;
            case 'NM': //Nautical miles
                $toNauticalMiles = ($round == true ? round($toNauticalMiles) : round($toNauticalMiles, $decimalPoints));
                return $toNauticalMiles;
                break;
        }
    }
}
