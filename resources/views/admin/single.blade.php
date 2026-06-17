@extends('admin.layout')
@section('title', $section['label'])
@php $activeKey = $key; @endphp

@section('content')
    <div class="crumb"><a href="{{ route('admin.dashboard') }}">Dashboard</a> / {{ $section['label'] }}</div>
    <div class="topline"><h1>{{ $section['icon'] }} {{ $section['label'] }}</h1></div>

    <form method="post" action="{{ route('admin.section.update', $key) }}" enctype="multipart/form-data">
        @csrf
        <div class="panel">
            @foreach ($section['fields'] as $field => $meta)
                @include('admin._field', [
                    'name'  => $field,
                    'file'  => $field . '_file',
                    'meta'  => $meta,
                    'value' => $value[$field] ?? '',
                ])
            @endforeach
        </div>
        <div class="actions">
            <button class="btn btn--primary" type="submit">Save changes</button>
            <a class="btn btn--ghost" href="{{ route('admin.dashboard') }}">Cancel</a>
        </div>
    </form>
@endsection
