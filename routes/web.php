<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
    
    // Consumer Routes - Directly apply the VerifyIsConsumer middleware to each route
    Route::get('/consumer/dashboard', function () {
        return view('consumer.dashboard');
    })->middleware(['auth', \App\Http\Middleware\VerifyIsConsumer::class])->name('consumer.dashboard');
    
    // Consumer order routes
    Route::get('/consumer/orders/create', [App\Http\Controllers\ConsumerOrderController::class, 'create'])
        ->middleware(['auth', \App\Http\Middleware\VerifyIsConsumer::class])
        ->name('consumer.orders.create');
        
    Route::post('/consumer/orders', [App\Http\Controllers\ConsumerOrderController::class, 'store'])
        ->middleware(['auth', \App\Http\Middleware\VerifyIsConsumer::class])
        ->name('consumer.orders.store');
        
    Route::get('/consumer/orders', [App\Http\Controllers\ConsumerOrderController::class, 'index'])
        ->middleware(['auth', \App\Http\Middleware\VerifyIsConsumer::class])
        ->name('consumer.orders.index');
        
    Route::get('/consumer/orders/{order}', [App\Http\Controllers\ConsumerOrderController::class, 'show'])
        ->middleware(['auth', \App\Http\Middleware\VerifyIsConsumer::class])
        ->name('consumer.orders.show');
});

require __DIR__.'/auth.php';
