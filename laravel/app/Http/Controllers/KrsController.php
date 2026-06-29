<?php

namespace App\Http\Controllers;

use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use Illuminate\Http\Request;

class KrsController extends Controller
{
    public function index(Request $request)
    {
        $search    = $request->keyword;
        $sort      = in_array($request->get('sort'), ['id', 'kode_matakuliah'])
                        ? $request->get('sort') : 'id';
        $direction = $request->get('direction') === 'asc' ? 'asc' : 'desc';

        $krs = Krs::with(['mahasiswa', 'matakuliah'])
            ->when($search, function ($query, $search) {
                return $query->whereHas('matakuliah', function ($q) use ($search) {
                        $q->where('kode_matakuliah', 'like', "%{$search}%")
                          ->orWhere('nama_matakuliah', 'like', "%{$search}%");
                    })
                    ->orWhereHas('mahasiswa', function ($q) use ($search) {
                        $q->where('nama', 'like', "%{$search}%")
                          ->orWhere('npm', 'like', "%{$search}%");
                    });
            })
            ->orderBy($sort, $direction)
            ->paginate(10)
            ->withQueryString();

        return view('krs.index', compact('krs'));
    }

    public function create()
    {
        $mahasiswas  = Mahasiswa::all();
        $matakuliahs = Matakuliah::all();
        return view('krs.create', compact('mahasiswas', 'matakuliahs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'npm'             => 'required|string|max:10|exists:mahasiswa,npm',
            'kode_matakuliah' => 'required|string|max:8|exists:matakuliah,kode_matakuliah',
        ]);

        Krs::create($request->all());
        return redirect()->route('krs.index')->with('success', 'KRS berhasil ditambahkan');
    }

    public function edit(string $id)
    {
        $krsItem     = Krs::findOrFail($id);
        $mahasiswas  = Mahasiswa::all();
        $matakuliahs = Matakuliah::all();
        return view('krs.edit', compact('krsItem', 'mahasiswas', 'matakuliahs'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'npm'             => 'required|string|max:10|exists:mahasiswa,npm',
            'kode_matakuliah' => 'required|string|max:8|exists:matakuliah,kode_matakuliah',
        ]);

        $krsItem = Krs::findOrFail($id);
        $krsItem->update($request->only('npm', 'kode_matakuliah'));
        return redirect()->route('krs.index')->with('success', 'KRS berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $krsItem = Krs::findOrFail($id);
        $krsItem->delete();
        return redirect()->route('krs.index')->with('success', 'KRS berhasil dihapus');
    }
}
