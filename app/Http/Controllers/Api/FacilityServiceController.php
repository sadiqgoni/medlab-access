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
     * Display a listing of active services for a specific facility.
     */
    public function index(Facility $facility): JsonResponse
    {
        // Eager load is not strictly necessary for this simple case,
        // but good practice if more facility data were needed.
        // $facility->load(['services' => fn ($query) => $query->where('is_active', true)]);
        
        $services = $facility->services()
                              ->where('is_active', true)
                              ->orderBy('name')
                              ->get(['id', 'name', 'description', 'price', 'type']); // Select only needed columns

        return response()->json($services);
    }
}
