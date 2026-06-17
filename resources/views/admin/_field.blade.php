@php
    /* expects: $name (html name), $file (html name for upload or null), $meta, $value */
    $type = $meta['type'];
@endphp
<div class="field">
    <label>{{ $meta['label'] }}</label>
    @if ($type === 'textarea')
        <textarea name="{{ $name }}">{{ $value }}</textarea>
    @elseif ($type === 'checkbox')
        <label class="check"><input type="checkbox" name="{{ $name }}" value="1" @checked($value)> Yes</label>
    @elseif ($type === 'taglist')
        <input type="text" name="{{ $name }}" value="{{ is_array($value) ? implode(', ', $value) : $value }}">
    @elseif ($type === 'image')
        <div class="imgfield">
            <img class="imgfield__prev" src="{{ $value ? asset($value) : '' }}" alt="" onerror="this.style.visibility='hidden'">
            <div class="imgfield__body">
                <input type="text" name="{{ $name }}" value="{{ $value }}" placeholder="e.g. img/hero.jpg">
                <input type="file" name="{{ $file }}" accept="image/*" style="margin-top:.45rem">
                <p class="hint">Upload an image to replace, or leave as-is.</p>
            </div>
        </div>
    @else
        <input type="text" name="{{ $name }}" value="{{ $value }}">
    @endif
</div>
