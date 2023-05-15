<?php

use App\Data\WelcomeData;
use App\Http\Controllers\ActionController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProfileController;
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

Route::get('/', function () {
    return Inertia::render('Welcome', WelcomeData::from([
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]));
});
Route::middleware('auth', 'verified')->group(function () {
    Route::post(
        '/like/{action}',
        [LikeController::class, 'store'],
    )->name('like.create');
    Route::delete(
        '/like/{action}',
        [LikeController::class, 'destroy'],
    )->name('like.destroy');
});

Route::get(
    '/index',
    [ActionController::class, 'index']
)->middleware(['auth', 'verified'])->name('index');

Route::middleware('auth', 'verified')->group(function () {
    Route::get(
        '/action/{id}',
        [ActionController::class, 'show']
    )->name('action.show');
    Route::post(
        '/action',
        [ActionController::class, 'store']
    )->name('action.create');
    Route::delete(
        '/action/{action}',
        [ActionController::class, 'destroy'],
    )->name('action.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
