<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();



Route::get('/home', [HomeController::class, 'index'])->name('home');


//Admin Profile Routes
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('admin.profile.view');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('admin.profile.update');
    Route::get('/profile/image', [ProfileController::class, 'editImage'])->name('admin.profile.image.edit');
    Route::post('/profile/image', [ProfileController::class, 'updateImage'])->name('admin.profile.image.update');
    Route::get('/profile/change-password', [ProfileController::class, 'editPassword'])->name('admin.profile.password.edit');
    Route::post('/profile/change-password', [ProfileController::class, 'updatePassword'])->name('admin.profile.password.update');
});
