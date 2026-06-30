@extends('layouts.app')

@section('title', 'Data KRS')

@section('content')

<h1 class="page-title"><i class="fa-solid fa-file-pen"></i>Halaman KRS</h1>

@if(Auth::user()->isMahasiswa())
    <div class="info-card" style="margin-bottom:16px; padding:14px 18px; background:#f7f9ff; border:1px solid #d8e2f6; border-radius:12px;">
        <div style="display:flex; flex-wrap:wrap; gap:16px; align-items:center;">
            <div>
                <div style="font-size:13px; color:#6b7a99; margin-bottom:4px;">NPM</div>
                <strong style="font-size:15px;">{{ Auth::user()->npm }}</strong>
            </div>
            <div>
                <div style="font-size:13px; color:#6b7a99; margin-bottom:4px;">Nama</div>
                <strong style="font-size:15px;">{{ Auth::user()->mahasiswa->nama ?? Auth::user()->name }}</strong>
            </div>
            <div style="flex:1; min-width:200px; color:#3b4a79; font-size:14px;">
                Menampilkan daftar KRS Anda sendiri. Data ini hanya dapat dilihat oleh mahasiswa yang sedang login.
            </div>
        </div>
    </div>
@endif

<div class="content-card">

    <div class="toolbar">
        <div class="toolbar-left">
            <a href="{{ route('krs.create') }}" class="btn btn-primary">
                <i class="fa-solid fa-plus"></i> Tambah KRS
            </a>
            <button type="button" class="btn btn-danger" onclick="exportKrsPDF()">
                <i class="fa-solid fa-file-pdf"></i> Export PDF
            </button>
            <button type="button" class="btn btn-success" onclick="exportKrsExcel()">
                <i class="fa-solid fa-file-excel"></i> Export Excel
            </button>
        </div>
        <div class="toolbar-right">
            @php
                $krsSortDir  = request('direction', 'desc');
                $krsNextDir  = $krsSortDir === 'asc' ? 'desc' : 'asc';
                $krsSortActive = request()->has('sort');
            @endphp
            <a href="{{ route('krs.index', array_merge(request()->except(['sort','direction','page']), ['sort' => 'kode_matakuliah', 'direction' => $krsNextDir])) }}"
               class="btn btn-outline {{ $krsSortActive ? 'is-active' : '' }}">
                <i class="fa-solid fa-arrow-down-{{ $krsSortDir === 'asc' ? 'a-z' : 'z-a' }}"></i>
                {{ $krsSortDir === 'asc' ? 'A-Z' : 'Z-A' }}
            </a>
            @include('partials.sort_dropdown', [
                'id' => 'krsSortBtn',
                'target' => 'krsTableBody',
                'formId' => 'krsSearchForm',
                'options' => [
                    ['label' => 'Nama Matakuliah', 'col' => 2, 'value' => 'nama_matakuliah'],
                    ['label' => 'Nama', 'col' => 3, 'value' => 'nama'],
                ]
            ])
            <form id="krsSearchForm" class="search-form" method="GET" action="{{ route('krs.index') }}">
                <input type="hidden" name="sort" value="{{ request('sort') }}">
                <input type="hidden" name="direction" value="{{ request('direction', 'asc') }}">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input name="keyword" type="text" placeholder="Cari KRS..." value="{{ request('keyword') }}">
                </div>
                <button class="btn btn-primary btn-sm" type="submit">Cari</button>
                @if(request('keyword'))
                    <a href="{{ route('krs.index') }}" class="btn btn-outline btn-sm">Reset</a>
                @endif
            </form>
        </div>
    </div>

    @if(request('keyword'))
        <p style="margin:-10px 0 14px; font-size:13px; color:#6b7a99;">
            Hasil pencarian untuk: <strong>{{ request('keyword') }}</strong>
            &mdash; {{ $krs->total() }} data ditemukan
        </p>
    @endif

    <div class="table-scroll">
        <table class="data-table" id="krsTable">
            <thead>
                <tr>
                    <th class="col-no">No</th>
                    <th>Kode</th>
                    <th>Nama Matakuliah</th>
                    <th>Nama Mahasiswa</th>
                    <th>SKS</th>
                    <th>Dosen</th>
                    @if(Auth::user()->isAdmin())
                        <th class="text-center">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody id="krsTableBody">
                @forelse($krs as $item)
                <tr data-row="1">
                    <td class="col-no row-number">{{ $krs->firstItem() + $loop->index }}</td>
                    <td>{{ $item->matakuliah->kode_matakuliah ?? $item->kode_matakuliah }}</td>
                    <td>{{ $item->matakuliah->nama_matakuliah ?? '-' }}</td>
                    <td>{{ $item->mahasiswa->nama ?? '-' }}</td>
                    <td>{{ $item->matakuliah->sks ?? '-' }}</td>
                    <td>{{ $item->matakuliah->dosen_pengajar ?? '-' }}</td>
                    @if(Auth::user()->isAdmin() || (Auth::user()->role === 'mahasiswa' && $item->npm === Auth::user()->npm))
                        <td class="text-center">
                            <div class="action-buttons">
                                <form action="{{ route('krs.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus KRS ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fa-solid fa-trash"></i> Hapus
                                    </button>
                                </form>
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('krs.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </a>
                                @endif
                            </div>
                        </td>
                    @endif
                </tr>
                @empty
                <tr class="empty-row">
                    <td colspan="{{ Auth::user()->isAdmin() ? 7 : 6 }}">
                        <i class="fa-solid fa-file-circle-xmark"></i>
                        Belum ada data KRS yang terdaftar
                    </td>
                </tr>
                @endforelse
                <tr class="empty-row is-hidden" id="krsNoResult">
                    <td colspan="{{ Auth::user()->isAdmin() ? 7 : 6 }}">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        Tidak ada KRS yang cocok dengan pencarian
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="pagination-wrapper">
        {{ $krs->links() }}
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<script>
    initDataTable({
        tableBodyId: 'krsTableBody',
        noResultRowId: 'krsNoResult',
        numberSelector: '.row-number',
        sortBtnId: 'krsSortBtn'
    });

    function getVisibleKrsRows() {
        const rows = Array.from(document.querySelectorAll('#krsTableBody tr[data-row="1"]'))
            .filter(row => row.style.display !== 'none');

        return rows.map(row => [
            row.children[1].innerText.trim(),
            row.children[2].innerText.trim(),
            row.children[3].innerText.trim(),
            row.children[4].innerText.trim(),
            row.children[5].innerText.trim(),
        ]);
    }

    function exportKrsPDF() {
        const data = getVisibleKrsRows();
        if (data.length === 0) {
            showNotifModal('error', 'Tidak ada data KRS untuk diekspor.');
            return;
        }
        const { jsPDF } = jspdf;
        const doc = new jsPDF();
        doc.setFontSize(15);
        doc.text('Data KRS - Sistem Informasi Akademik', 14, 16);
        doc.autoTable({
            head: [['Kode', 'Nama Matakuliah', 'Nama Mahasiswa', 'SKS', 'Dosen']],
            body: data,
            startY: 24,
            headStyles: { fillColor: [30, 91, 184] },
            styles: { fontSize: 10 },
        });
        doc.save('Data-KRS.pdf');
    }

    function exportKrsExcel() {
        const data = getVisibleKrsRows();
        if (data.length === 0) {
            showNotifModal('error', 'Tidak ada data KRS untuk diekspor.');
            return;
        }
        const sheetData = [['Kode', 'Nama Matakuliah', 'Nama Mahasiswa', 'SKS', 'Dosen'], ...data];
        const ws = XLSX.utils.aoa_to_sheet(sheetData);
        ws['!cols'] = [{ wch: 12 }, { wch: 30 }, { wch: 24 }, { wch: 8 }, { wch: 26 }];
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, 'KRS');
        XLSX.writeFile(wb, 'Data-KRS.xlsx');
    }
</script>
@endsection
