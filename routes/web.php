<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ThemeOptionFrontController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ProductController;
use App\http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Front\FrontHomeController;


//Main Route for Index Page
Route::get('/', [FrontHomeController::class, 'index'])->name('home');

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

//Admin Theme Option Front Routes
Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {
    Route::resource('theme_option_front', ThemeOptionFrontController::class);
    // Restore and Force Delete
    Route::post('theme-option-front/restore/{id}', [ThemeOptionFrontController::class, 'restore'])->name('theme_option_front.restore');
    Route::delete('theme-option-front/force-delete/{id}', [ThemeOptionFrontController::class, 'forceDelete'])->name('theme_option_front.forceDelete');
    // Bulk Delete
    Route::delete('theme-option-front/bulk-delete', [ThemeOptionFrontController::class, 'bulkDelete'])->name('theme_option_front.bulkDelete');
});

// Admin Blog Category Routes
Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {
    // Resource CRUD routes
    Route::resource('blog-categories', BlogCategoryController::class);
    // Restore and Force Delete
    Route::post('blog-categories/restore/{id}', [BlogCategoryController::class, 'restore'])->name('blog-categories.restore');
    Route::delete('blog-categories/force-delete/{id}', [BlogCategoryController::class, 'forceDelete']) ->name('blog-categories.forceDelete');
    // Bulk Delete
    Route::delete('blog-categories/bulkDelete', [BlogCategoryController::class, 'bulkDelete'])
        ->name('blog-categories.bulkDelete');
});

// Admin Blog Routes
Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {
    // Resource CRUD routes
    Route::resource('blog', BlogController::class);
    // Restore and Force Delete
    Route::post('blog/restore/{id}', [BlogController::class,'restore'])->name('blog.restore');
    Route::delete('blog/force-delete/{id}', [BlogController::class,'forceDelete'])->name('blog.forceDelete');
    // Bulk Delete
    Route::delete('blog/bulk-delete', [BlogController::class, 'bulkDelete'])->name('blog.bulkDelete');
});

// Admin Service Routes
Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {
    // Resource CRUD routes
    Route::resource('services', ServiceController::class);
    // Restore and Force Delete
    Route::post('services/restore/{id}', [ServiceController::class,'restore'])->name('services.restore');
    Route::delete('services/force-delete/{id}', [ServiceController::class,'forceDelete'])->name('services.forceDelete');
    // Bulk Delete
    Route::delete('services/bulk-delete', [ServiceController::class, 'bulkDelete'])->name('services.bulkDelete');

});

// Admin ProductCategory Routes
Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {
    // Resource CRUD routes
    Route::resource('productscategories', ProductCategoryController::class);
    // Restore and Force Delete
    Route::post('productscategories/restore/{id}', [ProductCategoryController::class,'restore'])->name('productscategories.restore');
    Route::delete('productscategories/force-delete/{id}', [ProductCategoryController::class,'forceDelete'])->name('productscategories.forceDelete');
     // Bulk delete
    Route::delete('productscategories/bulkdelete', [ProductCategoryController::class, 'bulkDelete'])
        ->name('productscategories.bulkDelete');
});

// Admin Porduct Routes
Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function (){
    // Resource CRUD routes
    Route::resource('products', ProductController::class);
    // Restore and Force Delete for Products
    Route::post('products/restore/{id}', [ProductController::class, 'restore'])
        ->name('products.restore');
    Route::delete('products/force-delete/{id}', [ProductController::class, 'forceDelete'])
        ->name('products.forceDelete');
    // Bulk soft delete for Products
    Route::delete('products/bulkdelete', [ProductController::class, 'bulkDelete'])
        ->name('products.bulkDelete');
    // extra route for deleting gallery images
    Route::delete('products/gallery/{id}', [ProductController::class, 'deleteGallery'])
        ->name('products.gallery.delete');
});

// Admin Porduct Routes
Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function (){
    // Resource CRUD routes
    Route::resource('banners', BannerController::class);
    // Restore and Force Delete for Products
    Route::post('banners/restore/{id}', [BannerController::class, 'restore'])
        ->name('banners.restore');
    Route::delete('banners/force-delete/{id}', [BannerController::class, 'forceDelete'])
        ->name('banners.forceDelete');
    // Bulk soft delete for Products
    Route::delete('banners/bulkdelete', [BannerController::class, 'bulkDelete'])
        ->name('banners.bulkDelete');
});


 