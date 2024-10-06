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
        Schema::create('tb_review', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('loan_id');
            $table->uuid('user_id');
            $table->text('review');
            $table->string('rating')->nullable();
            $table->text('summary')->nullable();
            $table->integer('ponits');
            $table->tinyInteger('status');
            $table->uuid('accepted_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_review');
    }
};
