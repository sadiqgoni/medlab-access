<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'max:20', 'unique:'.User::class],
            'address' => ['required', 'string', 'max:1000'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'communication_preference' => ['required', 'string', Rule::in(['email', 'sms', 'app'])],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
    
        $latitude = $validated['latitude'] ?? null;
        $longitude = $validated['longitude'] ?? null;
        $googleMapsApiKey = env('GOOGLE_MAPS_API_KEY');
    
        // Fallback to geocoding if coordinates not provided
        if (!$latitude || !$longitude) {
            if (!empty($validated['address']) && $googleMapsApiKey) {
                try {
                    $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
                        'address' => $validated['address'],
                        'key' => $googleMapsApiKey,
                        'components' => 'country:NG',
                    ]);
    
                    if ($response->successful()) {
                        $data = $response->json();
                        Log::info("Google Maps geocoding response for address: {$validated['address']}", ['response' => $data]);
                        if ($data['status'] === 'OK' && !empty($data['results'])) {
                            $location = $data['results'][0]['geometry']['location'];
                            $latitude = $location['lat'];
                            $longitude = $location['lng'];
                            Log::info("Geocoded address: {$validated['address']} -> [{$longitude}, {$latitude}]");
                        } else {
                            Log::warning("No geocoding results for address: {$validated['address']}", ['response' => $data]);
                        }
                    } else {
                        Log::warning("Google Maps API request failed for address: {$validated['address']}", [
                            'status' => $response->status(),
                            'body' => $response->body(),
                        ]);
                    }
                } catch (\Exception $e) {
                    Log::error("Geocoding exception for address: {$validated['address']}", ['error' => $e->getMessage()]);
                }
            } else {
                Log::warning("Skipping geocoding. Address or API key missing.", [
                    'address' => $validated['address'],
                    'api_key' => $googleMapsApiKey ? 'present' : 'missing',
                ]);
            }
        } else {
            Log::info("Using provided coordinates for address: {$validated['address']} -> [{$longitude}, {$latitude}]");
        }
    
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'latitude' => $latitude,
            'longitude' => $longitude,
            'password' => Hash::make($validated['password']),
            'role' => 'consumer',
        ]);
    
        event(new Registered($user));
        Auth::login($user);
    
        return redirect(route('consumer.dashboard', absolute: false));
    }
}