@extends('layouts.app')

@section('title', 'Tambah Dosen')

@section('content')

<a href="{{ route('dosen.index') }}" class="back-link">
    <i class="fa-solid fa-arrow-left"></i> Kembali
</a>
<h1 class="page-title">Tambah Dosen</h1>

<div class="form-card">
    <form action="{{ route('dosen.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="nidn">NIDN</label>
            <input type="text" id="nidn" name="nidn" maxlength="10" class="form-control" placeholder="Masukkan NIDN" required>
            @error('nidn')<div class="form-error"><i class="fa-solid fa-circle-exclamation"></i>{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" id="nama" name="nama" maxlength="50" class="form-control" placeholder="Masukkan nama dosen" required>
            @error('nama')<div class="form-error"><i class="fa-solid fa-circle-exclamation"></i>{{ $message }}</div>@enderror
        </div>

        <div class="form-footer">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fa-solid fa-floppy-disk"></i> Simpan
            </button>
        </div>
    </form>
</div>
@endsection
