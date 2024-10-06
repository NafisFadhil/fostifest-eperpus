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
        Schema::table('ms_book', function (Blueprint $table) {
            $table->integer('max_borrow_day')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ms_book', function (Blueprint $table) {
            $table->date('max_borrow_day')->change();
        });
    }
};
