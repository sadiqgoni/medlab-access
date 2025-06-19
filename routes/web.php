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
use Illuminate\Http\Request;


// Public routes
Route::get('/', function () {
    return view('landing');
})->name('landing');

// Coming Soon route
Route::get('/coming-soon', function () {
    return view('coming-soon');
})->name('coming-soon');

// Contact form submission - Redirect to WhatsApp
Route::post('/contact', function (Request $request) {
    $name = $request->input('name', 'Guest');
    $email = $request->input('email', '');
    $subject = $request->input('subject', 'Contact from website');
    $message = $request->input('message', '');
    
    // Format WhatsApp message
    $whatsappMessage = "Hello DHR SPACE!\n\n";
    $whatsappMessage .= "Name: {$name}\n";
    $whatsappMessage .= "Email: {$email}\n";
    $whatsappMessage .= "Subject: {$subject}\n\n";
    $whatsappMessage .= "Message:\n{$message}";
    
    $whatsappUrl = "https://wa.me/2347015262726?text=" . urlencode($whatsappMessage);
    
    return redirect()->away($whatsappUrl);
})->name('contact.submit');

// Provider Registration Routes - Redirected to Coming Soon
Route::get('/provider/register', function () {
    return redirect()->route('coming-soon');
})->middleware('guest')->name('provider.register');
    
Route::post('/provider/register', function () {
    return redirect()->route('coming-soon');
})->middleware('guest')->name('provider.register.store');

// Provider Registration Confirmation - Redirected to Coming Soon
Route::get('/provider/registration-confirmation', function () {
    return redirect()->route('coming-soon');
})->middleware('guest')->name('provider.registration.confirmation');


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
