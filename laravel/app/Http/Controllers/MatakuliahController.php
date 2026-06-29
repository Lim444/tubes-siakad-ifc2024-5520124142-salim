<?php

namespace App\Http\Controllers;

use App\Models\Matakuliah;
use Illuminate\Http\Request;

class MatakuliahController extends Controller
{
    public function index(Request $request)
    {
        $search    = $request->keyword;
        $sort      = in_array($request->get('sort'), ['kode_matakuliah', 'nama_matakuliah', 'sks'])
                        ? $request->get('sort') : 'kode_matakuliah';
        $direction = $request->get('direction') === 'desc' ? 'desc' : 'asc';

        $matakuliahs = Matakuliah::when($search, function ($query, $search) {
                return $query->where('kode_matakuliah', 'like', "%{$search}%")
                    ->orWhere('nama_matakuliah', 'like', "%{$search}%")
                    ->orWhere('sks', 'like', "%{$search}%");
            })
            ->orderBy($sort, $direction)
            ->paginate(10)
            ->withQueryString();

        return view('matakuliah.index', compact('matakuliahs'));
    }

    public function create()
    {
        return view('matakuliah.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_matakuliah' => 'required|string|max:8|unique:matakuliah,kode_matakuliah',
            'nama_matakuliah' => 'required|string|max:50',
            'sks'             => 'required|integer|min:1|max:6',
        ]);

        Matakuliah::create($request->all());
        return redirect()->route('matakuliah.index')->with('success', 'Matakuliah berhasil ditambahkan');
    }

    public function edit(string $id)
    {
        $matakuliah = Matakuliah::findOrFail($id);
        return view('matakuliah.edit', compact('matakuliah'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_matakuliah' => 'required|string|max:50',
            'sks'             => 'required|integer|min:1|max:6',
        ]);

        $matakuliah = Matakuliah::findOrFail($id);
        $matakuliah->update($request->only('nama_matakuliah', 'sks'));
        return redirect()->route('matakuliah.index')->with('success', 'Matakuliah berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $matakuliah = Matakuliah::findOrFail($id);
        $matakuliah->delete();
        return redirect()->route('matakuliah.index')->with('success', 'Matakuliah berhasil dihapus');
    }
}
