@extends('admin.layout')
@section('title', 'Analytics')
@php
    use App\Support\Analytics;
    $activeKey = 'analytics';
    $d = $data;
    $labels  = array_map(fn ($s) => \Illuminate\Support\Carbon::parse($s['date'])->format('M j'), $d['series']);
    $vViews  = array_map(fn ($s) => $s['views'], $d['series']);
    $vUniq   = array_map(fn ($s) => $s['uniq'], $d['series']);
    $rangeLabel = $days === 0 ? 'All time' : "Last {$days} days";
    $maxRef = max(1, ...(array_values($d['referrers']) ?: [1]));
    $maxCty = max(1, ...(array_values($d['countries']) ?: [1]));
@endphp

@section('content')
    <div class="crumb"><a href="{{ route('admin.dashboard') }}">Dashboard</a> / Analytics</div>
    <div class="topline">
        <h1>📈 Analytics</h1>
        <div class="range">
            @foreach (['7' => '7 days', '30' => '30 days', '90' => '90 days', '0' => 'All'] as $v => $lbl)
                <a href="{{ route('admin.analytics', ['days' => $v]) }}" class="{{ (string) $days === (string) $v ? 'on' : '' }}">{{ $lbl }}</a>
            @endforeach
        </div>
    </div>

    @if ($d['totalViews'] === 0)
        <div class="pbox"><div class="empty">
            <p style="font-size:2.2rem;margin:0">📭</p>
            <p>No visits recorded yet for <strong>{{ $rangeLabel }}</strong>.</p>
            <p style="font-size:.85rem">Visits are tracked automatically as people open your site. Check back soon — your own admin visits aren’t counted.</p>
        </div></div>
    @else
        <div class="kpis">
            <div class="kpi"><div class="kpi__n">{{ number_format($d['totalViews']) }}</div><div class="kpi__l">Page views</div><div class="kpi__s">{{ $rangeLabel }}</div></div>
            <div class="kpi"><div class="kpi__n">{{ number_format($d['uniqueVisitors']) }}</div><div class="kpi__l">Unique visitors</div><div class="kpi__s">by device fingerprint</div></div>
            <div class="kpi"><div class="kpi__n">{{ $d['avgPerDay'] }}</div><div class="kpi__l">Avg / day</div><div class="kpi__s">over {{ $days === 0 ? count($d['series']) : $days }} days</div></div>
            <div class="kpi"><div class="kpi__n">{{ number_format($d['todayViews']) }}</div><div class="kpi__l">Today</div><div class="kpi__s">since midnight (WIB)</div></div>
        </div>

        <div class="pbox">
            <h3>Traffic over time</h3>
            <canvas id="chTime" height="300"></canvas>
        </div>

        <div class="threecol">
            <div class="pbox"><h3>Devices</h3>@if ($d['devices'])<canvas id="chDev"></canvas>@else<p class="empty">No data</p>@endif</div>
            <div class="pbox"><h3>Browsers</h3>@if ($d['browsers'])<canvas id="chBr"></canvas>@else<p class="empty">No data</p>@endif</div>
            <div class="pbox"><h3>Operating systems</h3>@if ($d['os'])<canvas id="chOs"></canvas>@else<p class="empty">No data</p>@endif</div>
        </div>

        <div class="twocol">
            <div class="pbox">
                <h3>Top referrers</h3>
                <table class="rep">
                    <thead><tr><th>Source</th><th class="num">Views</th><th style="width:35%"></th></tr></thead>
                    <tbody>
                    @forelse (array_slice($d['referrers'], 0, 10, true) as $name => $n)
                        <tr><td>{{ $name }}</td><td class="num">{{ number_format($n) }}</td>
                            <td><div class="bar"><span style="width:{{ round($n / $maxRef * 100) }}%"></span></div></td></tr>
                    @empty
                        <tr><td colspan="3" class="empty">No data</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="pbox">
                <h3>Top countries</h3>
                <table class="rep">
                    <thead><tr><th>Country</th><th class="num">Views</th><th style="width:35%"></th></tr></thead>
                    <tbody>
                    @forelse (array_slice($d['countries'], 0, 10, true) as $cc => $n)
                        <tr><td>{{ Analytics::flag($cc) }} {{ $cc }}</td><td class="num">{{ number_format($n) }}</td>
                            <td><div class="bar"><span style="width:{{ round($n / $maxCty * 100) }}%"></span></div></td></tr>
                    @empty
                        <tr><td colspan="3" class="empty">No data</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <p style="color:var(--mut);font-size:.82rem">{{ number_format($d['bots']) }} bot/crawler hits were detected and excluded from the figures above. IPs are stored only as a salted hash.</p>

        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
        <script>
        (function () {
            if (!window.Chart) return;
            var PAL = ['#5b7a00', '#9bbf2e', '#c8e08a', '#16180f', '#6b6d63', '#b9c97e', '#e0e8c4', '#3c4a00'];
            Chart.defaults.font.family = "Inter, system-ui, sans-serif";
            Chart.defaults.color = '#6b6d63';

            new Chart(document.getElementById('chTime'), {
                type: 'bar',
                data: {
                    labels: @json($labels),
                    datasets: [
                        { label: 'Page views', data: @json($vViews), backgroundColor: '#c8e08a', borderColor: '#5b7a00', borderWidth: 1, borderRadius: 4, order: 2 },
                        { label: 'Unique visitors', data: @json($vUniq), type: 'line', borderColor: '#16180f', backgroundColor: '#16180f', tension: .35, pointRadius: 2, borderWidth: 2, order: 1 }
                    ]
                },
                options: { responsive: true, maintainAspectRatio: false, interaction: { mode: 'index', intersect: false },
                    plugins: { legend: { position: 'bottom' } }, scales: { y: { beginAtZero: true, ticks: { precision: 0 } }, x: { grid: { display: false } } } }
            });

            function doughnut(id, labels, data) {
                var el = document.getElementById(id); if (!el) return;
                new Chart(el, { type: 'doughnut', data: { labels: labels, datasets: [{ data: data, backgroundColor: PAL, borderWidth: 0 }] },
                    options: { responsive: true, maintainAspectRatio: false, cutout: '62%', plugins: { legend: { position: 'bottom', labels: { boxWidth: 12, padding: 10 } } } } });
            }
            doughnut('chDev', @json(array_keys($d['devices'])), @json(array_values($d['devices'])));
            doughnut('chBr', @json(array_keys($d['browsers'])), @json(array_values($d['browsers'])));
            doughnut('chOs', @json(array_keys($d['os'])), @json(array_values($d['os'])));
        })();
        </script>
    @endif
@endsection
