<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <title>Admin Login</title>
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
        <h1>Admin Login</h1>
        <p class="sub">Sign in to edit your site content.</p>
        @if ($errors->any())
            <div class="alert alert--err">{{ $errors->first() }}</div>
        @endif
        <form method="post" action="{{ route('admin.login') }}">
            @csrf
            <div class="field">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" autofocus required>
            </div>
            <div class="field">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            @if (config('services.turnstile.sitekey'))
                <div class="cf-turnstile" data-sitekey="{{ config('services.turnstile.sitekey') }}" data-theme="light" style="margin:0 0 14px"></div>
            @endif
            <button class="btn btn--primary btn--block" type="submit">Sign in</button>
        </form>
    </div>
</div>
</body>
</html>
