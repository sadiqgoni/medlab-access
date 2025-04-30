<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RedirectToFilamentLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // If the request is for /admin paths and the user is not logged in
        if ($request->is('admin*') && !Auth::check()) {
            // Redirect to Filament's login page
            return redirect('/admin/login');
        }

        // If user is trying to access /admin paths but is not an admin
        if ($request->is('admin*') && Auth::check() && Auth::user()->role !== 'admin') {
            // Redirect to the landing page with an error message
            return redirect('/')->with('error', 'You do not have permission to access the admin area.');
        }

        return $next($request);
    }
}
