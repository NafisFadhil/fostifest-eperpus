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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
						$table->uuid('role_id');
            $table->string('name');
						$table->string('username')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();

						$table->foreign('role_id')->references('id')->on('ms_role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
