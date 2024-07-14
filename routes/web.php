<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/admins', [UserController::class, 'index'])->name('admin.index');
    Route::get('/admins/create', [UserController::class, 'create'])->name('admin.create');
    Route::post('/admins/store', [UserController::class, 'store'])->name('admin.store');
    Route::delete('/admins/{id}', [UserController::class, 'destroy'])->name('admin.destroy');

    Route::get('/product', [ProductController::class, 'index'])->name('product.index');
    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
    Route::get('/product/{id}', [ProductController::class, 'edit'])->name('product.edit');
    Route::post('/product/update/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
    
    Route::get('/forms', [FormController::class, 'index'])->name('forms.index');
    Route::get('/forms/create', [FormController::class, 'create'])->name('forms.create');
    Route::post('/form/store', [FormController::class, 'store'])->name('forms.store');
    Route::get('/forms/{date}', [FormController::class, 'info'])->name('forms.info');
    Route::get('/forms/{form}/edit', [FormController::class, 'edit'])->name('forms.edit');
    Route::put('/forms/{form}', [FormController::class, 'update'])->name('forms.update');
    Route::delete('/forms/{form}', [FormController::class, 'destroy'])->name('forms.destroy');
    Route::get('forms/{form}/switch-status', [FormController::class, 'switchStatus'])->name('forms.switch-status');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';
