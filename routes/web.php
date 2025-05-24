<?php

use App\Http\Controllers\Consumer\DashboardController;
use App\Http\Controllers\Consumer\ProfileController;
use App\Http\Controllers\ConsumerOrderController;
use App\Http\Controllers\Auth\ProviderRegistrationController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Biker\BikerController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\VerifyIsConsumer;
use App\Http\Middleware\VerifyIsBiker;


// Public routes
Route::get('/', function () {
    return view('landing');
});

// Provider Registration Routes
Route::get('/provider/register', [ProviderRegistrationController::class, 'create'])
    ->middleware('guest')
    ->name('provider.register');
    
Route::post('/provider/register', [ProviderRegistrationController::class, 'store'])
    ->middleware('guest')
    ->name('provider.register.store');

// Provider Registration Confirmation
Route::get('/provider/registration-confirmation', [ProviderRegistrationController::class, 'confirmation'])
    ->middleware('guest')
    ->name('provider.registration.confirmation');


// Authenticated routes
Route::middleware('auth')->group(function () {
    // Consumer Routes
    Route::middleware(VerifyIsConsumer::class)->prefix('consumer')->name('consumer.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Profile routes
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::post('/profile/location', [ProfileController::class, 'updateLocation'])->name('profile.update.location');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        
        // Orders routes
        Route::get('/orders', [ConsumerOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/create', [ConsumerOrderController::class, 'create'])->name('orders.create');
        Route::post('/orders', [ConsumerOrderController::class, 'store'])->name('orders.store');
        Route::get('/orders/{order}', [ConsumerOrderController::class, 'show'])->name('orders.show');
        Route::post('/orders/{order}/payment', [ConsumerOrderController::class, 'confirmPayment'])->name('orders.payment.confirm');
        Route::get('/orders/{order}/confirmation', [ConsumerOrderController::class, 'confirmation'])->name('orders.confirmation');
        Route::post('/orders/{order}/cancel', [ConsumerOrderController::class, 'cancel'])->name('orders.cancel');
    });
    
    // Biker Routes
    Route::middleware(VerifyIsBiker::class)->prefix('biker')->name('biker.')->group(function () {
        // Map routes
        Route::get('/orders/{order}/map', [BikerController::class, 'mapRoute'])->name('map-route');
        // Order status update
        Route::post('/orders/{order}/status', [BikerController::class, 'updateOrderStatus'])->name('update-order-status');
    });
});

// Add logout route
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

require __DIR__.'/auth.php';
