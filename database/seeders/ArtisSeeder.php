<?php

namespace Database\Seeders;

use App\Models\Artis;
use Illuminate\Database\Seeder;

class ArtisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Artis::create([
            'kd_artis'  => 'A001',
            'nm_artis'  => 'ROBERT DOWNY JR',
            'jk'        => 'PRIA',
            'bayaran'   => '000000000',
            'award'     => '2',
            'negara'    => 'AS'
        ]);

        Artis::create([
            'kd_artis'  => 'A002',
            'nm_artis'  => 'ANGELINA JOLIE',
            'jk'        => 'WANITA',
            'bayaran'   => '700000000',
            'award'     => '1',
            'negara'    => 'AS'
        ]);

        Artis::create([
            'kd_artis'  => 'A003',
            'nm_artis'  => 'JACKIE CHAN',
            'jk'        => 'PRIA',
            'bayaran'   => '200000000',
            'award'     => '7',
            'negara'    => 'HK'
        ]);

        Artis::create([
            'kd_artis'  => 'A004',
            'nm_artis'  => 'JOE TASLIM',
            'jk'        => 'PRIA',
            'bayaran'   => '350000000',
            'award'     => '1',
            'negara'    => 'ID'
        ]);

        Artis::create([
            'kd_artis'  => 'A005',
            'nm_artis'  => 'CHELSEA ISLAN',
            'jk'        => 'WANITA',
            'bayaran'   => '300000000',
            'award'     => '0',
            'negara'    => 'ID'
        ]);
    }
}
