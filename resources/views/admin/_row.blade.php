@php /* expects: $i (index or __IDX__), $section, $item (array of values) */ @endphp
<div class="row" data-row>
    <div class="row__bar">
        <span class="row__num">#</span>
        <div class="row__tools">
            <button type="button" class="iconbtn" data-up title="Move up">↑</button>
            <button type="button" class="iconbtn" data-down title="Move down">↓</button>
            <button type="button" class="iconbtn del" data-del title="Remove">✕</button>
        </div>
    </div>
    @foreach ($section['fields'] as $field => $meta)
        @include('admin._field', [
            'name'  => "items[$i][$field]",
            'file'  => "items[$i][{$field}_file]",
            'meta'  => $meta,
            'value' => $item[$field] ?? '',
        ])
    @endforeach
</div>
