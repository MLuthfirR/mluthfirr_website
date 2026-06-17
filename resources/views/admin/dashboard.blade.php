@extends('admin.layout')
@section('title', 'Dashboard')
@php $activeKey = 'dashboard'; @endphp

@section('content')
    <div class="topline"><h1>Content Dashboard</h1></div>
    <p style="color:var(--mut);margin-top:-1rem;margin-bottom:1.6rem">Pick a section to edit. Changes go live on your site immediately.</p>

    <div class="cards">
        <a class="card" href="{{ route('admin.analytics') }}" style="border-color:var(--acc)">
            <div class="card__ic">📈</div>
            <div class="card__t">Analytics</div>
            <div class="card__c">Visitors &amp; traffic report</div>
        </a>
        @foreach ($schema as $key => $s)
            @php
                $val = $content[$key] ?? null;
                $count = ($s['type'] === 'collection') ? count($val ?? []) : null;
            @endphp
            <a class="card" href="{{ route('admin.section.edit', $key) }}">
                <div class="card__ic">{{ $s['icon'] }}</div>
                <div class="card__t">{{ $s['label'] }}</div>
                <div class="card__c">
                    @if ($s['type'] === 'collection')
                        {{ $count }} {{ \Illuminate\Support\Str::plural('item', $count) }}
                    @else
                        Edit details
                    @endif
                </div>
            </a>
        @endforeach
    </div>
@endsection
