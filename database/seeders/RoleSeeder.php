<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
						'id' => Uuid::uuid7(),
						'code' => 'SUPADMIN',
						'name' => 'Superadmin',
				]);
				
				Role::create([
						'id' => Uuid::uuid7(),
						'code' => 'MEMBER',
						'name' => 'Member',
				]);
				
				Role::create([
						'id' => Uuid::uuid7(),
						'code' => 'GURU',
						'name' => 'Guru',
				]);
    }
}
