<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ArtisSeeder::class);
        $this->call(FilmSeeder::class);
        $this->call(GenreSeeder::class);
        $this->call(NegaraSeeder::class);
        $this->call(ProduserSeeder::class);
        // \App\Models\User::factory(10)->create();
    }
}
