@extends('layouts.app')

@section('title', 'Edit Mahasiswa')

@section('content')

<a href="{{ route('mahasiswa.index') }}" class="back-link">
    <i class="fa-solid fa-arrow-left"></i> Kembali
</a>
<h1 class="page-title">Edit Mahasiswa</h1>

<div class="form-card">
    <form action="{{ route('mahasiswa.update', $mahasiswa->npm) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="npm">NPM</label>
            <input type="text" id="npm" value="{{ $mahasiswa->npm }}" class="form-control" disabled>
        </div>

        <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" id="nama" name="nama" value="{{ $mahasiswa->nama }}" maxlength="50" class="form-control" required>
            @error('nama')<div class="form-error"><i class="fa-solid fa-circle-exclamation"></i>{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="nidn">Dosen Wali</label>
            <select id="nidn" name="nidn" class="form-control" required>
                <option value="" disabled hidden>Pilih Dosen</option>
                @foreach($dosens as $dosen)
                <option value="{{ $dosen->nidn }}" {{ $mahasiswa->nidn == $dosen->nidn ? 'selected' : '' }}>{{ $dosen->nidn }} - {{ $dosen->nama }}</option>
                @endforeach
            </select>
            @error('nidn')<div class="form-error"><i class="fa-solid fa-circle-exclamation"></i>{{ $message }}</div>@enderror
        </div>

        <hr style="margin:24px 0; border-color:#e2e8f0;">
        <h3 style="margin-bottom:12px;">Akun Login Mahasiswa</h3>

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="{{ old('username', $user->username ?? '') }}" maxlength="50" class="form-control" placeholder="Contoh: 5520124142">
            @error('username')<div class="form-error"><i class="fa-solid fa-circle-exclamation"></i>{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email ?? '') }}" class="form-control" placeholder="Contoh: salimakbar142@siak.ac.id">
            @error('email')<div class="form-error"><i class="fa-solid fa-circle-exclamation"></i>{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="password">Password Baru</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah password">
            @error('password')<div class="form-error"><i class="fa-solid fa-circle-exclamation"></i>{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">Konfirmasi Password Baru</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Ulangi password baru">
        </div>

        <div class="form-footer">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fa-solid fa-floppy-disk"></i> Simpan
            </button>
        </div>
    </form>
</div>
@endsection
