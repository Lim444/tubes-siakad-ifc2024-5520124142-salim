@extends('layouts.app')

@section('title', 'Edit Dosen')

@section('content')

<a href="{{ route('dosen.index') }}" class="back-link">
    <i class="fa-solid fa-arrow-left"></i> Kembali
</a>
<h1 class="page-title">Edit Dosen</h1>

<div class="form-card">
    <form action="{{ route('dosen.update', $dosen->nidn) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nidn">NIDN</label>
            <input type="text" id="nidn" value="{{ $dosen->nidn }}" class="form-control" disabled>
        </div>

        <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" id="nama" name="nama" value="{{ $dosen->nama }}" maxlength="50" class="form-control" required>
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
