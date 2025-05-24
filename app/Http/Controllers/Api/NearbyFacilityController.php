<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Facility;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log; 
use Illuminate\Validation\Rule; 

class NearbyFacilityController extends Controller
{
    /**
     * Fetch nearby facilities based on user location and service type.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'order_type' => ['required', 'string', Rule::in(['test', 'blood'])],
            'radius' => ['nullable', 'numeric', 'min:1', 'max:50'], 
            'limit' => ['nullable', 'integer', 'min:1', 'max:50'], 
        ]);

        $userLat = $request->latitude;
        $userLon = $request->longitude;
        $orderType = $request->order_type;
        $radius = $request->input('radius', 20); 
        $limit = $request->input('limit', 10); 

        // Log the received user coordinates
        // Log::info("NearbyFacilityController: Received User Lat: {$userLat}, User Lon: {$userLon}, Radius: {$radius}");

        // Map the order_type to the corresponding service category
        $serviceCategory = $orderType === 'test' ? 'eMedSample' : 'SharedBlood';

        // Haversine formula parts
        $earthRadius = 6371; // Earth radius in kilometers
        $distanceSelect = sprintf(
            "(%f * acos(cos(radians(%f)) * cos(radians(latitude)) * cos(radians(longitude) - radians(%f)) + sin(radians(%f)) * sin(radians(latitude))))",
            $earthRadius,
            $userLat,
            $userLon,
            $userLat
        );

        $facilitiesQuery = Facility::select('id', 'name', 'address', 'latitude', 'longitude')
            ->selectRaw("{$distanceSelect} AS distance")
            ->where('status', 'approved') // Only show approved facilities
            ->whereHas('services', function ($query) use ($serviceCategory) {
                // Check if the facility has at least one service matching the category
                $query->where('category', $serviceCategory)
                      ->where('status', 'approved'); // Only include approved services
            });

        // Log facility coordinates *before* filtering by distance
        // Clone the query before chunking to avoid modifying the original query object used later
        $facilitiesQuery->clone()->chunk(100, function ($facilitiesChunk) use ($userLat, $userLon) {
            foreach ($facilitiesChunk as $facility) {
                // Log raw calculated distance from the DB
                // Log::info("NearbyFacilityController: Checking Facility ID: {$facility->id} ({$facility->name}), Fac Lat: {$facility->latitude}, Fac Lon: {$facility->longitude}, Raw DB Distance: {$facility->distance}");
            }
        });

        $facilities = $facilitiesQuery // Use the original query object here
            ->having('distance', '<', $radius)
            ->orderBy('distance', 'asc')
            ->limit($limit)
            ->get();

        // Log the final filtered results
        // Log::info("NearbyFacilityController: Found Facilities within radius:", $facilities->map(function($f) {
        //     return ['id' => $f->id, 'name' => $f->name, 'distance' => $f->distance];
        // })->toArray());

        return response()->json($facilities);
    }
}
