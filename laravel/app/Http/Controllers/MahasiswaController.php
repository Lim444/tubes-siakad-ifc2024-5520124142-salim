<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Dosen;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $search    = $request->keyword;
        $sort      = in_array($request->get('sort'), ['npm', 'nama']) ? $request->get('sort') : 'npm';
        $direction = $request->get('direction') === 'desc' ? 'desc' : 'asc';

        $mahasiswas = Mahasiswa::with('dosen')
            ->when($search, function ($query, $search) {
                return $query->where('npm', 'like', "%{$search}%")
                    ->orWhere('nama', 'like', "%{$search}%")
                    ->orWhereHas('dosen', function ($q) use ($search) {
                        $q->where('nama', 'like', "%{$search}%");
                    });
            })
            ->orderBy($sort, $direction)
            ->paginate(10)
            ->withQueryString();

        return view('mahasiswa.index', compact('mahasiswas'));
    }

    public function create()
    {
        $dosens = Dosen::all();
        return view('mahasiswa.create', compact('dosens'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'npm'  => 'required|string|max:10|unique:mahasiswa,npm',
            'nidn' => 'required|string|max:10|exists:dosen,nidn',
            'nama' => 'required|string|max:50',
        ]);

        Mahasiswa::create($request->all());
        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil ditambahkan');
    }

    public function edit(string $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $dosens = Dosen::all();
        return view('mahasiswa.edit', compact('mahasiswa', 'dosens'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nidn' => 'required|string|max:10|exists:dosen,nidn',
            'nama' => 'required|string|max:50',
        ]);

        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->update($request->only('nidn', 'nama'));
        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->delete();
        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil dihapus');
    }
}
