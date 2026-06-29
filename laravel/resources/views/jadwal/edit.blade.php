@extends('layouts.app')

@section('title', 'Edit Jadwal')

@section('content')

<a href="{{ route('jadwal.index') }}" class="back-link">
    <i class="fa-solid fa-arrow-left"></i> Kembali
</a>
<h1 class="page-title">Edit Jadwal</h1>

<div class="form-card">
    <form action="{{ route('jadwal.update', $jadwal->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="kode_matakuliah">Mata Kuliah</label>
            <select id="kode_matakuliah" name="kode_matakuliah" class="form-control" required>
                <option value="" disabled hidden>Pilih Mata Kuliah</option>
                @foreach($matakuliahs as $mk)
                <option value="{{ $mk->kode_matakuliah }}"
                    {{ (old('kode_matakuliah', $jadwal->kode_matakuliah) == $mk->kode_matakuliah) ? 'selected' : '' }}>
                    {{ $mk->kode_matakuliah }} - {{ $mk->nama_matakuliah }}
                </option>
                @endforeach
            </select>
            @error('kode_matakuliah')<div class="form-error"><i class="fa-solid fa-circle-exclamation"></i>{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="nidn">Dosen</label>
            <select id="nidn" name="nidn" class="form-control" required>
                <option value="" disabled hidden>Pilih Dosen</option>
                @foreach($dosens as $dosen)
                <option value="{{ $dosen->nidn }}"
                    {{ (old('nidn', $jadwal->nidn) == $dosen->nidn) ? 'selected' : '' }}>
                    {{ $dosen->nidn }} - {{ $dosen->nama }}
                </option>
                @endforeach
            </select>
            @error('nidn')<div class="form-error"><i class="fa-solid fa-circle-exclamation"></i>{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="kelas">Kelas</label>
            <input type="text"
                   id="kelas"
                   name="kelas"
                   class="form-control"
                   placeholder="Contoh: A, B, C, 1A, 2B ..."
                   value="{{ old('kelas', $jadwal->kelas) }}"
                   maxlength="10"
                   required>
            @error('kelas')<div class="form-error"><i class="fa-solid fa-circle-exclamation"></i>{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="hari">Hari</label>
            <select id="hari" name="hari" class="form-control" required>
                <option value="" disabled hidden>Pilih Hari</option>
                @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $h)
                <option value="{{ $h }}" {{ (old('hari', $jadwal->hari) == $h) ? 'selected' : '' }}>{{ $h }}</option>
                @endforeach
            </select>
            @error('hari')<div class="form-error"><i class="fa-solid fa-circle-exclamation"></i>{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="jam_mulai">Jam Mulai</label>
            <input type="time" id="jam_mulai" name="jam_mulai"
                   value="{{ old('jam_mulai', \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i')) }}"
                   min="08:00" max="20:00" step="60" class="form-control" required>
            @error('jam_mulai')<div class="form-error"><i class="fa-solid fa-circle-exclamation"></i>{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="jam_selesai">Jam Selesai</label>
            <input type="time" id="jam_selesai" name="jam_selesai"
                   value="{{ old('jam_selesai', \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i')) }}"
                   min="08:00" max="20:00" step="60" class="form-control" required>
            @error('jam_selesai')<div class="form-error"><i class="fa-solid fa-circle-exclamation"></i>{{ $message }}</div>@enderror
        </div>

        <div class="form-footer">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
