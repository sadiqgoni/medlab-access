<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RedirectBasedOnRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // Redirect based on user role
            $role = Auth::user()->role;
            
            if ($request->is('dashboard')) {
                switch ($role) {
                    case 'admin':
                        return redirect('/admin');
                    case 'provider':
                        return redirect('/provider');
                    case 'biker':
                        return redirect('/biker');
                    case 'consumer':
                        return redirect('/consumer/dashboard');
                    default:
                        // For unknown roles, default to consumer dashboard
                        return redirect('/consumer/dashboard');
                }
            }
            
            // For protected routes, ensure the user has the appropriate role
            if ($request->is('admin*') && $role !== 'admin') {
                return redirect('/')->with('error', 'You do not have permission to access the admin area.');
            }
            
            if ($request->is('provider*') && $role !== 'provider') {
                return redirect('/')->with('error', 'You do not have permission to access the provider area.');
            }
            
            if ($request->is('biker*') && $role !== 'biker') {
                return redirect('/')->with('error', 'You do not have permission to access the biker area.');
            }
            
            if ($request->is('consumer*') && $role !== 'consumer') {
                return redirect('/')->with('error', 'You do not have permission to access the consumer area.');
            }
        }

        return $next($request);
    }
}
