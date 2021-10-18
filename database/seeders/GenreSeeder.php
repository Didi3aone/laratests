<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Genre::create([
            'kd_genre' => 'G001',
            'nm_genre' => 'ACTION'
        ]);

        Genre::create([
            'kd_genre' => 'G002',
            'nm_genre' => 'HORROR'
        ]);

        Genre::create([
            'kd_genre' => 'G003',
            'nm_genre' => 'COMEDY'
        ]);

        Genre::create([
            'kd_genre' => 'G004',
            'nm_genre' => 'DRAMA'
        ]);

        Genre::create([
            'kd_genre' => 'G005',
            'nm_genre' => 'THRILLER'
        ]);

        Genre::create([
            'kd_genre' => 'G006',
            'nm_genre' => 'FICTION'
        ]);
    }
}
