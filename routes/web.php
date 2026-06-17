<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('cv', ['p' => config('profile')]);
});

// Redesign mockup (verstappen-inspired).
Route::get('/mockup', function () {
    return view('mockup', ['p' => config('profile')]);
});
