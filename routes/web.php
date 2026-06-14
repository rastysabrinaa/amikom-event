<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\WelcomeController;

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\EventController as EventAdminController;
use App\Http\Controllers\Admin\PartnerController;

// ==========================================
// Rute User Area (Frontend)
// ==========================================
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/event/{id}', [EventController::class, 'show'])->name('events.show');
Route::get('/checkout', [EventController::class, 'checkout'])->name('checkout');
Route::get('/my-ticket', [TicketController::class, 'show'])->name('ticket');

Route::get('/bantuan', [HomeController::class, 'bantuan'])->name('bantuan');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/profil', [HomeController::class, 'profil'])->name('profil');


// ==========================================
// Rute Admin Area (Prefix: /admin)
// ==========================================
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {

    // 1. Rute Autentikasi Admin (Bisa diakses tanpa login)
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // 2. Rute Proteksi Admin (Wajib Login)
    Route::group(['middleware' => ['auth']], function () {
        
        // URL: http://127.0.0.1:8000/admin/dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // CRUD Resources
        Route::resource('events', EventAdminController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('partners', PartnerController::class);
        
        Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    });

});

// Fallback rute 'login' global agar middleware 'auth' bawaan Laravel tidak error
Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');