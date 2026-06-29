<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class KrsSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $npmList = DB::table('mahasiswa')->pluck('npm')->toArray();
        $mkList = DB::table('matakuliah')->pluck('kode_matakuliah')->toArray();

        for ($i = 0; $i < 5; $i++) {
            DB::table('krs')->insert([
                'npm' => $faker->randomElement($npmList),
                'kode_matakuliah' => $faker->randomElement($mkList),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}