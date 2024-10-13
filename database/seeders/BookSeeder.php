<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (range(1, 10) as $index) {
            $book_id = Str::uuid();

            $book = \App\Models\Book::query()->create([
                'id' => $book_id, // UUID for primary key
                'title' => fake('id-ID')->sentence(3), // Generate a random book title
                'cover' => 'storage/covers/cover-buku.jpeg', // Random image file name
                'description' => fake('id-ID')->paragraph(3), // Random description
                'max_points' => fake('id-ID')->numberBetween(50, 100), // Random max points
                'min_points' => fake('id-ID')->numberBetween(10, 49), // Random min points
                'max_borrow_day' => fake('id-ID')->numberBetween(7, 30), // Random number of borrow days
                'publish_date' => fake('id-ID')->date(), // Random publish date
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            \App\Models\BookCode::query()->create([
                'id' => Str::uuid(),
                'book_id' => $book_id,
                'code' => strtoupper(fake()->bothify('B###-#####')),
                'status' => mt_rand(0, 1),
                'publish_date' => now(),
            ]);
        }
    }
}
