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

        <div class="form-group">
            <label for="npm">Mahasiswa</label>
            <select id="npm" name="npm" class="form-control" required>
                <option value="" disabled selected hidden>Pilih Mahasiswa</option>
                @foreach($mahasiswas as $mhs)
                <option value="{{ $mhs->npm }}">{{ $mhs->npm }} - {{ $mhs->nama }}</option>
                @endforeach
            </select>
            @error('npm')<div class="form-error"><i class="fa-solid fa-circle-exclamation"></i>{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="kode_matakuliah">Mata Kuliah</label>
            <select id="kode_matakuliah" name="kode_matakuliah" class="form-control" required>
                <option value="" disabled selected hidden>Pilih Mata Kuliah</option>
                @foreach($matakuliahs as $mk)
                <option value="{{ $mk->kode_matakuliah }}">{{ $mk->kode_matakuliah }} - {{ $mk->nama_matakuliah }} ({{ $mk->sks }} SKS)</option>
                @endforeach
            </select>
            @error('kode_matakuliah')<div class="form-error"><i class="fa-solid fa-circle-exclamation"></i>{{ $message }}</div>@enderror
        </div>

        <div class="form-footer">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fa-solid fa-floppy-disk"></i> Simpan
            </button>
        </div>
    </form>
</div>
@endsection
