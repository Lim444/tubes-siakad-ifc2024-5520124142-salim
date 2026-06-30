<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class JadwalSeeder extends Seeder
{
    public function run(): void
    {
        $faker     = Faker::create('id_ID');
        $dosenList = DB::table('dosen')->pluck('nidn')->toArray();
        $matkuls   = DB::table('matakuliah')->select('kode_matakuliah', 'sks')->get()->toArray();
        $hariList  = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $kelasList = ['A', 'B', 'C', 'D'];

        foreach ($matkuls as $matkul) {
            $durasiMenit  = $matkul->sks * 50;
            $minStart     = 8 * 60;
            $maxStart     = (20 * 60) - $durasiMenit;
            $startMinutes = rand($minStart, $maxStart);
            $endMinutes   = $startMinutes + $durasiMenit;

            $jamMulai   = sprintf('%02d:%02d', intdiv($startMinutes, 60), $startMinutes % 60);
            $jamSelesai = sprintf('%02d:%02d', intdiv($endMinutes, 60), $endMinutes % 60);

            DB::table('jadwal')->insert([
                'kode_matakuliah' => $matkul->kode_matakuliah,
                'nidn'            => $faker->randomElement($dosenList),
                'kelas'           => $faker->randomElement($kelasList),
                'hari'            => $faker->randomElement($hariList),
                'jam_mulai'       => $jamMulai,
                'jam_selesai'     => $jamSelesai,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        }

        for ($i = 0; $i < 10; $i++) {
            $matkul       = $faker->randomElement($matkuls);
            $durasiMenit  = $matkul->sks * 50;
            $minStart     = 8 * 60;
            $maxStart     = (20 * 60) - $durasiMenit;
            $startMinutes = rand($minStart, $maxStart);
            $endMinutes   = $startMinutes + $durasiMenit;

            $jamMulai   = sprintf('%02d:%02d', intdiv($startMinutes, 60), $startMinutes % 60);
            $jamSelesai = sprintf('%02d:%02d', intdiv($endMinutes, 60), $endMinutes % 60);

            DB::table('jadwal')->insert([
                'kode_matakuliah' => $matkul->kode_matakuliah,
                'nidn'            => $faker->randomElement($dosenList),
                'kelas'           => $faker->randomElement($kelasList),
                'hari'            => $faker->randomElement($hariList),
                'jam_mulai'       => $jamMulai,
                'jam_selesai'     => $jamSelesai,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        }
    }
}
