<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
						'id' => Uuid::uuid7(),
						'role_id' => Role::where('code', 'SUPADMIN')->first()->id,
						'name' => 'Superadmin',
						'username' => 'superadmin',
						'password' => Hash::make('admin'),
				]);
    }
}
