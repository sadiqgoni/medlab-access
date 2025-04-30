<?php

use App\Http\Controllers\Consumer\DashboardController;
use App\Http\Controllers\ConsumerOrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\VerifyIsConsumer;

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
        
        // Profile
        Route::get('/profile', [App\Http\Controllers\Consumer\ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [App\Http\Controllers\Consumer\ProfileController::class, 'update'])->name('profile.update');
    });
});

require __DIR__.'/auth.php';
