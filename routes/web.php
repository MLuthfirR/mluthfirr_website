<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('mockup', ['p' => config('profile')]);
});

// Old mockup URL now redirects to the homepage (the design lives at "/").
Route::redirect('/mockup', '/', 301);
