<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <title>Admin · @yield('title', 'Content')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('img/logo-mark-64.png') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ @filemtime(public_path('css/admin.css')) ?: '1' }}">
</head>
<body>
<div class="shell">
    <aside class="side">
        <div class="side__brand"><img src="{{ asset('img/logo-mark.png') }}" alt=""> Admin</div>
        <a href="{{ route('admin.dashboard') }}" class="nav {{ ($activeKey ?? '') === 'dashboard' ? 'active' : '' }}">🏠 Dashboard</a>
        <div class="side__sep"></div>
        @foreach (config('content_schema') as $k => $s)
            <a href="{{ route('admin.section.edit', $k) }}" class="nav {{ ($activeKey ?? '') === $k ? 'active' : '' }}">{{ $s['icon'] }} {{ $s['label'] }}</a>
        @endforeach
        <div class="side__sep"></div>
        <a href="{{ route('admin.account') }}" class="nav {{ ($activeKey ?? '') === 'account' ? 'active' : '' }}">⚙️ Account</a>
        <div class="side__foot">
            <a href="{{ url('/') }}" target="_blank" rel="noopener" class="btn btn--ghost btn--block">View site ↗</a>
            <form method="post" action="{{ route('admin.logout') }}">@csrf<button class="btn btn--ghost btn--block">Log out</button></form>
        </div>
    </aside>
    <main class="main">
        @if (session('ok'))<div class="alert alert--ok">{{ session('ok') }}</div>@endif
        @if ($errors->any())
            <div class="alert alert--err">Please fix the following:<ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        @endif
        @yield('content')
    </main>
</div>
</body>
</html>
