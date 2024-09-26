<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('ms_setting', function (Blueprint $table) {
			$table->uuid('id')->primary();
			$table->string('key')->nullable();
			$table->string('label')->nullable();
			$table->string('value')->nullable();
			$table->string('input_type')->nullable();
			$table->integer('sequence')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('ms_setting');
	}
};
