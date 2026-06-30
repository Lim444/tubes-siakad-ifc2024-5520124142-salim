<?php

namespace Tests\Feature;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class MahasiswaCreationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_mahasiswa_and_user_account(): void
    {
        Dosen::create([
            'nidn' => 'D001',
            'nama' => 'Dr. Satu',
        ]);

        $admin = User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        $this->actingAs($admin);

        $response = $this->post('/mahasiswa', [
            'npm' => '5520124143',
            'nidn' => 'D001',
            'nama' => 'Budi',
            'username' => 'budi',
            'email' => 'budi@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/mahasiswa');
        $this->assertDatabaseHas('mahasiswa', ['npm' => '5520124143', 'nama' => 'Budi']);
        $this->assertDatabaseHas('users', ['username' => 'budi', 'npm' => '5520124143', 'role' => 'mahasiswa']);
        $this->assertTrue(User::where('username', 'budi')->first()->isMahasiswa());
    }
}
