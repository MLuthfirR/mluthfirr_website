<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('sport', ['p' => config('profile')]);
});

// Old mockup URL now redirects to the homepage (the design lives at "/").
Route::redirect('/mockup', '/', 301);
