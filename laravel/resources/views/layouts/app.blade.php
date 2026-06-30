<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIAK - Sistem Informasi Akademik')</title>

    {{-- Font Awesome 6 --}}
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
          integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ filemtime(public_path('css/app.css')) }}">
    @stack('styles')

</head>
<body>

{{-- HEADER --}}
<div class="header">
    {{-- Kiri: Logo + Judul Sistem --}}
    <div class="header-brand">
        <img src="{{ asset('images/logo.png') }}"
             alt="Logo Kampus"
             class="header-logo-img"
             onerror="this.style.display='none'">
        <div class="header-divider"></div>
        <div class="header-title-group">
            <span class="header-univ-name">Fakultas Teknik Universitas Suryakancana</span>
            <span class="header-siak-title">Sistem Informasi Akademik</span>
        </div>
    </div>

    {{-- Kanan: Kontak --}}
    <div class="header-contact">
        <div class="header-contact-item">
            <i class="fa-solid fa-phone-volume"></i>
            <span>(0263) 283578</span>
        </div>
        <div class="header-contact-item">
            <i class="fa-solid fa-envelope"></i>
            <span>info@ftnsur.ac.id</span>
        </div>
    </div>
</div>

{{-- NAVBAR --}}
<div class="navbar">
    <div class="nav-container">
        <div class="nav-left">
            {{-- Beranda (semua role) --}}
            <a href="{{ route('dashboard') }}"
               class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-house-chimney fa-sm"></i>
                Beranda
            </a>

            {{-- Menu khusus Admin --}}
            @if(Auth::check() && Auth::user()->isAdmin())
                <a href="{{ route('dosen.index') }}"
                   class="nav-item {{ request()->routeIs('dosen.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-chalkboard-user fa-sm"></i>
                    Dosen
                </a>
                <a href="{{ route('mahasiswa.index') }}"
                   class="nav-item {{ request()->routeIs('mahasiswa.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-user-graduate fa-sm"></i>
                    Mahasiswa
                </a>
                <a href="{{ route('matakuliah.index') }}"
                   class="nav-item {{ request()->routeIs('matakuliah.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-book fa-sm"></i>
                    Mata Kuliah
                </a>
            @endif

            {{-- Jadwal (semua role) --}}
            <a href="{{ route('jadwal.index') }}"
               class="nav-item {{ request()->routeIs('jadwal.*') ? 'active' : '' }}">
                <i class="fa-solid fa-calendar-days fa-sm"></i>
                Jadwal
            </a>

            {{-- KRS (semua role) --}}
            <a href="{{ route('krs.index') }}"
               class="nav-item {{ request()->routeIs('krs.*') ? 'active' : '' }}">
                <i class="fa-solid fa-file-pen fa-sm"></i>
                KRS
            </a>
        </div>

        <div class="nav-right">
            @if(Auth::check())
                <div class="user-info">
                    <i class="fa-solid fa-circle-user"></i>
                    <span>{{ Auth::user()->name ?? Auth::user()->username }}</span>
                    @if(Auth::user()->isAdmin())
                        <span class="role-badge admin">Admin</span>
                    @else
                        <span class="role-badge mahasiswa">Mahasiswa</span>
                    @endif
                </div>
                <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fa-solid fa-right-from-bracket fa-sm"></i>
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="logout-btn" style="background:#1e5bb8;">
                    <i class="fa-solid fa-right-to-bracket fa-sm"></i>
                    Login
                </a>
            @endif
        </div>
    </div>
</div>

{{-- MAIN CONTENT --}}
<div class="main-content">

    {{-- Flash: success / error ditampilkan lewat modal notifikasi (lihat bawah) --}}
    @if(Session::has('success'))
        <div id="flashSuccess" data-flash-message="{{ Session::get('success') }}" style="display:none;"></div>
    @endif

    @if(Session::has('error'))
        <div id="flashError" data-flash-message="{{ Session::get('error') }}" style="display:none;"></div>
    @endif

    {{-- Validation errors --}}
    @if($errors->any())
        <div class="alert alert-error">
            <i class="fa-solid fa-triangle-exclamation fa-sm"></i>
            <div>
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        </div>
    @endif

    @yield('content')
</div>

