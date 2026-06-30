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
                <span class="page-link" aria-label="Sebelumnya" style="display:inline-flex;align-items:center;justify-content:center;min-width:28px;height:28px;padding:0 8px;font-size:13px;line-height:1;overflow:hidden;">
                    <svg class="pagination-icon" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width:12px;height:12px;max-width:12px;max-height:12px;display:block;overflow:hidden;"><polyline points="15 18 9 12 15 6"></polyline></svg>
                </span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Sebelumnya" style="display:inline-flex;align-items:center;justify-content:center;min-width:28px;height:28px;padding:0 8px;font-size:13px;line-height:1;overflow:hidden;">
                    <svg class="pagination-icon" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width:12px;height:12px;max-width:12px;max-height:12px;display:block;overflow:hidden;"><polyline points="15 18 9 12 15 6"></polyline></svg>
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
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Berikutnya" style="display:inline-flex;align-items:center;justify-content:center;min-width:28px;height:28px;padding:0 8px;font-size:13px;line-height:1;overflow:hidden;">
                    <svg class="pagination-icon" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width:12px;height:12px;max-width:12px;max-height:12px;display:block;overflow:hidden;"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </a>
            </li>
        @else
            <li class="page-item disabled" aria-disabled="true">
                <span class="page-link" aria-label="Berikutnya" style="display:inline-flex;align-items:center;justify-content:center;min-width:28px;height:28px;padding:0 8px;font-size:13px;line-height:1;overflow:hidden;">
                    <svg class="pagination-icon" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width:12px;height:12px;max-width:12px;max-height:12px;display:block;overflow:hidden;"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </span>
            </li>
        @endif

    </ul>
</nav>
@endif
