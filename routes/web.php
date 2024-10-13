<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Pos\SupplierController;
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

// todo: Supplier All Route
Route::controller(SupplierController::class)->group(function(){
    Route::prefix('admin')->group(function(){

        Route::get('/supplier/all','SupplierAll')->name('supplier.all');
        Route::get('/supplier/add','SupplierAdd')->name('supplier.add');
        Route::post('/supplier/store','SupplierStore')->name('supplier.store');
        Route::get('/supplier/edit/{id}','SupplierEdit')->name('supplier.edit');
        Route::post('/supplier/update','SupplierUpdate')->name('supplier.update');
        Route::get('/supplier/delete/{id}','SupplierDelete')->name('supplier.delete');

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
