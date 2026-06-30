@extends('layouts.app')

@section('title', 'Data Jadwal')

@section('content')

<h1 class="page-title"><i class="fa-solid fa-calendar-days"></i>Halaman Jadwal</h1>

<div class="content-card">

    <div class="toolbar">
        <div class="toolbar-left">
            @if(Auth::user()->isAdmin())
                <a href="{{ route('jadwal.create') }}" class="btn btn-primary">
                    <i class="fa-solid fa-plus"></i> Tambah Jadwal
                </a>
            @endif
        </div>
        <div class="toolbar-right">
            @php
                $jadSortDir  = request('direction', 'asc');
                $jadNextDir  = $jadSortDir === 'asc' ? 'desc' : 'asc';
                $jadSortActive = request()->has('sort');
            @endphp
            <a href="{{ route('jadwal.index', array_merge(request()->except(['sort','direction','page']), ['sort' => 'hari', 'direction' => $jadNextDir])) }}"
               class="btn btn-outline {{ $jadSortActive ? 'is-active' : '' }}">
                <i class="fa-solid fa-arrow-down-{{ $jadSortDir === 'asc' ? 'a-z' : 'z-a' }}"></i>
                {{ $jadSortDir === 'asc' ? 'A-Z' : 'Z-A' }}
            </a>
            @include('partials.sort_dropdown', [
                'id' => 'jadwalSortBtn',
                'target' => 'jadwalTableBody',
                'formId' => 'jadwalSearchForm',
                'options' => [
                    ['label' => 'Nama Matakuliah', 'col' => 1, 'value' => 'nama_matakuliah'],
                    ['label' => 'Dosen', 'col' => 2, 'value' => 'dosen'],
                    ['label' => 'Kelas', 'col' => 3, 'value' => 'kelas'],
                ]
            ])
            <form id="jadwalSearchForm" class="search-form" method="GET" action="{{ route('jadwal.index') }}">
                <input type="hidden" name="sort" value="{{ request('sort') }}">
                <input type="hidden" name="direction" value="{{ request('direction', 'asc') }}">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input name="keyword" type="text" placeholder="Cari jadwal..." value="{{ request('keyword') }}">
                </div>
                <button class="btn btn-primary btn-sm" type="submit">Cari</button>
                @if(request('keyword'))
                    <a href="{{ route('jadwal.index') }}" class="btn btn-outline btn-sm">Reset</a>
                @endif
            </form>
        </div>
    </div>

    @if(request('keyword'))
        <p style="margin:-10px 0 14px; font-size:13px; color:#6b7a99;">
            Hasil pencarian untuk: <strong>{{ request('keyword') }}</strong>
            &mdash; {{ $jadwals->total() }} data ditemukan
        </p>
    @endif

    <div class="table-scroll">
        <table class="data-table">
            <thead>
                <tr>
                    <th class="col-no">No</th>
                    <th>Mata Kuliah</th>
                    <th>Dosen</th>
                    <th>Kelas</th>
                    <th>Hari</th>
                    <th>Waktu</th>
                    @if(Auth::user()->isAdmin())
                        <th class="text-center">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody id="jadwalTableBody">
                @forelse($jadwals as $j)
                <tr data-row="1">
                    <td class="col-no row-number">{{ $jadwals->firstItem() + $loop->index }}</td>
                    <td>{{ $j->matakuliah->nama_matakuliah ?? '-' }}</td>
                    <td>{{ $j->dosen->nama ?? '-' }}</td>
                    <td>{{ $j->kelas }}</td>
                    <td>{{ $j->hari }}</td>
                    <td>{{ $j->waktu }}</td>
                    @if(Auth::user()->isAdmin())
                        <td class="text-center">
                            <div class="action-buttons">
                                <form action="{{ route('jadwal.destroy', $j->id) }}" method="POST" onsubmit="return confirm('Yakin hapus jadwal ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fa-solid fa-trash"></i> Hapus
                                    </button>
                                </form>
                                <a href="{{ route('jadwal.edit', $j->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                </a>
                            </div>
                        </td>
                    @endif
                </tr>
                @empty
                <tr class="empty-row">
                    <td colspan="{{ Auth::user()->isAdmin() ? 7 : 6 }}">
                        <i class="fa-solid fa-calendar-xmark"></i>
                        Belum ada data jadwal kelas
                    </td>
                </tr>
                @endforelse
                <tr class="empty-row is-hidden" id="jadwalNoResult">
                    <td colspan="{{ Auth::user()->isAdmin() ? 7 : 6 }}">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        Tidak ada jadwal yang cocok dengan pencarian
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="pagination-wrapper">
        {{ $jadwals->links() }}
    </div>
</div>

<script>
    initDataTable({
        tableBodyId: 'jadwalTableBody',
        noResultRowId: 'jadwalNoResult',
        numberSelector: '.row-number',
        sortBtnId: 'jadwalSortBtn'
    });
</script>
@endsection
