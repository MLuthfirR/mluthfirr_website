@extends('admin.layout')
@section('title', 'Account')
@php $activeKey = 'account'; @endphp

@section('content')
    <div class="crumb"><a href="{{ route('admin.dashboard') }}">Dashboard</a> / Account</div>
    <div class="topline"><h1>⚙️ Account</h1></div>

    <form method="post" action="{{ route('admin.account') }}">
        @csrf
        <div class="panel">
            <div class="field">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email', $account['email'] ?? '') }}" required>
            </div>
            <div class="field">
                <label>New password</label>
                <input type="password" name="password" autocomplete="new-password">
                <p class="hint">Leave blank to keep your current password. Minimum 8 characters.</p>
            </div>
            <div class="field">
                <label>Confirm new password</label>
                <input type="password" name="password_confirmation" autocomplete="new-password">
            </div>
        </div>
        <div class="actions">
            <button class="btn btn--primary" type="submit">Update account</button>
            <a class="btn btn--ghost" href="{{ route('admin.dashboard') }}">Cancel</a>
        </div>
    </form>
@endsection
