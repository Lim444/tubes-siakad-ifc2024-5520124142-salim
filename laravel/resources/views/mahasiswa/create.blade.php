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
            <input type="text" id="npm" name="npm" maxlength="10" class="form-control" placeholder="Masukkan NPM" value="{{ old('npm') }}" required>
            @error('npm')<div class="form-error"><i class="fa-solid fa-circle-exclamation"></i>{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" id="nama" name="nama" maxlength="50" class="form-control" placeholder="Masukkan nama mahasiswa" value="{{ old('nama') }}" required>
            @error('nama')<div class="form-error"><i class="fa-solid fa-circle-exclamation"></i>{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="nidn">Dosen Wali</label>
            <select id="nidn" name="nidn" class="form-control" required>
                <option value="" disabled {{ old('nidn') ? '' : 'selected' }} hidden>Pilih Dosen</option>
                @foreach($dosens as $dosen)
                <option value="{{ $dosen->nidn }}" {{ old('nidn') == $dosen->nidn ? 'selected' : '' }}>{{ $dosen->nidn }} - {{ $dosen->nama }}</option>
                @endforeach
            </select>
            @error('nidn')<div class="form-error"><i class="fa-solid fa-circle-exclamation"></i>{{ $message }}</div>@enderror
        </div>

        <hr style="margin:24px 0; border-color:#e2e8f0;">
        <h3 style="margin-bottom:12px;">Akun Login Mahasiswa</h3>

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" maxlength="50" class="form-control" placeholder="Contoh: 5520124142" value="{{ old('username') }}" required>
            <small style="display:block; margin-top:6px; color:#64748b;">Contoh username: NPM mahasiswa</small>
            @error('username')<div class="form-error"><i class="fa-solid fa-circle-exclamation"></i>{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control" placeholder="Contoh: salimakbar142@siak.ac.id" value="{{ old('email') }}" required>
            <small style="display:block; margin-top:6px; color:#64748b;">Contoh email: nama lengkap + 3 digit NPM terakhir@siak.ac.id</small>
            @error('email')<div class="form-error"><i class="fa-solid fa-circle-exclamation"></i>{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Buat password" value="{{ old('password') }}" required>
            @error('password')<div class="form-error"><i class="fa-solid fa-circle-exclamation"></i>{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Ulangi password" value="{{ old('password_confirmation') }}" required>
        </div>

        <div class="form-footer">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fa-solid fa-floppy-disk"></i> Simpan
            </button>
        </div>
    </form>
</div>
@endsection
