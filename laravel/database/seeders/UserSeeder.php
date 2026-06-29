<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'username' => 'admin',
            'email' => 'admin@siak.ac.id',
            'password' => Hash::make('12345'),
            'role' => 'admin',
            'name' => 'Administrator',
        ]);

        User::create([
            'username' => 'mhs1',
            'email' => 'mhs1@siak.ac.id',
            'password' => Hash::make('12345'),
            'role' => 'mahasiswa',
            'name' => 'Salim Akbar',
        ]);
    }
}
