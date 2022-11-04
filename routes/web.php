<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DomainController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostTemplateController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\DashboardController;

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
    Auth::routes(); // ['register' => false]

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::get('posts', [PostController::class, 'list'])->name('dashboard.posts');
        Route::get('posts/add', [PostController::class, 'add'])->name('dashboard.post.add');
        Route::get('posts/{post_id}', [PostController::class, 'edit'])->name('dashboard.post.edit');
        Route::get('posts/{post_id}/view', [PostController::class, 'view'])->name('dashboard.post.view');
        Route::post('posts', [PostController::class, 'create'])->name('dashboard.post.create');
        Route::put('posts/{post_id}', [PostController::class, 'update'])->name('dashboard.post.update');
        Route::delete('posts/{post_id}', [PostController::class, 'delete'])->name('dashboard.post.delete');
        Route::post('upload/images', [PostController::class, 'upload']);

        Route::get('templates', [PostTemplateController::class, 'list'])->name('dashboard.templates');
        Route::get('templates/add', [PostTemplateController::class, 'add'])->name('dashboard.template.add');
        Route::get('templates/{template_id}', [PostTemplateController::class, 'edit'])->name('dashboard.template.edit');
        Route::get('view/templates/{template_id}', [PostTemplateController::class, 'view'])->name('dashboard.template.view');
        Route::get('templates/{template_id}/save', [PostTemplateController::class, 'save'])->name('dashboard.template.save');
        Route::post('templates', [PostTemplateController::class, 'create'])->name('dashboard.template.create');
        Route::put('templates/{template_id}', [PostTemplateController::class, 'update'])->name('dashboard.template.update');
        Route::delete('templates/{template_id}', [PostTemplateController::class, 'delete'])->name('dashboard.template.delete');

        Route::get('domains', [DomainController::class, 'list'])->name('dashboard.domains');
        Route::get('domains/add', [DomainController::class, 'add'])->name('dashboard.domain.add');
        Route::get('domains/{domain_id}', [DomainController::class, 'edit'])->name('dashboard.domain.edit');
        Route::post('domains', [DomainController::class, 'create'])->name('dashboard.domain.create');
        Route::put('domains/{domain_id}', [DomainController::class, 'update'])->name('dashboard.domain.update');
        Route::delete('domains/{domain_id}', [DomainController::class, 'delete'])->name('dashboard.domain.delete');

        Route::get('users', [UserController::class, 'list'])->name('dashboard.users');
        Route::get('users/add', [UserController::class, 'add'])->name('dashboard.user.add');
        Route::get('users/{user_id}', [UserController::class, 'edit'])->name('dashboard.user.edit');
        Route::put('users/{user_id}', [UserController::class, 'update'])->name('dashboard.user.update');
        Route::post('users', [UserController::class, 'create'])->name('dashboard.user.create');
    });

    Route::get('logout', [DashboardController::class, 'logout'])->name('logout');
});


Route::middleware('domain')->group(function () {
    Route::get('/', [SiteController::class, 'home'])->name('domain.home');
    Route::get('posts/{slug}', [SiteController::class, 'post'])->name('domain.post');
    Route::get('search{query?}', [SiteController::class, 'search'])->name('domain.search');
});
