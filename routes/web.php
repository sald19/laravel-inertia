<?php

use App\Http\Controllers\PostController;
use App\Notifications\InvoicePaid;
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

Route::get('/email', function () {
    $user = \Illuminate\Support\Facades\Auth::user();

    $user->notify(new InvoicePaid());
});

Route::get('/search', function () {
    return \App\Models\Post::search('test')->where('user_id', 1)->get();
});

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::resource('posts', PostController::class)
        ->only(['create', 'index', 'show', 'store']);

//    Route::get('posts/create', [PostController::class, 'create'])
//        ->name('posts')
//        ->middleware('auth');
});
