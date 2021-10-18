<?php

namespace Database\Seeders;

use App\Models\Produser;
use Illuminate\Database\Seeder;

class ProduserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Produser::create([
            'kd_produser'   => 'PD01',
            'nm_produser'   => 'MARVEL',
            'international' => 'YA'
        ]);

        Produser::create([
            'kd_produser'   => 'PD02',
            'nm_produser'   => 'HONGKONG CINEMA',
            'international' => 'YA'
        ]);

        Produser::create([
            'kd_produser'   => 'PD03',
            'nm_produser'   => 'RAPI FILM',
            'international' => 'TIDAK'
        ]);

        Produser::create([
            'kd_produser'   => 'PD04',
            'nm_produser'   => 'PARKIT',
            'international' => 'TIDAK'
        ]);

        Produser::create([
            'kd_produser'   => 'PD05',
            'nm_produser'   => 'PARAMOUNT PICTURE',
            'international' => 'YA'
        ]);
    }
}
