<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class MatakuliahSeeder extends Seeder
{
    public function run(): void
    {
        $manual = [
            ['kode' => 'IF1101', 'nama' => 'Algoritma dan Pemrograman', 'sks' => 3],
            ['kode' => 'IF1102', 'nama' => 'Struktur Data', 'sks' => 3],
            ['kode' => 'IF1103', 'nama' => 'Basis Data', 'sks' => 3],
            ['kode' => 'IF1104', 'nama' => 'Jaringan Komputer', 'sks' => 3],
            ['kode' => 'IF1105', 'nama' => 'Sistem Operasi', 'sks' => 3],
            ['kode' => 'IF1106', 'nama' => 'Pemrograman Web', 'sks' => 3],
            ['kode' => 'IF1107', 'nama' => 'Rekayasa Perangkat Lunak', 'sks' => 3],
            ['kode' => 'IF1108', 'nama' => 'Kecerdasan Buatan', 'sks' => 3],
            ['kode' => 'IF1109', 'nama' => 'Keamanan Informasi', 'sks' => 2],
            ['kode' => 'IF1110', 'nama' => 'Pemrograman Mobile', 'sks' => 2],
        ];

        foreach ($manual as $mk) {
            DB::table('matakuliah')->insert([
                'kode_matakuliah' => $mk['kode'],
                'nama_matakuliah' => $mk['nama'],
                'sks' => $mk['sks'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $faker = Faker::create('id_ID');
        for ($i = 0; $i < 10; $i++) {
            DB::table('matakuliah')->insert([
                'kode_matakuliah' => $faker->unique()->bothify('IF#####'),
                'nama_matakuliah' => $faker->word(),
                'sks' => $faker->numberBetween(1, 3),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}