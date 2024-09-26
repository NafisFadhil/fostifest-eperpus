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
        Schema::table('tb_attendance', function (Blueprint $table) {
            $table->string('photo_in')->after('date_out')->nullable();
            $table->string('photo_out')->after('photo_in')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_attendance', function (Blueprint $table) {
            $table->dropColumn('photo_in');
            $table->dropColumn('photo_out');
        });
    }
};
