@extends('layouts.app')

@section('title', 'Edit Matakuliah')

@section('content')

<a href="{{ route('matakuliah.index') }}" class="back-link">
    <i class="fa-solid fa-arrow-left"></i> Kembali
</a>
<h1 class="page-title">Edit Matakuliah</h1>

<div class="form-card">
    <form action="{{ route('matakuliah.update', $matakuliah->kode_matakuliah) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="kode_matakuliah">Kode Matakuliah</label>
            <input type="text" id="kode_matakuliah" value="{{ $matakuliah->kode_matakuliah }}" class="form-control" disabled>
        </div>

        <div class="form-group">
            <label for="nama_matakuliah">Nama Matakuliah</label>
            <input type="text" id="nama_matakuliah" name="nama_matakuliah" value="{{ $matakuliah->nama_matakuliah }}" maxlength="50" class="form-control" required>
            @error('nama_matakuliah')<div class="form-error"><i class="fa-solid fa-circle-exclamation"></i>{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="sks">SKS</label>
            <input type="number" id="sks" name="sks" value="{{ $matakuliah->sks }}" min="1" max="6" class="form-control" required>
            @error('sks')<div class="form-error"><i class="fa-solid fa-circle-exclamation"></i>{{ $message }}</div>@enderror
        </div>

        <div class="form-footer">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fa-solid fa-floppy-disk"></i> Simpan
            </button>
        </div>
    </form>
</div>
@endsection
