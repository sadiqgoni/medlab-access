<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class VerifyIsConsumer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->role === 'consumer') {
            return $next($request);
        }

        // Redirect based on role if not a consumer
        $user = Auth::user();
        if ($user) {
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('filament.admin.pages.dashboard');
                case 'provider':
                    return redirect()->route('filament.provider.pages.dashboard');
                case 'biker':
                    return redirect()->route('filament.biker.pages.dashboard');
                default:
                    return redirect('/');
            }
        }
        
        // Not authenticated
        return redirect()->route('login');
    }
}
