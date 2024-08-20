<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Genre;


class GenresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $genres = ['Classics', 'Dystopian', 'Romance', 'Fantasy', 'Science Fiction', 'Historical Fiction'];
        foreach ($genres as $genre) {
            Genre::create(['name' => $genre]);
        }
    }
}
