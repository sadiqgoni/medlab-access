<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function() {
    return view('landing');
});

// Contact form submission route
Route::post('/contact', function() {
    // Log the form submission
    Log::info('Contact form submission', request()->only(['name', 'email', 'subject', 'message']));
    
    // In a real application, you would process the form data here
    // For example, send an email, store in database, etc.
    
    // Return JSON response for AJAX submissions
    if (request()->ajax()) {
        return response()->json([
            'success' => true,
            'message' => 'Thank you for your message! We will get back to you soon.'
        ]);
    }
    
    // Redirect back with success message for regular form submissions
    return back()->with('success', 'Thank you for your message! We will get back to you soon.');
});

// Demo routes for the platform
Route::prefix('demo')->group(function() {
    Route::get('/lab-tests', function() {
        return view('demo.lab-tests');
    })->name('demo.lab-tests');
    
    Route::get('/blood-donation', function() {
        return view('demo.blood-donation');
    })->name('demo.blood-donation');
});
