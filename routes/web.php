<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\OrderController;
use App\Models\User;
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

//Route::get('/test', function () {
//
//});

Route::get('/email', function () {
    /** @var User $user */
    $user = \Illuminate\Support\Facades\Auth::user();

    $user->notify(new InvoicePaid());
});

Route::get('/search', function () {
    try {
        $client = new MeiliSearch\Client("http://meilisearch:7700", "masterKey");
        $client->index('products')->updateFilterableAttributes(['team_id']);

        return \App\Models\Post::search('test')->where('user_id', 1)->get();
    } catch (\Throwable $th) {
        dump($th->getTraceAsString());
    }
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

    Route::resource('orders', OrderController::class)
        ->only(['create', 'store']);
});
