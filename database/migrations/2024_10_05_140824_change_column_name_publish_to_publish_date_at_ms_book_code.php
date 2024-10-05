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
        Schema::table('ms_book_code', function (Blueprint $table) {
            $table->renameColumn('publish', 'publish_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ms_book_code', function (Blueprint $table) {
            $table->renameColumn('publish_date', 'publish');
        });
    }
};
