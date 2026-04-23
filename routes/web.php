<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Student;
use Illuminate\Support\Facades\Route;

// Root redirect
Route::get('/', fn() => redirect()->route('login'));

// Auth routes (guest only)
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',[AuthController::class, 'register'])->name('register.post');
});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// ─── ADMIN ROUTES ─────────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth', 'isAdmin'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

    // Buku
    Route::resource('books', Admin\BookController::class)->except(['show']);

    // Transaksi
    Route::get('/transactions',          [Admin\TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{transaction}', [Admin\TransactionController::class, 'show'])->name('transactions.show');
    Route::put('/transactions/{transaction}', [Admin\TransactionController::class, 'update'])->name('transactions.update');

    // Laporan
    Route::get('/reports', [Admin\ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/print', [Admin\ReportController::class, 'print'])->name('reports.print');

    // Anggota
    Route::resource('members', Admin\MemberController::class)->except(['show']);
});

// ─── STUDENT ROUTES ───────────────────────────────────────────────────────────
Route::prefix('student')->name('student.')->middleware(['auth', 'isStudent'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [Student\DashboardController::class, 'index'])->name('dashboard');

    // Katalog Buku
    Route::get('/books', [Student\BookController::class, 'index'])->name('books.index');

    // Transaksi
    Route::get('/transactions',                         [Student\TransactionController::class, 'index'])->name('transactions.index');
    Route::post('/transactions',                        [Student\TransactionController::class, 'store'])->name('transactions.store');
    Route::patch('/transactions/{transaction}/kembali', [Student\TransactionController::class, 'kembali'])->name('transactions.kembali');
});
