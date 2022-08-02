<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Doing;

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
    "/",
    fn() => Inertia::render("Welcome", [
        "canLogin" => Route::has("login"),
        "canRegister" => Route::has("register"),
        "laravelVersion" => Application::VERSION,
        "phpVersion" => PHP_VERSION,
    ])
);

Route::middleware([
    "auth:sanctum",
    config("jetstream.auth_session"),
    "verified",
])->group(function () {
    Route::get("/dashboard", fn() => Inertia::render("Dashboard"))->name(
        "dashboard"
    );

    Route::get(
        "/me",
        fn() => Inertia::render("List", [
            "title" => "My Doings",
            "doings" => Doing::where(
                "user_id",
                "=",
                auth()->user()->id
            )->paginate(24),
        ])
    )->name("me");

    Route::get(
        "/others",
        fn() => Inertia::render("List", [
            "title" => "Doings of others",
            "doings" => Doing::where(
                "user_id",
                "<>",
                auth()->user()->id
            )->paginate(24),
        ])
    )->name("others");
});
