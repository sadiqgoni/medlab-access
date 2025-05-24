<?php

namespace App\Http\Controllers\Consumer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Service;
use App\Models\Facility;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Default values if Order model is not set up yet
        $totalOrders = 0;
        $activeOrders = 0;
        $completedOrders = 0;
        $resultsReadyOrders = 0;
        $recentOrders = collect([]);
        $appointments = collect([]);
        
        // Get nearby facilities for quick access
        $nearbyFacilities = Facility::query()
            ->where('status', 'approved')
            ->when($user->latitude && $user->longitude, function ($query) use ($user) {
                return $query->select('*')
                    ->selectRaw(
                        '(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance',
                        [$user->latitude, $user->longitude, $user->latitude]
                    )
                    ->orderBy('distance');
            })
            ->limit(5)
            ->get();
        
        // If the Order model and table exist, get order statistics
        if (class_exists('App\Models\Order')) {
            try {
                $totalOrders = Order::where('consumer_id', $user->id)->count();
                $activeOrders = Order::where('consumer_id', $user->id)
                    ->whereIn('status', ['pending', 'accepted', 'processing', 'sample_collected', 'in_transit'])
                    ->count();
                $completedOrders = Order::where('consumer_id', $user->id)
                    ->where('status', 'completed')
                    ->count();
                $resultsReadyOrders = Order::where('consumer_id', $user->id)
                    ->where('status', 'results_ready')
                    ->count();
                
                $recentOrders = Order::where('consumer_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->limit(5)
                    ->get();
            } catch (\Exception $e) {
                // Log the exception but continue
                \Log::error("Error getting order data: " . $e->getMessage());
            }
        }
        
        return view('consumer.dashboard', compact(
            'totalOrders',
            'activeOrders',
            'completedOrders',
            'resultsReadyOrders',
            'recentOrders',
            'appointments',
            'nearbyFacilities',
            'user'
        ));
    }
}