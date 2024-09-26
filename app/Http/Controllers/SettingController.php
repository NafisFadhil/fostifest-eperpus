<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
	public function index()
	{
		$settings = Setting::orderBy('sequence', 'asc')->get();
		return view('setting.index', compact('settings'));
	}

	public function store(Request $request)
	{
		DB::beginTransaction();

		try {
			$settings = $request->setting;
			foreach ($settings as $key => $value) {
				Setting::where('key', $key)->update([
					'value' => $value
				]);
			}

			DB::commit();

			return response()->json(['status' => true]);
		} catch (\Exception $e) {
			DB::rollback();
			return response()->json(['status' => false, 'message' => 'Terjadi Error', 'error' => $e->getMessage()], 422);
		}
	}
}
