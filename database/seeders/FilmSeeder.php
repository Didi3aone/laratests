<?php

namespace Database\Seeders;

use App\Models\Film;
use Illuminate\Database\Seeder;

class FilmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Film::create([
            'kd_film'       => 'F001',
            'nm_film'       => 'IRON MAN',
            'genre'         => 'G001',
            'artis'         => 'A001',
            'produser'      => 'PD01',
            'pendapatan'    => '2000000000',
            'nominasi'      => '3'
        ]);

        Film::create([
            'kd_film'       => 'F002',
            'nm_film'       => 'IRON MAN 2',
            'genre'         => 'G001',
            'artis'         => 'A001',
            'produser'      => 'PD01',
            'pendapatan'    => '1800000000',
            'nominasi'      => '2'
        ]);

        Film::create([
            'kd_film'       => 'F003',
            'nm_film'       => 'IRON MAN 3',
            'genre'         => 'G001',
            'artis'         => 'A001',
            'produser'      => 'PD01',
            'pendapatan'    => '1200000000',
            'nominasi'      => '0'
        ]);

        Film::create([
            'kd_film'       => 'F004',
            'nm_film'       => 'AVENGER CIVIL WAR',
            'genre'         => 'G001',
            'artis'         => 'A001',
            'produser'      => 'PD01',
            'pendapatan'    => '2000000000',
            'nominasi'      => '1'
        ]);

        Film::create([
            'kd_film'       => 'F005',
            'nm_film'       => 'SPIDERMAN HOME COMMING',
            'genre'         => 'G001',
            'artis'         => 'A001',
            'produser'      => 'PD01',
            'pendapatan'    => '1300000000',
            'nominasi'      => '0'
        ]);

        Film::create([
            'kd_film'       => 'F006',
            'nm_film'       => 'THE RAID',
            'genre'         => 'G001',
            'artis'         => 'A004',
            'produser'      => 'PD03',
            'pendapatan'    => '800000000',
            'nominasi'      => '5'
        ]);

        Film::create([
            'kd_film'       => 'F007',
            'nm_film'       => 'FAST & FOURIOUS',
            'genre'         => 'G001',
            'artis'         => 'A004',
            'produser'      => 'PD05',
            'pendapatan'    => '830000000',
            'nominasi'      => '2'
        ]);

        Film::create([
            'kd_film'       => 'F008',
            'nm_film'       => 'HABIBIE & AINUN',
            'genre'         => 'G004',
            'artis'         => 'A005',
            'produser'      => 'PD03',
            'pendapatan'    => '670000000',
            'nominasi'      => '4'
        ]);

        Film::create([
            'kd_film'       => 'F009',
            'nm_film'       => 'POLICE STORY',
            'genre'         => 'G001',
            'artis'         => 'A003',
            'produser'      => 'PD02',
            'pendapatan'    => '700000000',
            'nominasi'      => '3'
        ]);

        Film::create([
            'kd_film'       => 'F010',
            'nm_film'       => 'POLICE STORY 2',
            'genre'         => 'G001',
            'artis'         => 'A003',
            'produser'      => 'PD02',
            'pendapatan'    => '710000000',
            'nominasi'      => '1'
        ]);

        Film::create([
            'kd_film'       => 'F011',
            'nm_film'       => 'POLICE STORY 3',
            'genre'         => 'G001',
            'artis'         => 'A003',
            'produser'      => 'PD02',
            'pendapatan'    => '615000000',
            'nominasi'      => '0'
        ]);

        Film::create([
            'kd_film'       => 'F012',
            'nm_film'       => 'RUSH HOUR',
            'genre'         => 'G003',
            'artis'         => 'A003',
            'produser'      => 'PD05',
            'pendapatan'    => '695000000',
            'nominasi'      => '2'
        ]);

        Film::create([
            'kd_film'       => 'F013',
            'nm_film'       => 'KUNGFU PANDA',
            'genre'         => 'G003',
            'artis'         => 'A003',
            'produser'      => 'PD05',
            'pendapatan'    => '923000000',
            'nominasi'      => '5'
        ]);
    }
}
