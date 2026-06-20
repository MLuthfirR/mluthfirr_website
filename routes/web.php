<?php

use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\PageController;
use App\Http\Middleware\EnsureAdmin;
use App\Http\Middleware\TrackVisit;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->middleware(TrackVisit::class);
Route::get('/sitemap.xml', [PageController::class, 'sitemap']);

// Old mockup URL now redirects to the homepage (the design lives at "/").
Route::redirect('/mockup', '/', 301);

/* ---------------- Admin panel ---------------- */
Route::prefix('admin')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('admin.login');
    Route::post('login', [AuthController::class, 'login'])->middleware([\App\Http\Middleware\VerifyTurnstile::class, 'throttle:10,1']);
    Route::get('setup', [AuthController::class, 'showSetup'])->name('admin.setup');
    Route::post('setup', [AuthController::class, 'setup'])->middleware([\App\Http\Middleware\VerifyTurnstile::class, 'throttle:10,1']);
    Route::post('logout', [AuthController::class, 'logout'])->name('admin.logout');

    Route::middleware(EnsureAdmin::class)->group(function () {
        Route::get('/', [ContentController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('analytics', [AnalyticsController::class, 'index'])->name('admin.analytics');
        Route::get('account', [ContentController::class, 'account'])->name('admin.account');
        Route::post('account', [ContentController::class, 'updateAccount']);
        Route::get('section/{key}', [ContentController::class, 'edit'])->name('admin.section.edit');
        Route::post('section/{key}', [ContentController::class, 'update'])->name('admin.section.update');
    });
});
