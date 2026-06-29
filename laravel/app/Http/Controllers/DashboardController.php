<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use App\Models\Jadwal;
use App\Models\Krs;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $stats = [
            'dosen_aktif' => Dosen::count(),
            'mahasiswa_aktif' => Mahasiswa::count(),
            'matakuliah' => Matakuliah::count(),
            'jadwal' => Jadwal::count(),
            'krs' => Krs::count(),
        ];

        return view('dashboard.index', compact('stats'));
    }
}
