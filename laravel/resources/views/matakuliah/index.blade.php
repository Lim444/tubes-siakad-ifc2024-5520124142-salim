@extends('layouts.app')

@section('title', 'Data Matakuliah')

@section('content')

<h1 class="page-title"><i class="fa-solid fa-book"></i>Halaman Mata Kuliah</h1>

<div class="content-card">

    <div class="toolbar">
        <div class="toolbar-left">
            <a href="{{ route('matakuliah.create') }}" class="btn btn-primary">
                <i class="fa-solid fa-plus"></i> Tambah Matakuliah
            </a>
        </div>
        <div class="toolbar-right">
            @php
                $mkSortDir  = request('direction', 'asc');
                $mkNextDir  = $mkSortDir === 'asc' ? 'desc' : 'asc';
                $mkSortActive = request()->has('sort');
            @endphp
            <a href="{{ route('matakuliah.index', array_merge(request()->except(['sort','direction','page']), ['sort' => 'nama_matakuliah', 'direction' => $mkNextDir])) }}"
               class="btn btn-outline {{ $mkSortActive ? 'is-active' : '' }}">
                <i class="fa-solid fa-arrow-down-{{ $mkSortDir === 'asc' ? 'a-z' : 'z-a' }}"></i>
                {{ $mkSortDir === 'asc' ? 'A-Z' : 'Z-A' }}
            </a>
            <form class="search-form" method="GET" action="{{ route('matakuliah.index') }}">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input name="keyword" type="text" placeholder="Cari matakuliah..." value="{{ request('keyword') }}">
                </div>
                <button class="btn btn-primary btn-sm" type="submit">Cari</button>
                @if(request('keyword'))
                    <a href="{{ route('matakuliah.index') }}" class="btn btn-outline btn-sm">Reset</a>
                @endif
            </form>
        </div>
    </div>

    @if(request('keyword'))
        <p style="margin:-10px 0 14px; font-size:13px; color:#6b7a99;">
            Hasil pencarian untuk: <strong>{{ request('keyword') }}</strong>
            &mdash; {{ $matakuliahs->total() }} data ditemukan
        </p>
    @endif

    <div class="table-scroll">
        <table class="data-table">
            <thead>
                <tr>
                    <th class="col-no">No</th>
                    <th>Kode</th>
                    <th>Nama Matakuliah</th>
                    <th>SKS</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody id="mkTableBody">
                @forelse($matakuliahs as $mk)
                <tr data-row="1">
                    <td class="col-no row-number">{{ $matakuliahs->firstItem() + $loop->index }}</td>
                    <td>{{ $mk->kode_matakuliah }}</td>
                    <td>{{ $mk->nama_matakuliah }}</td>
                    <td>{{ $mk->sks }}</td>
                    <td class="text-center">
                        <div class="action-buttons">
                            <form action="{{ route('matakuliah.destroy', $mk->kode_matakuliah) }}" method="POST" onsubmit="return confirm('Yakin hapus matakuliah ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fa-solid fa-trash"></i> Hapus
                                </button>
                            </form>
                            <a href="{{ route('matakuliah.edit', $mk->kode_matakuliah) }}" class="btn btn-warning btn-sm">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr class="empty-row">
                    <td colspan="5">
                        <i class="fa-solid fa-book"></i>
                        Belum ada data matakuliah
                    </td>
                </tr>
                @endforelse
                <tr class="empty-row is-hidden" id="mkNoResult">
                    <td colspan="5">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        Tidak ada matakuliah yang cocok dengan pencarian
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="pagination-wrapper">
        {{ $matakuliahs->links() }}
    </div>
</div>

<script>
    initDataTable({
        tableBodyId: 'mkTableBody',
        noResultRowId: 'mkNoResult',
        numberSelector: '.row-number',
    });
</script>
@endsection
