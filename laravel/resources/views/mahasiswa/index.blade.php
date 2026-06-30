@extends('layouts.app')

@section('title', 'Data Mahasiswa')

@section('content')

<h1 class="page-title"><i class="fa-solid fa-user-graduate"></i>Halaman Mahasiswa</h1>

<div class="content-card">

    <div class="toolbar">
        <div class="toolbar-left">
            <a href="{{ route('mahasiswa.create') }}" class="btn btn-primary">
                <i class="fa-solid fa-plus"></i> Tambah Mahasiswa
            </a>
        </div>
        <div class="toolbar-right">
            @php
                $mhsSortDir  = request('direction', 'asc');
                $mhsNextDir  = $mhsSortDir === 'asc' ? 'desc' : 'asc';
                $mhsSortActive = request()->has('sort');
            @endphp
            <a href="{{ route('mahasiswa.index', array_merge(request()->except(['sort','direction','page']), ['sort' => 'nama', 'direction' => $mhsNextDir])) }}"
               class="btn btn-outline {{ $mhsSortActive ? 'is-active' : '' }}">
                <i class="fa-solid fa-arrow-down-{{ $mhsSortDir === 'asc' ? 'a-z' : 'z-a' }}"></i>
                {{ $mhsSortDir === 'asc' ? 'A-Z' : 'Z-A' }}
            </a>
            @include('partials.sort_dropdown', [
                'id' => 'mhsSortBtn',
                'target' => 'mhsTableBody',
                'formId' => 'mhsSearchForm',
                'options' => [
                    ['label' => 'Nama', 'col' => 2, 'value' => 'nama'],
                    ['label' => 'Dosen Wali', 'col' => 3, 'value' => 'dosen'],
                ]
            ])
            <form id="mhsSearchForm" class="search-form" method="GET" action="{{ route('mahasiswa.index') }}">
                <input type="hidden" name="sort" value="{{ request('sort') }}">
                <input type="hidden" name="direction" value="{{ request('direction', 'asc') }}">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input name="keyword" type="text" placeholder="Cari mahasiswa..." value="{{ request('keyword') }}">
                </div>
                <button class="btn btn-primary btn-sm" type="submit">Cari</button>
                @if(request('keyword'))
                    <a href="{{ route('mahasiswa.index') }}" class="btn btn-outline btn-sm">Reset</a>
                @endif
            </form>
        </div>
    </div>

    @if(request('keyword'))
        <p style="margin:-10px 0 14px; font-size:13px; color:#6b7a99;">
            Hasil pencarian untuk: <strong>{{ request('keyword') }}</strong>
            &mdash; {{ $mahasiswas->total() }} data ditemukan
        </p>
    @endif

    <div class="table-scroll">
        <table class="data-table">
            <thead>
                <tr>
                    <th class="col-no">No</th>
                    <th>NPM</th>
                    <th>Nama</th>
                    <th>Dosen Wali</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody id="mhsTableBody">
                @forelse($mahasiswas as $mhs)
                <tr data-row="1">
                    <td class="col-no row-number">{{ $mahasiswas->firstItem() + $loop->index }}</td>
                    <td>{{ $mhs->npm }}</td>
                    <td>{{ $mhs->nama }}</td>
                    <td>{{ $mhs->dosen->nama ?? '-' }}</td>
                    <td class="text-center">
                        <div class="action-buttons">
                            <form action="{{ route('mahasiswa.destroy', $mhs->npm) }}" method="POST" onsubmit="return confirm('Yakin hapus mahasiswa ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fa-solid fa-trash"></i> Hapus
                                </button>
                            </form>
                            <a href="{{ route('mahasiswa.edit', $mhs->npm) }}" class="btn btn-warning btn-sm">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr class="empty-row">
                    <td colspan="5">
                        <i class="fa-solid fa-user-graduate"></i>
                        Belum ada data mahasiswa
                    </td>
                </tr>
                @endforelse
                <tr class="empty-row is-hidden" id="mhsNoResult">
                    <td colspan="5">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        Tidak ada mahasiswa yang cocok dengan pencarian
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="pagination-wrapper">
        {{ $mahasiswas->links() }}
    </div>
</div>

<script>
    initDataTable({
        tableBodyId: 'mhsTableBody',
        noResultRowId: 'mhsNoResult',
        numberSelector: '.row-number',
        sortBtnId: 'mhsSortBtn'
    });
</script>
@endsection
