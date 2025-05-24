<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Facility;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProviderRegistrationController extends Controller
{
    /**
     * Display the provider registration view.
     */
    public function create(): View
    {
        return view('auth.provider-register');
    }

    /**
     * Handle an incoming provider registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'max:20', 'unique:'.User::class],
            'government_id' => ['required', 'string', 'max:50', 'unique:'.User::class],
            'communication_preference' => ['required', 'string', Rule::in(['email', 'sms', 'app'])],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            
            // Facility fields
            'facility_name' => ['required', 'string', 'max:255'],
            'facility_address' => ['required', 'string', 'max:1000'],
            'facility_latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'facility_longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'facility_type' => ['required', 'string', Rule::in(['Lab', 'Hospital', 'Clinic', 'Blood Bank', 'Other'])],
            'services_description' => ['required', 'string', 'max:2000'],
            'facility_license' => ['required', 'string', 'max:100'],
        ]);

        // Geocode facility address if coordinates not provided
        $facilityCoords = $this->ensureCoordinates($validated['facility_address'], $validated['facility_latitude'] ?? null, $validated['facility_longitude'] ?? null);

        try {
            DB::beginTransaction();

            // Create Provider User FIRST
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'address' => $validated['facility_address'], 
                'latitude' => $facilityCoords['latitude'],
                'longitude' => $facilityCoords['longitude'],
                'government_id' => $validated['government_id'],
                'communication_preference' => $validated['communication_preference'],
                'password' => Hash::make($validated['password']),
                'role' => 'provider',
                'status' => 'pending',
                'is_facility_admin' => true,
            ]);

            // THEN create Facility with user_id already set
            $facility = Facility::create([
                'name' => $validated['facility_name'],
                'address' => $validated['facility_address'],
                'latitude' => $facilityCoords['latitude'],
                'longitude' => $facilityCoords['longitude'],
                'type' => $validated['facility_type'],
                'contact_person' => $validated['name'],
                'services_description' => $validated['services_description'],
                'license_number' => $validated['facility_license'],
                'status' => 'pending',
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'user_id' => $user->id, // Set the user_id directly now that we have it
            ]);

            // Update user with facility_id
            $user->facility_id = $facility->id;
            $user->save();

            DB::commit();

            event(new Registered($user));

            // Store registration success in session for confirmation page
            session()->flash('provider_registered', true);
            session()->flash('provider_name', $validated['name']);
            session()->flash('facility_name', $validated['facility_name']);

            return redirect()->route('provider.registration.confirmation');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Provider registration failed: " . $e->getMessage(), ['exception' => $e]);
            return back()->withInput()->withErrors(['error' => 'Registration failed. Please try again later.']);
        }
    }

    /**
     * Display the registration confirmation page.
     */
    public function confirmation(): View
    {
        // If user didn't just register, redirect to registration page
        // if (!session('provider_registered')) {
        //     return redirect()->route('provider.register');
        // }
        
        return view('auth.provider-confirmation', [
            'name' => session('provider_name'),
            'facility_name' => session('facility_name')
        ]);
    }

    /**
     * Ensure we have coordinates for an address.
     * If coordinates are not provided, attempt to geocode the address.
     */
    private function ensureCoordinates(string $address, ?float $latitude, ?float $longitude): array
    {
        if ($latitude && $longitude) {
            return [
                'latitude' => $latitude,
                'longitude' => $longitude,
            ];
        }

        // Attempt to geocode
        $apiKey = env('GOOGLE_MAPS_API_KEY');
        if (!$apiKey) {
            Log::warning("Google Maps API key not found, cannot geocode address");
            return [
                'latitude' => 0,
                'longitude' => 0,
            ];
        }

        try {
            $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
                'address' => $address,
                'key' => $apiKey,
                'components' => 'country:NG', // Bias towards Nigeria
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if ($data['status'] === 'OK' && !empty($data['results'])) {
                    $location = $data['results'][0]['geometry']['location'];
                    return [
                        'latitude' => $location['lat'],
                        'longitude' => $location['lng'],
                    ];
                }
            }
        } catch (\Exception $e) {
            Log::error("Geocoding exception for address: {$address}", ['error' => $e->getMessage()]);
        }

        // Return zeros if geocoding fails
        return [
            'latitude' => 0,
            'longitude' => 0,
        ];
    }
}
