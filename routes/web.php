<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------|
| Web Routes                                                              |
|--------------------------------------------------------------------------|
| Here is where you can register web routes for your application. These   |
| routes are loaded by the RouteServiceProvider within a group which      |
| contains the "web" middleware group. Now create something great!        |
|--------------------------------------------------------------------------|
*/

// Public routes
Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

// Authentication routes
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Admin routes (protected by 'auth' and 'admin' middleware)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    // Product management routes using AdminController
    Route::get('products', [AdminController::class, 'index'])->name('products.index');
    Route::get('products/create', [AdminController::class, 'create'])->name('products.create');
    Route::post('products', [AdminController::class, 'store'])->name('products.store');
    Route::get('products/{product}/edit', [AdminController::class, 'edit'])->name('products.edit');
    Route::put('products/{product}', [AdminController::class, 'update'])->name('products.update');
    Route::delete('products/{product}', [AdminController::class, 'destroy'])->name('products.destroy');

    // Category management routes using CategoryController
    Route::resource('categories', CategoryController::class);

    // Order management routes (optional, remove if not needed)
    Route::resource('orders', OrderController::class)->except(['create', 'store']);
});
