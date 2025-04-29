<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class VerifyIsProvider
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated and has the 'provider' role
        if (!Auth::check() || Auth::user()->role !== 'provider') {
            // If not, abort with a 403 Forbidden error
            // Or redirect to a different page, e.g., the main login or an unauthorized page
            // abort(403, 'Unauthorized access.');
            
            // Redirecting to the home page might be friendlier
            return redirect('/')->with('error', 'You do not have permission to access this area.');
        }
        
        // If authorized, continue with the request
        return $next($request);
    }
}
