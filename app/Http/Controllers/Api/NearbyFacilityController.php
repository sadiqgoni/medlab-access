<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Facility;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

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
            'order_type' => ['required', 'string', 'in:test,blood'], // Filter by general type
            'radius' => ['nullable', 'numeric', 'min:1', 'max:100'], // Optional radius in km
            'limit' => ['nullable', 'integer', 'min:1', 'max:50'], // Optional limit
        ]);

        $userLat = $request->latitude;
        $userLon = $request->longitude;
        $orderType = $request->order_type;
        $radius = $request->input('radius', 50); // Default 50km radius
        $limit = $request->input('limit', 10); // Default limit 10 facilities

        // Haversine formula parts
        $earthRadius = 6371; // Earth radius in kilometers
        $distanceSelect = sprintf(
            "(%f * acos(cos(radians(%f)) * cos(radians(latitude)) * cos(radians(longitude) - radians(%f)) + sin(radians(%f)) * sin(radians(latitude))))",
            $earthRadius,
            $userLat,
            $userLon,
            $userLat
        );

        $facilities = Facility::select('id', 'name', 'address', 'latitude', 'longitude')
            ->selectRaw("{$distanceSelect} AS distance")
            ->where('status', 'approved') // Only show approved facilities
            ->whereHas('services', function ($query) use ($orderType) {
                // Check if the facility has at least one service matching the order type
                $query->where('type', $orderType)->where('is_active', true);
            })
            ->having('distance', '<', $radius)
            ->orderBy('distance', 'asc')
            ->limit($limit)
            ->get();

        return response()->json($facilities);
    }
}
