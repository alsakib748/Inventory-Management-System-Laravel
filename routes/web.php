<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// todo: Admin All Route
Route::controller(AdminController::class)->group(function(){
    Route::prefix('admin')->group(function(){
        Route::get('/logout','destroy')->name('admin.logout');
        Route::get('/profile','Profile')->name('admin.profile');
        Route::get('/edit/profile','EditProfile')->name('edit.profile');
        Route::post('/store/profile','StoreProfile')->name('store.profile');

        Route::get('/change/password','ChangePassword')->name('change.password');
        Route::post('/update/password','UpdatePassword')->name('update.password');
    });
});

Route::get('/dashboard', function () {
    return view('admin.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
