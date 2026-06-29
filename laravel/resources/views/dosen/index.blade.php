@extends('layouts.app')

@section('title', 'Data Dosen')

@section('content')

<h1 class="page-title"><i class="fa-solid fa-chalkboard-user"></i>Halaman Dosen</h1>

<div class="content-card">

    <div class="toolbar">
        <div class="toolbar-left">
            <a href="{{ route('dosen.create') }}" class="btn btn-primary">
                <i class="fa-solid fa-plus"></i> Tambah Dosen
            </a>
        </div>
        <div class="toolbar-right">
            @php
                $dosenSortDir  = request('direction', 'asc');
                $dosenNextDir  = $dosenSortDir === 'asc' ? 'desc' : 'asc';
                $dosenSortActive = request()->has('sort');
            @endphp
            <a href="{{ route('dosen.index', array_merge(request()->except(['sort','direction','page']), ['sort' => 'nama', 'direction' => $dosenNextDir])) }}"
               class="btn btn-outline {{ $dosenSortActive ? 'is-active' : '' }}">
                <i class="fa-solid fa-arrow-down-{{ $dosenSortDir === 'asc' ? 'a-z' : 'z-a' }}"></i>
                {{ $dosenSortDir === 'asc' ? 'A-Z' : 'Z-A' }}
            </a>
            <form class="search-form" method="GET" action="{{ route('dosen.index') }}">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input name="keyword" type="text" placeholder="Cari dosen..." value="{{ request('keyword') }}">
                </div>
                <button class="btn btn-primary btn-sm" type="submit">Cari</button>
                @if(request('keyword'))
                    <a href="{{ route('dosen.index') }}" class="btn btn-outline btn-sm">Reset</a>
                @endif
            </form>
        </div>
    </div>

    @if(request('keyword'))
        <p style="margin:-10px 0 14px; font-size:13px; color:#6b7a99;">
            Hasil pencarian untuk: <strong>{{ request('keyword') }}</strong>
            &mdash; {{ $dosens->total() }} data ditemukan
        </p>
    @endif

    <div class="table-scroll">
        <table class="data-table">
            <thead>
                <tr>
                    <th class="col-no">No</th>
                    <th>NIDN</th>
                    <th>Nama</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody id="dosenTableBody">
                @forelse($dosens as $dosen)
                <tr data-row="1">
                    <td class="col-no row-number">{{ $dosens->firstItem() + $loop->index }}</td>
                    <td>{{ $dosen->nidn }}</td>
                    <td>{{ $dosen->nama }}</td>
                    <td class="text-center">
                        <div class="action-buttons">
                            <form action="{{ route('dosen.destroy', $dosen->nidn) }}" method="POST" onsubmit="return confirm('Yakin hapus dosen ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fa-solid fa-trash"></i> Hapus
                                </button>
                            </form>
                            <a href="{{ route('dosen.edit', $dosen->nidn) }}" class="btn btn-warning btn-sm">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr class="empty-row">
                    <td colspan="4">
                        <i class="fa-solid fa-chalkboard-user"></i>
                        Belum ada data dosen
                    </td>
                </tr>
                @endforelse
                <tr class="empty-row is-hidden" id="dosenNoResult">
                    <td colspan="4">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        Tidak ada dosen yang cocok dengan pencarian
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="pagination-wrapper">
        {{ $dosens->links() }}
    </div>
</div>

<script>
    initDataTable({
        tableBodyId: 'dosenTableBody',
        noResultRowId: 'dosenNoResult',
        numberSelector: '.row-number',
    });
</script>
@endsection
