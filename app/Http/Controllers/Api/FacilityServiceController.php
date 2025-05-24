<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Facility;
use App\Models\Service;
use Illuminate\Http\JsonResponse;

class FacilityServiceController extends Controller
{
    /**
     * Get all services for a specific facility with detailed information
     * 
     * @param int $facilityId
     * @return JsonResponse
     */
    public function index($facilityId): JsonResponse
    {
        $facility = Facility::where('id', $facilityId)
            ->where('status', 'approved')
            ->first();
            
        if (!$facility) {
            return response()->json(['error' => 'Facility not found or not approved'], 404);
        }
        
        $services = Service::where('facility_id', $facilityId)
            ->where('status', 'approved')
            ->get()
            ->map(function($service) {
                // Map service to include any type indicators and enrich the response
                return [
                    'id' => $service->id,
                    'name' => $service->name,
                    'category' => $service->category,
                    // Determine the type based on category
                    'type' => $service->category === 'eMedSample' ? 'test' : 'blood',
                    'price' => $service->price,
                    'description' => $service->description ?? null,
                    'turnaround_time' => $service->turnaround_time,
                    'requirements' => $service->requirements,
                    'notes' => $service->notes,
                    'availability_status' => $service->availability_status,
                    'is_active' => true,
                    // Include service attributes (if any)
                    'attributes' => $service->attributes ?? []
                ];
            });
            
        return response()->json($services);
    }
}
