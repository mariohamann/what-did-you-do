<?php

use App\Http\Controllers\ActionController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get(
    '/',
    fn () => Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ])
);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', fn () => Inertia::render('Dashboard'))->name(
        'dashboard'
    );

    Route::post('actions', [ActionController::class, 'store']);
    Route::get('actions/{action}', [ActionController::class, 'show']);
    Route::delete('actions/{action}', [ActionController::class, 'destroy']);
    Route::patch('actions/{action}/archive', [ActionController::class, 'archive']);
    Route::patch('actions/{action}/like', [ActionController::class, 'like']);

    Route::get('/me', [ActionController::class, 'indexMe'])->name('me');
    Route::get('/others', [ActionController::class, 'indexOthers'])->name('others');
});
