@extends('layouts.app')

@section('title', 'Akses Ditolak - 403')

@section('content')
<div style="
    text-align: center;
    padding: 60px 20px;
    max-width: 520px;
    margin: 0 auto;
">
    <div style="
        background: #fff3cd;
        border: 1px solid #ffe589;
        border-radius: 12px;
        padding: 40px 32px;
        box-shadow: 0 4px 16px rgba(0,0,0,.08);
    ">
        <i class="fa-solid fa-shield-halved" style="font-size:60px; color:#e6a000; margin-bottom:18px; display:block;"></i>
        <h1 style="font-size:26px; font-weight:800; color:#333; margin-bottom:10px;">Akses Ditolak</h1>
        <p style="color:#666; font-size:14.5px; line-height:1.6; margin-bottom:24px;">
            Anda tidak memiliki izin untuk mengakses halaman ini.<br>
            Halaman ini hanya dapat diakses oleh <strong>Administrator</strong>.
        </p>
        <a href="{{ route('dashboard') }}" style="
            background: #1e5bb8;
            color: white;
            padding: 10px 24px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        ">
            <i class="fa-solid fa-house-chimney fa-sm"></i>
            Kembali ke Beranda
        </a>
    </div>
</div>
@endsection
