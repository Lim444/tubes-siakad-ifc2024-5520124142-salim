<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $search    = $request->keyword;
        $sort      = in_array($request->get('sort'), ['npm', 'nama', 'dosen']) ? $request->get('sort') : 'npm';
        $direction = $request->get('direction') === 'desc' ? 'desc' : 'asc';

        $mahasiswas = Mahasiswa::select('mahasiswa.*')
            ->with('dosen')
            ->leftJoin('dosen', 'mahasiswa.nidn', 'dosen.nidn')
            ->when($search, function ($query, $search) {
                return $query->where('mahasiswa.npm', 'like', "%{$search}%")
                    ->orWhere('mahasiswa.nama', 'like', "%{$search}%")
                    ->orWhere('dosen.nama', 'like', "%{$search}%");
            })
            ->when($sort === 'dosen', function ($query) use ($direction) {
                return $query->orderBy('dosen.nama', $direction);
            }, function ($query) use ($sort, $direction) {
                return $query->orderBy('mahasiswa.' . $sort, $direction);
            })
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
            'npm' => 'required|string|max:10|unique:mahasiswa,npm',
            'nidn' => 'required|string|max:10|exists:dosen,nidn',
            'nama' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|max:50|unique:users,username',
            'password' => 'required|string|min:5|confirmed',
        ]);

        Mahasiswa::create([
            'npm' => $request->npm,
            'nidn' => $request->nidn,
            'nama' => $request->nama,
        ]);

        User::create([
            'name' => $request->nama,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'mahasiswa',
            'npm' => $request->npm,
        ]);

        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa dan akun berhasil ditambahkan');
    }

    public function edit(string $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $dosens = Dosen::all();
        $user = User::where('npm', $mahasiswa->npm)->first();
        return view('mahasiswa.edit', compact('mahasiswa', 'dosens', 'user'));
    }

    public function update(Request $request, string $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $user = User::where('npm', $mahasiswa->npm)->first();

        $request->validate([
            'nidn' => 'required|string|max:10|exists:dosen,nidn',
            'nama' => 'required|string|max:50',
            'username' => 'nullable|string|max:50|unique:users,username,' . ($user?->id ?? 'null') . ',id',
            'email' => 'nullable|email|unique:users,email,' . ($user?->id ?? 'null') . ',id',
            'password' => 'nullable|string|min:5|confirmed',
        ]);

        $mahasiswa->update($request->only('nidn', 'nama'));

        if ($user) {
            $userData = [
                'name' => $request->nama,
                'username' => $request->username ?? $user->username,
                'email' => $request->email ?? $user->email,
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $user->update($userData);
        }

        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa dan akun berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->delete();
        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil dihapus');
    }
}
