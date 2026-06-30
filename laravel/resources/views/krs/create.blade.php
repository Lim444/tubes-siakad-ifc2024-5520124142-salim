@extends('layouts.app')

@section('title', 'Tambah KRS')

@section('content')

<a href="{{ route('krs.index') }}" class="back-link">
    <i class="fa-solid fa-arrow-left"></i> Kembali
</a>
<h1 class="page-title">Tambah KRS</h1>

<div class="form-card">
    <form action="{{ route('krs.store') }}" method="POST">
        @csrf

        @if(Auth::user()->isAdmin())

            <div class="form-group">
                <label for="npm">Mahasiswa</label>
                <select id="npm" name="npm" class="form-control" required>
                    <option value="" disabled selected hidden>Pilih Mahasiswa</option>
                    @foreach($mahasiswas as $mhs)
                    <option value="{{ $mhs->npm }}" {{ old('npm') == $mhs->npm ? 'selected' : '' }}>
                        {{ $mhs->npm }} &mdash; {{ $mhs->nama }}
                    </option>
                    @endforeach
                </select>
                @error('npm')<div class="form-error"><i class="fa-solid fa-circle-exclamation"></i>{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="kode_matakuliah">Mata Kuliah</label>
                <select id="kode_matakuliah" name="kode_matakuliah" class="form-control" required>
                    <option value="" disabled selected hidden>Pilih Mata Kuliah</option>
                    @foreach($matakuliahs as $mk)
                    <option value="{{ $mk->kode_matakuliah }}" {{ old('kode_matakuliah') == $mk->kode_matakuliah ? 'selected' : '' }}>
                        {{ $mk->kode_matakuliah }} &mdash; {{ $mk->nama_matakuliah }} ({{ $mk->sks }} SKS)
                    </option>
                    @endforeach
                </select>
                @error('kode_matakuliah')<div class="form-error"><i class="fa-solid fa-circle-exclamation"></i>{{ $message }}</div>@enderror
            </div>

        @else

            <div class="form-group">
                <label>Mahasiswa</label>
                <input type="text" class="form-control"
                       value="{{ $mahasiswa->npm }} &mdash; {{ $mahasiswa->nama }}"
                       readonly style="background:#f4f6fa; color:#555; cursor:default;">
            </div>

            <div class="form-group">
                <label for="kode_matakuliah">Mata Kuliah yang Tersedia</label>
                @if($matakuliahs->isEmpty())
                    <div class="alert alert-warning" style="margin-top:4px;">
                        <i class="fa-solid fa-triangle-exclamation fa-sm"></i>
                        Semua mata kuliah yang tersedia sudah diambil. Tidak ada mata kuliah yang bisa ditambahkan.
                    </div>
                @else
                    <select id="kode_matakuliah" name="kode_matakuliah" class="form-control" required>
                        <option value="" disabled selected hidden>Pilih Mata Kuliah</option>
                        @foreach($matakuliahs as $mk)
                        <option value="{{ $mk->kode_matakuliah }}" {{ old('kode_matakuliah') == $mk->kode_matakuliah ? 'selected' : '' }}>
                            {{ $mk->kode_matakuliah }} &mdash; {{ $mk->nama_matakuliah }} ({{ $mk->sks }} SKS)
                        </option>
                        @endforeach
                    </select>
                    @error('kode_matakuliah')<div class="form-error"><i class="fa-solid fa-circle-exclamation"></i>{{ $message }}</div>@enderror
                @endif
            </div>

        @endif

        @if(Auth::user()->isAdmin() || !$matakuliahs->isEmpty())
        <div class="form-footer">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fa-solid fa-floppy-disk"></i> Simpan
            </button>
        </div>
        @endif

    </form>
</div>
@endsection
