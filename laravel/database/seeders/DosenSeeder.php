<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class DosenSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $gelar = ['M.Kom.', 'M.T.', 'M.Sc.', 'M.A.', 'M.Si.', 'M.M.'];
        for ($i = 0; $i < 10; $i++) {
            DB::table('dosen')->insert([
                'nidn' => $faker->unique()->numerify('#####'),
                'nama' => $faker->name() . ', ' . $faker->randomElement($gelar),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}