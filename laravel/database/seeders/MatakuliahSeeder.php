<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MatakuliahSeeder extends Seeder
{
    public function run(): void
    {
        $matakuliah = [
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
            ['kode' => 'IF1111', 'nama' => 'Komputasi Awan', 'sks' => 2],
            ['kode' => 'IF1112', 'nama' => 'Machine Learning', 'sks' => 3],
            ['kode' => 'IF1113', 'nama' => 'Pengolahan Citra Digital', 'sks' => 3],
            ['kode' => 'IF1114', 'nama' => 'Pemrograman Berorientasi Objek', 'sks' => 3],
            ['kode' => 'IF1115', 'nama' => 'Sistem Informasi Manajemen', 'sks' => 3],
            ['kode' => 'IF1116', 'nama' => 'Analisis dan Desain Sistem', 'sks' => 3],
            ['kode' => 'IF1117', 'nama' => 'Matematika Diskrit', 'sks' => 2],
            ['kode' => 'IF1118', 'nama' => 'Aljabar Linear dan Matriks', 'sks' => 2],
            ['kode' => 'IF1119', 'nama' => 'Statistika dan Probabilitas', 'sks' => 2],
            ['kode' => 'IF1120', 'nama' => 'Etika Profesi Teknologi Informasi', 'sks' => 2],
        ];

        foreach ($matakuliah as $mk) {
            DB::table('matakuliah')->insert([
                'kode_matakuliah' => $mk['kode'],
                'nama_matakuliah' => $mk['nama'],
                'sks'             => $mk['sks'],
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        }
    }
}
