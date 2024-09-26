<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Ramsey\Uuid\Uuid;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		$timestamps = [
			'created_at' => now(),
			'updated_at' => now()
		];

		DB::table('ms_setting')->insert([
			[
				'id' => Uuid::uuid7(),
				'key' => 'entry-hours',
				'label' => 'Jam Masuk',
				'input_type' => 'time',
				'value' => '07:00',
				'sequence' => 1,
				'created_at' => $timestamps['created_at'],
				'updated_at' => $timestamps['updated_at']
			],
			[
				'id' => Uuid::uuid7(),
				'key' => 'location',
				'label' => 'Lokasi',
				'input_type' => 'leaflet',
				'value' => '-6.937493017366972, 109.65062823796286',
				'sequence' => 2,
				'created_at' => $timestamps['created_at'],
				'updated_at' => $timestamps['updated_at']
			],
		]);
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		DB::table('ms_setting')->whereIn('key', ['entry-hours', 'location'])->delete();
	}
};
