<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Redirect based on user role
        $user = Auth::user();
        if ($user) {
            switch ($user->role) {
                case 'admin':
                    return redirect()->intended(route('filament.admin.pages.dashboard'));
                case 'provider':
                    return redirect()->intended(route('filament.provider.pages.dashboard'));
                case 'biker':
                    return redirect()->intended(route('filament.biker.pages.dashboard'));
                case 'consumer':
                    return redirect()->intended(route('consumer.dashboard'));
                default:
                    return redirect()->intended(RouteServiceProvider::HOME);
            }
        }

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
