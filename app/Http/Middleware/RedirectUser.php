<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Filament\Facades\Filament;

class RedirectUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        
        // If no user is authenticated, continue with the request (Filament will handle auth)
        if (!$user) {
            return $next($request);
        }
        
        $role = $user->role;
        
        // Get the current panel ID
        $panel = Filament::getCurrentPanel()?->getId();
        
        // If no panel is found (e.g., non-Filament routes), continue
        if (!$panel) {
            return $next($request);
        }
        
        // Handle redirection based on role and panel
        switch ($role) {
            case 'admin':
                if ($panel !== 'admin') {
                    return redirect()->route('filament.admin.pages.dashboard');
                }
                break;
                
            case 'provider':
                if ($panel !== 'provider') {
                    return redirect()->route('filament.provider.pages.dashboard');
                }
                break;
                
            case 'biker':
                if ($panel !== 'biker') {
                    return redirect()->route('filament.biker.pages.dashboard');
                }
                break;
                
            case 'consumer':
                // Consumers shouldn't access any Filament panel, redirect to consumer dashboard
                return redirect('/consumer/dashboard');
                
            default:
                // For unknown roles, continue with the request
                break;
        }
        
        return $next($request);
    }
} 