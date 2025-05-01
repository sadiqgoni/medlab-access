<?php

use App\Http\Controllers\Consumer\DashboardController;
use App\Http\Controllers\Consumer\ProfileController;
use App\Http\Controllers\ConsumerOrderController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\VerifyIsConsumer;
use App\Http\Controllers\Api\FacilityServiceController;
use App\Http\Controllers\Api\NearbyFacilityController; // Import the new controller

// Public routes
Route::get('/', function () {
    return view('landing');
});

// Default dashboard route - will redirect to appropriate dashboard based on role
Route::get('/dashboard', function () {
    $user = Auth::user();
    if (!$user) {
        return redirect('/login');
    }
    
    switch ($user->role) {
        case 'admin':
            return redirect('/admin');
        case 'provider':
            return redirect('/provider');
        case 'biker':
            return redirect('/biker');
        case 'consumer':
        default:
            return redirect('/consumer/dashboard');
    }
})->middleware(['auth'])->name('dashboard');

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Consumer Routes
    Route::middleware(VerifyIsConsumer::class)->prefix('consumer')->name('consumer.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [App\Http\Controllers\Consumer\DashboardController::class, 'index'])->name('dashboard');
        
        // Orders
        Route::resource('orders', App\Http\Controllers\ConsumerOrderController::class);
        Route::get('orders/{order}/confirmation', [App\Http\Controllers\ConsumerOrderController::class, 'confirmation'])->name('orders.confirmation'); // Add this line
        
        // Profile
        Route::get('/profile', [App\Http\Controllers\Consumer\ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [App\Http\Controllers\Consumer\ProfileController::class, 'update'])->name('profile.update');

        // Order Cancellation
        Route::patch('/orders/{order}/cancel', [App\Http\Controllers\ConsumerOrderController::class, 'cancel'])->name('orders.cancel');

        // Payment Simulation
        Route::get('/orders/{order}/payment', [App\Http\Controllers\ConsumerOrderController::class, 'showPaymentSimulation'])->name('orders.payment.simulate'); // Show page
        Route::post('/orders/{order}/confirm-payment', [App\Http\Controllers\ConsumerOrderController::class, 'confirmPayment'])->name('orders.confirm-payment'); // Handle confirmation
    });

    // TODO: Add routes for Provider, Biker, Admin panels
});

// API Routes (for internal use like fetching services)
// Moved outside the main 'auth' middleware group
Route::prefix('api')->middleware('auth:sanctum')->group(function () { // Added auth:sanctum middleware
    Route::get('/facilities/{facility}/services', [FacilityServiceController::class, 'index'])->name('api.facility.services');
    Route::get('/facilities/nearby', [NearbyFacilityController::class, 'index'])->name('api.facilities.nearby'); // Add route for nearby facilities
});

require __DIR__.'/auth.php';
