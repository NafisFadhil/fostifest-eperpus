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
        Schema::table('tb_review', function (Blueprint $table) {
            $table->uuid('accepted_by')->nullable()->change();
            $table->integer('ponits')->nullable()->change();
            $table->integer('rating')->nullable()->change();
            $table->text('summary')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_review', function (Blueprint $table) {
            $table->uuid('accepted_by')->change();
            $table->integer('ponits')->change();
            $table->string('rating')->change();
            $table->text('summary')->change();
        });
    }
};
