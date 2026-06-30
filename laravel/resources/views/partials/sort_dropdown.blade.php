@php
    // Expect variables: $id (button id), $options (array of ['label'=>..., 'col'=>index, 'value'=>sortField])
    // Optional variables: $target (table body id), $formId (search form id)
    $wrapId = $id . '_wrap';
@endphp
<div class="sort-dropdown-wrapper" id="{{ $wrapId }}" style="position:relative; display:inline-block; margin-right:8px;">
    <button type="button" id="{{ $id }}" class="btn btn-outline sort-dropdown-toggle" aria-expanded="false" title="Sortir" data-target-table-id="{{ $target ?? '' }}" data-target-form-id="{{ $formId ?? '' }}">
        <i class="fa-solid fa-sort"></i>
    </button>
    <div class="sort-dropdown" style="position:absolute; right:0; top:36px; background:#fff; border:1px solid #e1e6ef; box-shadow:0 6px 18px rgba(20,30,50,.08); padding:6px; display:none; z-index:50; min-width:160px;">
        @foreach($options as $opt)
            <button type="button" class="sort-option" data-col-index="{{ $opt['col'] }}" data-sort-value="{{ $opt['value'] ?? '' }}" style="display:block; width:100%; text-align:left; padding:8px 10px; border:none; background:transparent;">{{ $opt['label'] }}</button>
        @endforeach
    </div>
</div>

<script>
    (function(){
        const wrap = document.getElementById('{{ $wrapId }}');
        if (!wrap) return;
        const toggle = wrap.querySelector('.sort-dropdown-toggle');
        const dropdown = wrap.querySelector('.sort-dropdown');
        function close() { dropdown.style.display = 'none'; toggle.setAttribute('aria-expanded','false'); }
        function open() { dropdown.style.display = 'block'; toggle.setAttribute('aria-expanded','true'); }
        toggle.addEventListener('click', function(e){
            e.stopPropagation();
            if (dropdown.style.display === 'block') close(); else open();
        });
        wrap.querySelectorAll('.sort-option').forEach(btn => {
            btn.addEventListener('click', function(e){
                e.stopPropagation();
                const col = parseInt(this.dataset.colIndex || '0', 10);
                const sortValue = this.dataset.sortValue || '';
                // store selected col on toggle button (optional)
                toggle.dataset.sortColumnIndex = col;

                // Try to find the nearest search form to submit server-side sort
                function findSearchForm(el) {
                    // look up to toolbar, then find .search-form inside the same toolbar
                    let cur = el;
                    for (let i = 0; i < 6 && cur; i++) {
                        if (cur.classList && cur.classList.contains('toolbar')) {
                            const sf = cur.querySelector('.search-form');
                            if (sf) return sf;
                        }
                        cur = cur.parentElement;
                    }
                    // fallback: global first .search-form
                    return document.querySelector('.search-form');
                }

                const form = document.getElementById(toggle.dataset.targetFormId) || findSearchForm(wrap);
                if (form && sortValue) {
                    // get current query params from form hidden inputs or URL
                    function getInput(name) {
                        const inp = form.querySelector('input[name="' + name + '"]');
                        return inp ? inp.value : null;
                    }

                    const currentSort = getInput('sort') || new URLSearchParams(window.location.search).get('sort');
                    const currentDir = getInput('direction') || new URLSearchParams(window.location.search).get('direction') || 'asc';
                    let nextDir = 'asc';
                    if (currentSort === sortValue) nextDir = currentDir === 'asc' ? 'desc' : 'asc';

                    // ensure hidden inputs exist
                    function ensureHidden(name, value) {
                        let inp = form.querySelector('input[name="' + name + '"]');
                        if (!inp) {
                            inp = document.createElement('input');
                            inp.type = 'hidden';
                            inp.name = name;
                            form.appendChild(inp);
                        }
                        inp.value = value;
                    }

                    ensureHidden('sort', sortValue);
                    ensureHidden('direction', nextDir);
                    // submit form to reload results with server-side sort
                    form.submit();
                    close();
                    return;
                }

                // fallback: client-side sort if no server-side form available
                const tableSortFn = window['dataTableSort_' + (toggle.dataset.targetTableId || '')];
                if (typeof tableSortFn === 'function') {
                    tableSortFn(col);
                } else {
                    for (const k in window) {
                        if (k.startsWith('dataTableSort_') && typeof window[k] === 'function') {
                            window[k](col);
                            break;
                        }
                    }
                }
                close();
            });
        });
        // close dropdown when clicking outside
        document.addEventListener('click', function(e){ if (!wrap.contains(e.target)) close(); });
    })();
</script>
