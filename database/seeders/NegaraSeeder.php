<?php

namespace Database\Seeders;

use App\Models\Negara;
use Illuminate\Database\Seeder;

class NegaraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Negara::create([
            'kd_negara' => 'AS',
            'nm_negara' => 'AMERIKA SERIKAT'
        ]);

        Negara::create([
            'kd_negara' => 'HK',
            'nm_negara' => 'HONGKONG'
        ]);

        Negara::create([
            'kd_negara' => 'ID',
            'nm_negara' => 'INDONESIA'
        ]);

        Negara::create([
            'kd_negara' => 'IN',
            'nm_negara' => 'INDIA'
        ]);
    }
}
