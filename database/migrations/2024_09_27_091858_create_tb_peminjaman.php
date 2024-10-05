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
        Schema::create('tb_loan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('book_code_id');
            $table->string('loan_code')->unique(); // KODE BUKU - ID USER - DDMMYYmmss
            $table->dateTime('borrow_date');
            $table->dateTime('return_date');
            $table->tinyInteger('status'); // (0 : Dipesan, 1 : Dipinjam, 2 : Dikembalikan, 3 : Dibatalkan)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_loan');
    }
};
