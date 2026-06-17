@extends('admin.layout')
@section('title', $section['label'])
@php $activeKey = $key; @endphp

@section('content')
    <div class="crumb"><a href="{{ route('admin.dashboard') }}">Dashboard</a> / {{ $section['label'] }}</div>
    <div class="topline"><h1>{{ $section['icon'] }} {{ $section['label'] }}</h1></div>
    <p style="color:var(--mut);margin-top:-1rem;margin-bottom:1.4rem">Add, edit, reorder (↑ ↓) or remove items, then Save.</p>

    <form method="post" action="{{ route('admin.section.update', $key) }}" enctype="multipart/form-data">
        @csrf
        <div class="rows" id="rows">
            @foreach ($value as $i => $item)
                @include('admin._row', ['i' => $i, 'section' => $section, 'item' => $item])
            @endforeach
        </div>
        <div class="actions">
            <button type="button" class="btn btn--ghost" id="addRow">+ Add item</button>
        </div>
        <div class="actions">
            <button class="btn btn--primary" type="submit">Save changes</button>
            <a class="btn btn--ghost" href="{{ route('admin.dashboard') }}">Cancel</a>
        </div>
    </form>

    <template id="rowTpl">@include('admin._row', ['i' => '__IDX__', 'section' => $section, 'item' => []])</template>

    <script>
    (function () {
        var rows = document.getElementById('rows');
        var tpl = document.getElementById('rowTpl');
        function reindex() {
            Array.prototype.forEach.call(rows.children, function (row, i) {
                var num = row.querySelector('.row__num'); if (num) num.textContent = '#' + (i + 1);
                Array.prototype.forEach.call(row.querySelectorAll('[name]'), function (el) {
                    el.name = el.name.replace(/items\[[^\]]*\]/, 'items[' + i + ']');
                });
            });
        }
        document.getElementById('addRow').addEventListener('click', function () {
            var html = tpl.innerHTML.replace(/__IDX__/g, rows.children.length);
            var tmp = document.createElement('div');
            tmp.innerHTML = html.trim();
            rows.appendChild(tmp.firstElementChild);
            reindex();
        });
        rows.addEventListener('click', function (e) {
            var btn = e.target.closest('button'); if (!btn) return;
            var row = e.target.closest('[data-row]'); if (!row) return;
            if (btn.hasAttribute('data-del')) { row.remove(); reindex(); }
            else if (btn.hasAttribute('data-up')) { var p = row.previousElementSibling; if (p) rows.insertBefore(row, p); reindex(); }
            else if (btn.hasAttribute('data-down')) { var n = row.nextElementSibling; if (n) rows.insertBefore(n, row); reindex(); }
        });
        reindex();
    })();
    </script>
@endsection