{{-- FOOTER --}}
<div class="footer">
    <div class="footer-container">

        {{-- Kolom 1: Kontak Kami --}}
        <div class="footer-section">
            <h3><i class="fa-solid fa-location-dot"></i> Kontak Kami</h3>
            <div style="margin-bottom:10px;">
                <strong style="font-size:13.5px;">Fakultas Teknik Universitas Suryakancana</strong>
            </div>
            <div style="font-size:13px; color:#666; margin-bottom:14px;">
                Jl. Pasir Gede Raya, Cianjur, Jawa Barat
            </div>
            <div class="footer-contact-row">
                <i class="fa-solid fa-phone"></i>
                <span>(0263) 283578</span>
            </div>
            <div class="footer-contact-row">
                <i class="fa-solid fa-fax"></i>
                <span>(0263) 283578</span>
            </div>
            <div class="footer-contact-row">
                <i class="fa-solid fa-envelope"></i>
                <span>info@ftnsur.ac.id</span>
            </div>
            <div class="social-icons">
                <a href="#" class="social-icon" title="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="#" class="social-icon" title="Twitter / X"><i class="fa-brands fa-x-twitter"></i></a>
                <a href="#" class="social-icon" title="Instagram"><i class="fa-brands fa-instagram"></i></a>
                <a href="#" class="social-icon" title="YouTube"><i class="fa-brands fa-youtube"></i></a>
            </div>
        </div>

        {{-- Kolom 2: Master Data --}}
        <div class="footer-section">
            <h3><i class="fa-solid fa-database"></i> Master Data</h3>
            <ul>
                <li>
                    <a href="{{ Auth::check() && Auth::user()->isAdmin() ? route('dosen.index') : '#' }}">
                        <i class="fa-solid fa-chalkboard-user"></i>
                        Dosen Aktif
                    </a>
                </li>
                <li>
                    <a href="{{ Auth::check() && Auth::user()->isAdmin() ? route('mahasiswa.index') : '#' }}">
                        <i class="fa-solid fa-user-graduate"></i>
                        Mahasiswa Aktif
                    </a>
                </li>
                <li>
                    <a href="{{ Auth::check() && Auth::user()->isAdmin() ? route('matakuliah.index') : '#' }}">
                        <i class="fa-solid fa-book"></i>
                        Mata Kuliah
                    </a>
                </li>
            </ul>
        </div>

        {{-- Kolom 3: Akademik --}}
        <div class="footer-section">
            <h3><i class="fa-solid fa-graduation-cap"></i> Akademik</h3>
            <ul>
                <li>
                    <a href="{{ route('jadwal.index') }}">
                        <i class="fa-solid fa-calendar-days"></i>
                        Jadwal Kelas
                    </a>
                </li>
                <li>
                    <a href="{{ route('krs.index') }}">
                        <i class="fa-solid fa-file-pen"></i>
                        KRS Terdaftar
                    </a>
                </li>
            </ul>
        </div>

    </div>

    <div class="footer-bottom">
        <i class="fa-regular fa-copyright"></i>
        2026 &mdash; Sistem Informasi Akademik &mdash; Fakultas Teknik Universitas Suryakancana. All Rights Reserved.
    </div>
</div>

{{-- MODAL NOTIFIKASI (sukses / error) --}}
<div class="notif-overlay" id="notifOverlay">
    <div class="notif-card" id="notifCard">
        <div class="notif-icon" id="notifIcon">
            <i class="fa-solid fa-circle-check" id="notifIconGlyph"></i>
        </div>
        <h3 class="notif-title" id="notifTitle">Berhasil!</h3>
        <p class="notif-message" id="notifMessage"></p>
        <button type="button" class="notif-btn" onclick="closeNotifModal()">OK</button>
    </div>
</div>

{{-- Scroll-to-Top Button --}}
<button class="scroll-to-top" id="scrollToTopBtn" onclick="scrollToTop()">
    <i class="fa-solid fa-chevron-up"></i>
</button>

