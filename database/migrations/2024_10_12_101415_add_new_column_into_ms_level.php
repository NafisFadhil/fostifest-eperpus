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
            //rename column point_requrement to point_requirement
            $table->renameColumn('point_requrement', 'point_requirement');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ms_level', function (Blueprint $table) {
        });
    }
};
