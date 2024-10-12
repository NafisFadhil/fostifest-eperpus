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
        Schema::table('ms_level', function (Blueprint $table) {
            $table->integer('max_borrow')->nullable()->after('point_requirement');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ms_level', function (Blueprint $table) {
            $table->dropColumn('max_borrow');
        });
    }
};
