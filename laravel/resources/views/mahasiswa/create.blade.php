@extends('layouts.app')

@section('title', 'Tambah Mahasiswa')

@section('content')

<a href="{{ route('mahasiswa.index') }}" class="back-link">
    <i class="fa-solid fa-arrow-left"></i> Kembali
</a>
<h1 class="page-title">Tambah Mahasiswa</h1>

<div class="form-card">
    <form action="{{ route('mahasiswa.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="npm">NPM</label>
            <input type="text" id="npm" name="npm" maxlength="10" class="form-control" placeholder="Masukkan NPM" required>
            @error('npm')<div class="form-error"><i class="fa-solid fa-circle-exclamation"></i>{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" id="nama" name="nama" maxlength="50" class="form-control" placeholder="Masukkan nama mahasiswa" required>
            @error('nama')<div class="form-error"><i class="fa-solid fa-circle-exclamation"></i>{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="nidn">Dosen Wali</label>
            <select id="nidn" name="nidn" class="form-control" required>
                <option value="" disabled selected hidden>Pilih Dosen</option>
                @foreach($dosens as $dosen)
                <option value="{{ $dosen->nidn }}">{{ $dosen->nidn }} - {{ $dosen->nama }}</option>
                @endforeach
            </select>
            @error('nidn')<div class="form-error"><i class="fa-solid fa-circle-exclamation"></i>{{ $message }}</div>@enderror
        </div>

        <div class="form-footer">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fa-solid fa-floppy-disk"></i> Simpan
            </button>
        </div>
    </form>
</div>
@endsection
