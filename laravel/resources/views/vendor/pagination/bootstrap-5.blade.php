@if ($paginator->hasPages())
<nav aria-label="Navigasi Halaman">

    {{-- Info: Menampilkan X sampai Y dari Z data --}}
    @if ($paginator->total() > 0)
    <p class="pagination-info">
        Menampilkan <strong>{{ $paginator->firstItem() }}</strong> &ndash;
        <strong>{{ $paginator->lastItem() }}</strong> dari
        <strong>{{ $paginator->total() }}</strong> data
    </p>
    @endif

    <ul class="pagination">

        {{-- Tombol Sebelumnya --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled" aria-disabled="true">
                <span class="page-link" aria-label="Sebelumnya">
                    <i class="fa-solid fa-chevron-left fa-xs"></i>
                </span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Sebelumnya">
                    <i class="fa-solid fa-chevron-left fa-xs"></i>
                </a>
            </li>
        @endif

        {{-- Nomor Halaman --}}
        @foreach ($elements as $element)
            {{-- Separator "..." --}}
            @if (is_string($element))
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">{{ $element }}</span>
                </li>
            @endif

            {{-- Daftar Link Halaman --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active" aria-current="page">
                            <span class="page-link">{{ $page }}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Tombol Berikutnya --}}
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Berikutnya">
                    <i class="fa-solid fa-chevron-right fa-xs"></i>
                </a>
            </li>
        @else
            <li class="page-item disabled" aria-disabled="true">
                <span class="page-link" aria-label="Berikutnya">
                    <i class="fa-solid fa-chevron-right fa-xs"></i>
                </span>
            </li>
        @endif

    </ul>
</nav>
@endif
