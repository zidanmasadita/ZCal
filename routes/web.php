<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\NutritionController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/keuangan', [FinanceController::class, 'index'])->name('keuangan.index');
    Route::get('/kalori', [NutritionController::class, 'index'])->name('kalori.index');
    Route::get('/notifikasi', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');

    Route::get('/transactions/create', [\App\Http\Controllers\TransactionController::class, 'create'])->name('transactions.create');
    Route::post('/transactions', [\App\Http\Controllers\TransactionController::class, 'store'])->name('transactions.store');

    Route::get('/food-entries/create', [\App\Http\Controllers\FoodEntryController::class, 'create'])->name('food-entries.create');
    Route::post('/food-entries', [\App\Http\Controllers\FoodEntryController::class, 'store'])->name('food-entries.store');

    Route::get('/wallets', [\App\Http\Controllers\WalletController::class, 'index'])->name('wallets.index');
    Route::get('/wallets/create', [\App\Http\Controllers\WalletController::class, 'create'])->name('wallets.create');
    Route::post('/wallets', [\App\Http\Controllers\WalletController::class, 'store'])->name('wallets.store');
    Route::delete('/wallets/{id}', [\App\Http\Controllers\WalletController::class, 'destroy'])->name('wallets.destroy');

    Route::get('/settings/muse', [\App\Http\Controllers\MuseTokenController::class, 'index'])->name('settings.muse.index');
    Route::post('/settings/muse', [\App\Http\Controllers\MuseTokenController::class, 'store'])->name('settings.muse.store');
    Route::delete('/settings/muse/{id}', [\App\Http\Controllers\MuseTokenController::class, 'destroy'])->name('settings.muse.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo');
    Route::patch('/profile/settings', [ProfileController::class, 'updateSettings'])->name('profile.settings');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
