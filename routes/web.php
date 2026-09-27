<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard',[DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/permission/create', [PermissionController::class, 'create'])->name('permission.create');
    Route::post('/permission', [PermissionController::class, 'store'])->name('permission.store');
    Route::get('/permission', [PermissionController::class, 'index'])->name('permission.index');
    Route::get('/permission/{id}/edit', [PermissionController::class, 'edit'])->name('permission.edit');
    Route::put('/permission/{id}', [PermissionController::class, 'update'])->name('permission.update');
    Route::delete('/permission/{id}', [PermissionController::class, 'destroy'])->name('permission.destroy');

    //Role routes
    Route::get('/role/create', [RoleController::class, 'create'])->name('role.create');
    Route::post('/role', [RoleController::class, 'store'])->name('role.store');
    Route::get('/role', [RoleController::class, 'index'])->name('role.index');
    Route::get('/role/{id}/edit', [RoleController::class, 'edit'])->name('role.edit');
    Route::put('/role/{id}', [RoleController::class, 'update'])->name('role.update');
    Route::delete('/role/{id}', [RoleController::class, 'destroy'])->name('role.destroy');

    //Article routes
    Route::get('/article/create', [ArticleController::class, 'create'])->name('article.create');
    Route::post('/article', [ArticleController::class, 'store'])->name('article.store');
    Route::get('/article', [ArticleController::class, 'index'])->name('article.index');
    Route::get('/article/{id}/edit', [ArticleController::class, 'edit'])->name('article.edit');
    Route::put('/article/{id}', [ArticleController::class, 'update'])->name('article.update');
    Route::delete('/article/{id}', [ArticleController::class, 'destroy'])->name('article.destroy');

    //Report routes
    Route::get('/report/create', [ReportController::class, 'create'])->name('report.create');
    Route::post('/report', [ReportController::class, 'store'])->name('report.store');
    Route::get('/report', [ReportController::class, 'index'])->name('report.index');
    Route::get('/report/search', [ReportController::class, 'search'])->name('report.search');
    Route::get('/report/{id}/edit', [ReportController::class, 'edit'])->name('report.edit');
    Route::put('/report/{id}', [ReportController::class, 'update'])->name('report.update');
    Route::delete('/report/{id}', [ReportController::class, 'destroy'])->name('report.destroy');
    Route::get('/report/export', [ReportController::class, 'export'])->name('report.export');
    
    //User routes
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
    
    
    //History routes
    Route::get('/report/{report}/history', [HistoryController::class,'reportHistory'])->name('report.history');
});

require __DIR__.'/auth.php';
