<?php

namespace App\Http\Controllers\Consumer;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = Auth::user();
        return view('consumer.profile.edit', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // Keep the original validated data
        $validated = $request->validated();
        
        $newAddress = $validated['address'];
        $latitude = $user->latitude; // Start with existing coordinates
        $longitude = $user->longitude;
        $googleMapsApiKey = env('GOOGLE_MAPS_API_KEY');

        // Check if address changed and if we should geocode
        if ($newAddress !== $user->address && !empty($newAddress) && $googleMapsApiKey) {
            Log::info("Profile Update: Address changed for user {$user->id}. Attempting geocoding for: {$newAddress}");
            try {
                $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
                    'address' => $newAddress,
                    'key' => $googleMapsApiKey,
                    'components' => 'country:NG', // Assuming Nigeria, adjust if needed
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    Log::info("Profile Update: Google Maps geocoding response for address: {$newAddress}", ['response' => $data]);
                    if ($data['status'] === 'OK' && !empty($data['results'])) {
                        $location = $data['results'][0]['geometry']['location'];
                        $latitude = $location['lat'];
                        $longitude = $location['lng'];
                        Log::info("Profile Update: Geocoded address: {$newAddress} -> [{$longitude}, {$latitude}] for user {$user->id}");
                    } else {
                        Log::warning("Profile Update: No geocoding results for address: {$newAddress} for user {$user->id}", ['response' => $data]);
                        // Keep old coordinates if geocoding fails but address changed
                    }
                } else {
                    Log::warning("Profile Update: Google Maps API request failed for address: {$newAddress} for user {$user->id}", [
                        'status' => $response->status(),
                        'body' => $response->body(),
                    ]);
                     // Keep old coordinates if API fails
                }
            } catch (\Exception $e) {
                // Log::error("Profile Update: Geocoding exception for address: {$newAddress} for user {$user->id}", ['error' => $e->getMessage()]);
                 // Keep old coordinates on exception
            }
        } elseif ($newAddress !== $user->address) {
            //  Log::warning("Profile Update: Address changed for user {$user->id} but geocoding skipped (API key missing or address empty?).", [
            //     'address' => $newAddress,
            //     'api_key' => $googleMapsApiKey ? 'present' : 'missing',
            // ]);
             // Address changed but couldn't geocode, maybe nullify coords or keep old ones?
             // Let's keep the old ones for now to avoid losing potentially valid previous coords.
        }
        
        // Update user profile with validated data and potentially new coordinates
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];
        $user->address = $newAddress; // Use the validated new address
        $user->latitude = $latitude;   // Use the (potentially updated) latitude
        $user->longitude = $longitude; // Use the (potentially updated) longitude
        
        // Personal Information
        $user->date_of_birth = $validated['date_of_birth'] ?? null;
        $user->gender = $validated['gender'] ?? null;
        $user->blood_group = $validated['blood_group'] ?? null;
        $user->occupation = $validated['occupation'] ?? null;
        
        // Contact Information
        $user->emergency_contact = $validated['emergency_contact'] ?? null;
        
        // Medical Information
        $user->allergies = $validated['allergies'] ?? null;
        $user->current_medications = $validated['current_medications'] ?? null;
        $user->medical_conditions = $validated['medical_conditions'] ?? null;
        
        // Medical Preferences (convert to boolean)
        $user->willing_to_donate_blood = isset($validated['willing_to_donate_blood']) ? (bool)$validated['willing_to_donate_blood'] : false;
        $user->emergency_contact_consent = isset($validated['emergency_contact_consent']) ? (bool)$validated['emergency_contact_consent'] : false;
        $user->health_reminders = isset($validated['health_reminders']) ? (bool)$validated['health_reminders'] : false;
        
        // Privacy Settings (convert to boolean)
        $user->marketing_consent = isset($validated['marketing_consent']) ? (bool)$validated['marketing_consent'] : false;
        $user->data_sharing_consent = isset($validated['data_sharing_consent']) ? (bool)$validated['data_sharing_consent'] : false;
        $user->location_tracking = isset($validated['location_tracking']) ? (bool)$validated['location_tracking'] : false;
        
        // Communication Preference
        $user->communication_preference = $validated['communication_preference'] ?? 'email';
        
        // Update password if provided
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }
        
        // Check if email was changed and reset verification if necessary
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
        
        $user->save();
        
        return back()->with('success', 'Profile updated successfully!');
    }

    /**
     * Update the user's location.
     */
    public function updateLocation(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $validated = $request->validate([
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
            'address' => ['required', 'string'],
        ]);
        
        // Update user location
        $user->latitude = $validated['latitude'];
        $user->longitude = $validated['longitude'];
        $user->address = $validated['address'];
        $user->save();
        
        return response()->json(['success' => true]);
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
