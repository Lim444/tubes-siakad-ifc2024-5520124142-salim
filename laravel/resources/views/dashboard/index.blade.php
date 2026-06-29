@extends('layouts.app')

@section('title', 'Beranda - SIAK')

@section('content')

{{-- Selamat Datang Banner --}}
<div style="
    background: linear-gradient(135deg, #1e5bb8 0%, #1344a0 100%);
    border-radius: 10px;
    padding: 24px 28px;
    margin-bottom: 28px;
    display: flex;
    align-items: center;
    gap: 18px;
    color: white;
    box-shadow: 0 4px 14px rgba(30,91,184,.3);
">
    <div style="
        background: rgba(255,255,255,.15);
        border-radius: 50%;
        width: 52px; height: 52px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    ">
        <i class="fa-solid fa-user-tie" style="font-size:22px;"></i>
    </div>
    <div>
        <h1 style="font-size:20px; font-weight:700; margin-bottom:4px;">
            Selamat datang, {{ Auth::user()->name ?? Auth::user()->username }}!
        </h1>
        <p style="font-size:13.5px; opacity:.88;">
            Ringkasan data Sistem Informasi Akademik &mdash;
            @if(Auth::user()->isAdmin())
                Anda login sebagai <strong>Administrator</strong>. Kelola semua data akademik di sini.
            @else
                Anda login sebagai <strong>Mahasiswa</strong>. Lihat jadwal dan ambil KRS Anda di sini.
            @endif
        </p>
    </div>
</div>

{{-- Statistics Cards --}}
<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px,1fr)); gap:22px; margin-bottom:36px;">

    {{-- Card: Dosen Aktif --}}
    @if(Auth::user()->isAdmin())
        <a href="{{ route('dosen.index') }}" class="stat-card">
    @else
        <div class="stat-card stat-card--readonly">
    @endif
        <div class="stat-card__body">
            <div>
                <p class="stat-card__label">Dosen Aktif</p>
                <h2 class="stat-card__value">{{ $stats['dosen_aktif'] }}</h2>
            </div>
            <div class="stat-card__icon">
                <i class="fa-solid fa-chalkboard-user fa-lg"></i>
            </div>
        </div>
        <p class="stat-card__footer">Total dosen yang terdaftar</p>
    @if(Auth::user()->isAdmin())
        </a>
    @else
        </div>
    @endif

    {{-- Card: Mahasiswa Aktif --}}
    @if(Auth::user()->isAdmin())
        <a href="{{ route('mahasiswa.index') }}" class="stat-card">
    @else
        <div class="stat-card stat-card--readonly">
    @endif
        <div class="stat-card__body">
            <div>
                <p class="stat-card__label">Mahasiswa Aktif</p>
                <h2 class="stat-card__value">{{ $stats['mahasiswa_aktif'] }}</h2>
            </div>
            <div class="stat-card__icon">
                <i class="fa-solid fa-user-graduate fa-lg"></i>
            </div>
        </div>
        <p class="stat-card__footer">Total mahasiswa yang terdaftar</p>
    @if(Auth::user()->isAdmin())
        </a>
    @else
        </div>
    @endif

    {{-- Card: Mata Kuliah --}}
    @if(Auth::user()->isAdmin())
        <a href="{{ route('matakuliah.index') }}" class="stat-card">
    @else
        <div class="stat-card stat-card--readonly">
    @endif
        <div class="stat-card__body">
            <div>
                <p class="stat-card__label">Mata Kuliah</p>
                <h2 class="stat-card__value">{{ $stats['matakuliah'] }}</h2>
            </div>
            <div class="stat-card__icon">
                <i class="fa-solid fa-book fa-lg"></i>
            </div>
        </div>
        <p class="stat-card__footer">Total mata kuliah yang tersedia</p>
    @if(Auth::user()->isAdmin())
        </a>
    @else
        </div>
    @endif

    {{-- Card: Jadwal Kelas (semua role) --}}
    <a href="{{ route('jadwal.index') }}" class="stat-card">
        <div class="stat-card__body">
            <div>
                <p class="stat-card__label">Jadwal Kelas</p>
                <h2 class="stat-card__value">{{ $stats['jadwal'] }}</h2>
            </div>
            <div class="stat-card__icon">
                <i class="fa-solid fa-calendar-days fa-lg"></i>
            </div>
        </div>
        <p class="stat-card__footer">Total jadwal kuliah yang tersedia</p>
    </a>

    {{-- Card: KRS Terdaftar (semua role) --}}
    <a href="{{ route('krs.index') }}" class="stat-card">
        <div class="stat-card__body">
            <div>
                <p class="stat-card__label">KRS Terdaftar</p>
                <h2 class="stat-card__value">{{ $stats['krs'] }}</h2>
            </div>
            <div class="stat-card__icon">
                <i class="fa-solid fa-file-pen fa-lg"></i>
            </div>
        </div>
        <p class="stat-card__footer">Total KRS yang telah terdaftar</p>
    </a>

</div>

{{-- Info Panel --}}
<div style="background:white; border-radius:10px; padding:24px 28px; box-shadow:0 2px 8px rgba(0,0,0,.07);">
    <div style="display:flex; align-items:flex-start; gap:16px;">
        <div style="
            background:#eef3ff; border-radius:8px;
            width:44px; height:44px; flex-shrink:0;
            display:flex; align-items:center; justify-content:center;
        ">
            <i class="fa-solid fa-circle-info" style="color:#1e5bb8; font-size:20px;"></i>
        </div>
        <div>
            <h2 style="font-size:16px; font-weight:700; color:#1e5bb8; margin-bottom:8px;">
                Informasi Penting
            </h2>
            <p style="line-height:1.65; color:#555; font-size:13.5px;">
                Sistem Informasi Akademik (SIAKAD) Fakultas Teknik Universitas Suryakancana adalah platform
                digital yang memudahkan mahasiswa dan dosen dalam mengelola data akademik, jadwal kelas,
                dan informasi KRS. Untuk bantuan lebih lanjut, silakan hubungi administrator melalui
                <strong>info@ftnsur.ac.id</strong> atau <strong>(0263) 283578</strong>.
            </p>
        </div>
    </div>
</div>


@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush


@endsection
