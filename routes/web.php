<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DomainController;

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

Route::prefix('dashboard')->group(function () {
    Auth::routes(['register' => false]);

    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
});


Route::middleware('domain')->group(function () {
    Route::get('/', [DomainController::class, 'home'])->name('domain.home');
    Route::get('posts/{slug}', [DomainController::class, 'post'])->name('domain.post');
    Route::get('search{query?}', [DomainController::class, 'search'])->name('domain.search');
});
