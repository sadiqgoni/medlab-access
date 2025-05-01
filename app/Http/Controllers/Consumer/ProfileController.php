<?php

namespace App\Http\Controllers\Consumer;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Http;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('consumer.profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $user = $request->user();

        $latitude = $validated['latitude'] ?? null;
        $longitude = $validated['longitude'] ?? null;
        $googleMapsApiKey = env('GOOGLE_MAPS_API_KEY');

        // Fallback to geocoding if coordinates not provided
        if (is_null($latitude) || is_null($longitude)) {
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

        // Update user with validated data and coordinates
        $user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'latitude' => $latitude,
            'longitude' => $longitude,
            // Add other fields as needed
        ]);
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
