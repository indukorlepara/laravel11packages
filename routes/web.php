<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubscriptionController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/subscribe', [SubscriptionController::class, 'store'])->name('subscription.store');
    // Route::post('/subscribe', [SubscriptionController::class, 'subscribe']);
    // Route::post('/update-payment-method', [SubscriptionController::class, 'updatePaymentMethod']);
    // Route::get('/subscribe', function () {
    //     return view('welcome'); // or dump something for debug
    // });
});

require __DIR__.'/auth.php';
