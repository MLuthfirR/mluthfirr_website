<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('mockup', ['p' => config('profile')]);
});

// Alternate sport-brand concept (Lando-Norris-genre inspired).
Route::get('/mockup', function () {
    return view('sport', ['p' => config('profile')]);
});
