<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use Illuminate\Http\Request;

class DosenController extends Controller
{
    public function index(Request $request)
    {
        $search    = $request->keyword;
        $sort      = in_array($request->get('sort'), ['nidn', 'nama']) ? $request->get('sort') : 'nidn';
        $direction = $request->get('direction') === 'desc' ? 'desc' : 'asc';

        $dosens = Dosen::when($search, function ($query, $search) {
                return $query->where('nidn', 'like', "%{$search}%")
                    ->orWhere('nama', 'like', "%{$search}%");
            })
            ->orderBy($sort, $direction)
            ->paginate(10)
            ->withQueryString();

        return view('dosen.index', compact('dosens'));
    }

    public function create()
    {
        return view('dosen.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nidn' => 'required|string|max:10|unique:dosen,nidn',
            'nama' => 'required|string|max:50',
        ]);

        Dosen::create($request->all());
        return redirect()->route('dosen.index')->with('success', 'Dosen berhasil ditambahkan');
    }

    public function edit(string $id)
    {
        $dosen = Dosen::findOrFail($id);
        return view('dosen.edit', compact('dosen'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required|string|max:50',
        ]);

        $dosen = Dosen::findOrFail($id);
        $dosen->update($request->only('nama'));
        return redirect()->route('dosen.index')->with('success', 'Dosen berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $dosen = Dosen::findOrFail($id);
        $dosen->delete();
        return redirect()->route('dosen.index')->with('success', 'Dosen berhasil dihapus');
    }
}
