<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PendakiController;
use App\Http\Controllers\GunungController;
use App\Http\Controllers\OrangHilangController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\BlacklistController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::post('/midtrans/callback', [PendakiController::class, 'paymentCallback'])->name('midtrans.callback');

Route::get('/orang-hilang', [OrangHilangController::class, 'publicIndex'])->name('orang-hilang.public');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/secure-document/{type}/{id}', [DocumentController::class, 'view'])->name('document.secure');
    
    Route::prefix('pendaki')->name('pendaki.')->middleware('role:pendaki')->group(function () {
        Route::get('/dashboard', [PendakiController::class, 'dashboard'])->name('dashboard');
        Route::get('/pendaftaran/create', [PendakiController::class, 'createPendaftaran'])->name('pendaftaran.create');
        Route::post('/pendaftaran', [PendakiController::class, 'storePendaftaran'])->name('pendaftaran.store');
        Route::get('/pendaftaran/{id}', [PendakiController::class, 'showPendaftaran'])->name('pendaftaran.show');
        Route::get('/pendaftaran/{id}/edit', [PendakiController::class, 'editPendaftaran'])->name('pendaftaran.edit');
        Route::put('/pendaftaran/{id}', [PendakiController::class, 'updatePendaftaran'])->name('pendaftaran.update');
        Route::delete('/pendaftaran/{id}', [PendakiController::class, 'cancelPendaftaran'])->name('pendaftaran.cancel');
        Route::get('/pendaftaran/{id}/cetak', [PendakiController::class, 'cetakPendaftaran'])->name('pendaftaran.cetak');
        Route::post('/cek-kuota', [PendakiController::class, 'cekKuota'])->name('cek-kuota');
        Route::get('/pendaftaran/{id}/payment', [PendakiController::class, 'createPayment'])->name('pendaftaran.payment');
        Route::get('/pendaftaran/{id}/payment/success', [PendakiController::class, 'paymentSuccess'])->name('pendaftaran.payment.success');
        Route::post('/pendaftaran/{id}/payment/check', [PendakiController::class, 'checkPaymentStatus'])->name('pendaftaran.payment.check');
        Route::get('/notifications', [PendakiController::class, 'notifications'])->name('notifications');
        Route::post('/notifications/read-all', [PendakiController::class, 'readAllNotifications'])->name('notifications.readAll');
    });
    
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/manifes', [AdminController::class, 'manifes'])->name('manifes');
        Route::get('/pendaftaran/{id}', [AdminController::class, 'showPendaftaran'])->name('pendaftaran.show');
        Route::put('/pendaftaran/{id}/status', [AdminController::class, 'updateStatus'])->name('pendaftaran.status');
        Route::post('/pendaftaran/{id}/check-in', [AdminController::class, 'checkIn'])->name('pendaftaran.checkin');
        Route::post('/pendaftaran/{id}/check-out', [AdminController::class, 'checkOut'])->name('pendaftaran.checkout');
        
        Route::resource('gunung', GunungController::class);
        Route::resource('orang-hilang', OrangHilangController::class)->except(['show']);
        Route::resource('blacklist', BlacklistController::class);
    });
});
