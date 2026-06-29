<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Matakuliah;
use App\Models\Dosen;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        $search    = $request->keyword;
        $sort      = in_array($request->get('sort'), ['hari', 'kelas', 'jam_mulai', 'id'])
                        ? $request->get('sort') : 'id';
        $direction = $request->get('direction') === 'desc' ? 'desc' : 'asc';

        $jadwals = Jadwal::with(['matakuliah', 'dosen'])
            ->when($search, function ($query, $search) {
                return $query->where('kelas', 'like', "%{$search}%")
                    ->orWhere('hari', 'like', "%{$search}%")
                    ->orWhereHas('matakuliah', function ($q) use ($search) {
                        $q->where('nama_matakuliah', 'like', "%{$search}%")
                          ->orWhere('kode_matakuliah', 'like', "%{$search}%");
                    })
                    ->orWhereHas('dosen', function ($q) use ($search) {
                        $q->where('nama', 'like', "%{$search}%")
                          ->orWhere('nidn', 'like', "%{$search}%");
                    });
            })
            ->orderBy($sort, $direction)
            ->paginate(10)
            ->withQueryString();

        return view('jadwal.index', compact('jadwals'));
    }

    public function create()
    {
        $matakuliahs = Matakuliah::all();
        $dosens = Dosen::all();
        return view('jadwal.create', compact('matakuliahs', 'dosens'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_matakuliah' => 'required|string|max:8|exists:matakuliah,kode_matakuliah',
            'nidn'            => 'required|string|max:10|exists:dosen,nidn',
            'kelas'           => 'required|string|max:10',
            'hari'            => 'required|string|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai'       => 'required|date_format:H:i|after_or_equal:08:00|before_or_equal:20:00',
            'jam_selesai'     => 'required|date_format:H:i|after:jam_mulai|after_or_equal:08:00|before_or_equal:20:00',
        ]);

        Jadwal::create($request->all());
        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function edit(string $id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $matakuliahs = Matakuliah::all();
        $dosens = Dosen::all();
        return view('jadwal.edit', compact('jadwal', 'matakuliahs', 'dosens'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'kode_matakuliah' => 'required|string|max:8|exists:matakuliah,kode_matakuliah',
            'nidn'            => 'required|string|max:10|exists:dosen,nidn',
            'kelas'           => 'required|string|max:10',
            'hari'            => 'required|string|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai'       => 'required|date_format:H:i|after_or_equal:08:00|before_or_equal:20:00',
            'jam_selesai'     => 'required|date_format:H:i|after:jam_mulai|after_or_equal:08:00|before_or_equal:20:00',
        ]);

        $jadwal = Jadwal::findOrFail($id);
        $jadwal->update($request->only('kode_matakuliah', 'nidn', 'kelas', 'hari', 'jam_mulai', 'jam_selesai'));
        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->delete();
        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil dihapus');
    }
}
