<?php

namespace App\Http\Controllers;

use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KrsController extends Controller
{
    public function index(Request $request)
    {
        /** @var User $user */
        $user      = Auth::user();
        $search    = $request->keyword;
        $sort      = in_array($request->get('sort'), ['id', 'kode_matakuliah', 'nama_matakuliah', 'nama'])
                        ? $request->get('sort') : 'id';
        $direction = $request->get('direction') === 'asc' ? 'asc' : 'desc';

        $krs = Krs::select('krs.*')
            ->with(['mahasiswa', 'matakuliah'])
            ->leftJoin('matakuliah', 'krs.kode_matakuliah', 'matakuliah.kode_matakuliah')
            ->leftJoin('mahasiswa', 'krs.npm', 'mahasiswa.npm')
            ->when($user->isMahasiswa(), fn($q) => $q->where('krs.npm', $user->npm))
            ->when($search, function ($query, $search) use ($user) {
                $query->where(function ($q) use ($search, $user) {
                    $q->where('matakuliah.kode_matakuliah', 'like', "%{$search}%")
                       ->orWhere('matakuliah.nama_matakuliah', 'like', "%{$search}%");
                    if ($user->isAdmin()) {
                        $q->orWhere('mahasiswa.nama', 'like', "%{$search}%")
                           ->orWhere('mahasiswa.npm', 'like', "%{$search}%");
                    }
                });
            })
            ->when($sort === 'nama_matakuliah', function ($query) use ($direction) {
                return $query->orderBy('matakuliah.nama_matakuliah', $direction);
            }, function ($query) use ($sort, $direction) {
                if ($sort === 'nama') {
                    return $query->orderBy('mahasiswa.nama', $direction);
                }
                return $query->orderBy('krs.' . $sort, $direction);
            })
            ->paginate(10)
            ->withQueryString();

        return view('krs.index', compact('krs'));
    }

    public function create()
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->isMahasiswa()) {
            $mahasiswa   = Mahasiswa::findOrFail($user->npm);
            $takenKodes  = Krs::where('npm', $user->npm)->pluck('kode_matakuliah');
            $matakuliahs = Matakuliah::whereNotIn('kode_matakuliah', $takenKodes)
                            ->orderBy('nama_matakuliah')->get();
            return view('krs.create', compact('mahasiswa', 'matakuliahs'));
        }

        $mahasiswas  = Mahasiswa::orderBy('nama')->get();
        $matakuliahs = Matakuliah::orderBy('nama_matakuliah')->get();
        return view('krs.create', compact('mahasiswas', 'matakuliahs'));
    }

    public function store(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->isMahasiswa()) {
            $request->validate([
                'kode_matakuliah' => 'required|string|max:8|exists:matakuliah,kode_matakuliah',
            ]);

            $alreadyExists = Krs::where('npm', $user->npm)
                ->where('kode_matakuliah', $request->kode_matakuliah)
                ->exists();

            if ($alreadyExists) {
                return back()->withErrors([
                    'kode_matakuliah' => 'Mata kuliah ini sudah diambil.',
                ])->withInput();
            }

            Krs::create(['npm' => $user->npm, 'kode_matakuliah' => $request->kode_matakuliah]);
            return redirect()->route('krs.index')->with('success', 'KRS berhasil ditambahkan');
        }

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
        /** @var User $user */
        $user = Auth::user();
        $krsItem = Krs::findOrFail($id);

        if ($user->role === 'mahasiswa' && $krsItem->npm !== $user->npm) {
            return redirect()->route('krs.index')->with('error', 'Anda tidak berhak menghapus KRS ini.');
        }

        $krsItem->delete();
        return redirect()->route('krs.index')->with('success', 'KRS berhasil dihapus');
    }
}
