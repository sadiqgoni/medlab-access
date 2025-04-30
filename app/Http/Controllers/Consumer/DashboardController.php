<?php

namespace App\Http\Controllers\Consumer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get order statistics
        $totalOrders = Order::where('user_id', $user->id)->count();
        $activeOrders = Order::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'accepted', 'processing', 'sample_collected', 'in_transit'])
            ->count();
        $completedOrders = Order::where('user_id', $user->id)
            ->where('status', 'completed')
            ->count();
        $resultsReadyOrders = Order::where('user_id', $user->id)
            ->where('status', 'results_ready')
            ->count();
            
        // Get recent orders
        $recentOrders = Order::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            // fetch this from your database
        $appointments = collect();
        
        return view('consumer.dashboard', compact(
            'totalOrders',
            'activeOrders',
            'completedOrders',
            'resultsReadyOrders',
            'recentOrders',
            'appointments'
        ));
    }
} 