<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Action;
use App\Models\Category;

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

function getActions($me) {
    return Inertia::render("List", [
            "title" => $me ? "My Actions" : "Actions by others",
            "me" => $me,
            "categories" => Category::all(),
            "actions" => Action::where(
                "user_id",
                $me ? "=" : "<>",
                auth()->user()->id
            )
            ->orderBy('id', 'desc')
            ->paginate(24)
            ->through(function ($action) {
                $action->user = $action->author;
                return $action;
            })
        ]);
}

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
fn () => getActions(true)
    )->name("me");

    Route::post(
        "/me",
        function () {
            $attributes = Request::validate([
                'content' => 'required',
                'category_id' => 'required|exists:App\Models\Category,id',
            ]);

            Action::create([
                "user_id" => auth()->user()->id,
                ...$attributes,
            ]);
        }
    )->name("me");

    Route::get(
        "/others",
        fn () => getActions(false)
    )->name("others");
});
