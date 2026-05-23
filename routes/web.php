<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\EventController as EventAdminController;
use App\Http\Controllers\Admin\PartnerController;

// ==========================================
// Rute User Area
// ==========================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/event/{id}', [EventController::class, 'show'])->name('events.show');
Route::get('/checkout', [EventController::class, 'checkout'])->name('checkout');
Route::get('/my-ticket', [TicketController::class, 'show'])->name('ticket');

Route::get('/bantuan', [HomeController::class, 'bantuan'])->name('bantuan');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/profil', [HomeController::class, 'profil'])->name('profil');


// ==========================================
// Rute Admin Area
// ==========================================
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    
    // Dashboard Utama Admin
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // CRUD Resource untuk Events (Menggunakan EventAdminController)
    Route::resource('events', EventAdminController::class);
    
    // CRUD Resource untuk Kategori (Mengaktifkan fitur Tambah, Edit, dan Hapus)
    Route::resource('categories', CategoryController::class);
    
    // Laporan Transaksi
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    
});


Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('events', EventAdminController::class);
    Route::resource('categories', CategoryController::class);
    
    // Tambahkan baris partner ini:
    Route::resource('partners', PartnerController::class); 
    
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
});