<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class MahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $dosenList = DB::table('dosen')->pluck('nidn')->toArray();
        $kodeJurusan = '55201';

        DB::table('mahasiswa')->insert([
            'npm' => '5520124142',
            'nidn' => $faker->randomElement($dosenList),
            'nama' => 'Salim Akbar',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        for ($i = 0; $i < 49; $i++) {
            $angkatan = rand(21, 25);
            $urutan = str_pad($i, 3, '0', STR_PAD_LEFT);
            $npm = $kodeJurusan . $angkatan . $urutan;
            DB::table('mahasiswa')->insert([
                'npm' => $npm,
                'nidn' => $faker->randomElement($dosenList),
                'nama' => $faker->name(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}