<script>
    // Show / hide scroll-to-top
    window.addEventListener('scroll', function () {
        document.getElementById('scrollToTopBtn')
            .classList.toggle('show', window.pageYOffset > 300);
    });

    function scrollToTop() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // Modal Notifikasi (sukses / error)
    let notifAutoCloseTimer = null;

    function showNotifModal(type, message) {
        const overlay = document.getElementById('notifOverlay');
        const card = document.getElementById('notifCard');
        const icon = document.getElementById('notifIcon');
        const glyph = document.getElementById('notifIconGlyph');
        const title = document.getElementById('notifTitle');
        const msg = document.getElementById('notifMessage');

        card.classList.remove('is-error');
        icon.classList.remove('notif-icon--success', 'notif-icon--error');

        if (type === 'error') {
            card.classList.add('is-error');
            icon.classList.add('notif-icon--error');
            glyph.className = 'fa-solid fa-circle-xmark';
            title.textContent = 'Gagal!';
        } else {
            icon.classList.add('notif-icon--success');
            glyph.className = 'fa-solid fa-circle-check';
            title.textContent = 'Berhasil!';
        }

        msg.textContent = message;
        overlay.classList.add('show');

        clearTimeout(notifAutoCloseTimer);
        notifAutoCloseTimer = setTimeout(closeNotifModal, 4000);
    }

    function closeNotifModal() {
        document.getElementById('notifOverlay').classList.remove('show');
        clearTimeout(notifAutoCloseTimer);
    }

    document.getElementById('notifOverlay').addEventListener('click', function (e) {
        if (e.target === this) closeNotifModal();
    });

    document.addEventListener('DOMContentLoaded', function () {
        const successEl = document.getElementById('flashSuccess');
        const errorEl = document.getElementById('flashError');
        if (successEl) {
            showNotifModal('success', successEl.dataset.flashMessage);
        } else if (errorEl) {
            showNotifModal('error', errorEl.dataset.flashMessage);
        }
    });

    // Auto-close alerts after 5 s
    setTimeout(function () {
        document.querySelectorAll('.alert').forEach(el => {
            el.style.transition = 'opacity .5s';
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 500);
        });
    }, 5000);

    // Utilitas Tabel: Live Search + Sort A-Z/Z-A
    // Dipanggil dari tiap halaman index dengan id elemen masing-masing.
    function initDataTable(opts) {
        const tbody = document.getElementById(opts.tableBodyId);
        if (!tbody) return;
        const searchInput = opts.searchInputId ? document.getElementById(opts.searchInputId) : null;
        const sortBtn = opts.sortBtnId ? document.getElementById(opts.sortBtnId) : null;
        const noResultRow = opts.noResultRowId ? document.getElementById(opts.noResultRowId) : null;
        let sortAsc = true;

        function dataRows() {
            return Array.from(tbody.querySelectorAll('tr[data-row="1"]'));
        }

        function renumber() {
            if (!opts.numberSelector) return;
            dataRows().forEach((row, idx) => {
                const cell = row.querySelector(opts.numberSelector);
                if (cell) cell.textContent = idx + 1;
            });
        }

        if (searchInput) {
            searchInput.addEventListener('input', function () {
                const term = this.value.trim().toLowerCase();
                let visibleCount = 0;
                dataRows().forEach(row => {
                    const match = row.innerText.toLowerCase().includes(term);
                    row.classList.toggle('is-hidden-search', !match);
                    row.style.display = match ? '' : 'none';
                    if (match) visibleCount++;
                });
                if (noResultRow) {
                    noResultRow.classList.toggle('is-hidden', visibleCount !== 0);
                }
            });
        }

        // performSort exposed so dropdowns can request sorting by column index
        function performSort(colIndex = (opts.sortColumnIndex ?? 0)) {
            const rows = dataRows();
            rows.sort((a, b) => {
                const ta = (a.children[colIndex]?.innerText || '').trim().toLowerCase();
                const tb = (b.children[colIndex]?.innerText || '').trim().toLowerCase();
                return sortAsc ? ta.localeCompare(tb) : tb.localeCompare(ta);
            });
            rows.forEach(r => tbody.appendChild(r));
            renumber();
            if (sortBtn) {
                // only show icon to keep button compact
                sortBtn.innerHTML = sortAsc
                    ? '<i class="fa-solid fa-arrow-down-a-z"></i>'
                    : '<i class="fa-solid fa-arrow-down-z-a"></i>';
                sortBtn.classList.add('is-active');
            }
            sortAsc = !sortAsc;
        }

        // Expose named function on window so partial dropdowns can call it
        try {
            window['dataTableSort_' + opts.tableBodyId] = performSort;
        } catch (e) {
            // no-op
        }
    }
</script>
</body>
</html>
