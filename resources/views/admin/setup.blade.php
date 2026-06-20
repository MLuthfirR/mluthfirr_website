<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <title>Create Admin Account</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('img/logo-mark-64.png') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ @filemtime(public_path('css/admin.css')) ?: '1' }}">
    @if (config('services.turnstile.sitekey'))
        <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    @endif
</head>
<body>
<div class="auth">
    <div class="auth__card">
        <img class="auth__logo" src="{{ asset('img/logo-full.png') }}" alt="">
        <h1>Create Admin Account</h1>
        <p class="sub">First-time setup — choose your login. This appears only once.</p>
        @if ($errors->any())
            <div class="alert alert--err"><ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        @endif
        <form method="post" action="{{ route('admin.setup') }}">
            @csrf
            <div class="field">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" autofocus required>
            </div>
            <div class="field">
                <label>Password</label>
                <input type="password" name="password" required>
                <p class="hint">Minimum 8 characters.</p>
            </div>
            <div class="field">
                <label>Confirm password</label>
                <input type="password" name="password_confirmation" required>
            </div>
            @if (config('services.turnstile.sitekey'))
                <div class="cf-turnstile" data-sitekey="{{ config('services.turnstile.sitekey') }}" data-theme="light" style="margin:0 0 14px"></div>
            @endif
            <button class="btn btn--primary btn--block" type="submit">Create account</button>
        </form>
    </div>
</div>
</body>
</html>
