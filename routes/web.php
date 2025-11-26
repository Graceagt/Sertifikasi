<?php

use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserDashboardController;
use Illuminate\Support\Facades\Route;


// =======================
// AUTH
// =======================
Route::get('/register',[AuthController::class,'showRegisterForm']);
Route::post('/register',[AuthController::class,'register']);
Route::get('/login',[AuthController::class,'showLoginForm']);
Route::post('/login',[AuthController::class,'login']);
Route::post('/logout',[AuthController::class,'logout']);


// =======================
// ADMIN
// =======================
Route::middleware(['auth','admin'])->group(function(){
    // Dashboard admin
    Route::get('/admin/dashboard',[AdminController::class,'index'])->name('admin.dashboard');

    // Daftar peminjaman
    Route::get('/admin/borrowings', [AdminController::class,'borrowings'])->name('admin.borrowings.index');

    // Approve / reject / return
    Route::post('/admin/borrowings/{id}/approve',[AdminController::class,'approve'])->name('admin.borrowings.approve');
    Route::post('/admin/borrowings/{id}/reject',[AdminController::class,'reject'])->name('admin.borrowings.reject');
    Route::post('/admin/borrowings/{id}/return',[AdminController::class,'returnBook'])->name('admin.borrowings.return');

    // CRUD Buku
    Route::post('/admin/books',[AdminController::class,'storeBook'])->name('admin.books.store');
    Route::put('/admin/books/{id}',[AdminController::class,'updateBook'])->name('admin.books.update');
});

// =======================
// USER DASHBOARD
// =======================
    Route::middleware(['auth'])->group(function () {
    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])
        ->name('user.dashboard');

    Route::get('/borrow', [BorrowingController::class, 'create']);
    Route::post('/borrowings', [BorrowingController::class, 'store'])->name('borrowings.store');
    Route::get('/borrowings', [BorrowingController::class, 'index']);

});


// =======================
// DEFAULT DASHBOARD (optional)
// =======================
Route::middleware('auth')->get('/dashboard', [DashboardController::class, 'index']);

