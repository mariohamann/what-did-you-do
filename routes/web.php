<?php

use App\Http\Controllers\ActionController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [ActionController::class, 'index'])->name('index');
Route::get('/action/{id}', [ActionController::class, 'show'])->name('action.show');

Route::middleware('auth', 'verified')->group(function () {
    Route::post(
        '/action',
        [ActionController::class, 'store']
    )->name('action.create');
    Route::delete(
        '/action/{action}',
        [ActionController::class, 'destroy'],
    )->name('action.destroy');

    // Likes
    Route::post(
        '/like/{action}',
        [LikeController::class, 'store'],
    )->name('like.create');
    Route::delete(
        '/like/{action}',
        [LikeController::class, 'destroy'],
    )->name('like.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
