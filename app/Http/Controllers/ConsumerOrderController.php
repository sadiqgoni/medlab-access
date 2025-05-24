<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Service;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ConsumerOrderController extends Controller
{
    /**
     * Display a listing of the orders.
     */
    public function index()
    {
        $user = Auth::user();
        $orders = Order::where('consumer_id', $user->id)
            ->with(['service', 'facility'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('consumer.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new order.
     */
    public function create(Request $request)
    {
        $user = Auth::user();
        $selectedFacilityId = $request->input('facility_id');
        $selectedCategory = $request->input('category');
        
        // Get all approved facilities
        $facilities = Facility::where('status', 'approved')
            ->when($user->latitude && $user->longitude, function ($query) use ($user) {
                return $query->select('*')
                    ->selectRaw(
                        '(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance',
                        [$user->latitude, $user->longitude, $user->latitude]
                    )
                    ->orderBy('distance');
            })
            ->get();
            
        // Get the selected or first facility
        $selectedFacility = null;
        if ($selectedFacilityId) {
            $selectedFacility = $facilities->firstWhere('id', $selectedFacilityId);
        } elseif ($facilities->count() > 0) {
            $selectedFacility = $facilities->first();
        }
        
        // Get services based on selected facility and category
        $services = collect();
        if ($selectedFacility) {
            $servicesQuery = Service::where('facility_id', $selectedFacility->id)
                ->where('is_available', true);
                
            if ($selectedCategory) {
                $servicesQuery->where('category', $selectedCategory);
            }
            
            $services = $servicesQuery->get();
        }
        
        // Categories for select menu
        $categories = [
            'eMedSample' => 'Laboratory Tests',
            'SharedBlood' => 'Blood Products'
        ];
        
        return view('consumer.orders.create', compact(
            'user',
            'facilities',
            'selectedFacility',
            'services',
            'categories',
            'selectedCategory'
        ));
    }

    /**
     * Store a newly created order in storage.
     */
        // ...existing code...

    /**
     * Store a newly created order in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'order_type' => 'required|string|in:test,blood',
            'facility_id' => 'required|exists:facilities,id',
            'services' => 'required|array|min:1',
            'services.*' => 'exists:services,id',
            'delivery_address' => 'required|string|max:1000', // This is the CUSTOMER's address
            'scheduled_time' => 'nullable|date|after_or_equal:now',
            'payment_method' => 'required|string|in:card,bank,cash',
            'test_notes' => 'nullable|string|max:2000',
            'details' => 'nullable|array',
        ]);

        $user = Auth::user();
        $facility = Facility::findOrFail($validated['facility_id']); // Fetch the selected facility
        $services = Service::findMany($validated['services']);

        // Calculate total price
        $totalAmount = $services->sum('price');

        // Add delivery fee
        $deliveryFee = 500; // Base delivery fee
        $totalAmount += $deliveryFee;

        // Create the order with common fields
        $order = Order::create([
            'consumer_id' => $user->id,
            'facility_id' => $validated['facility_id'],
            'order_type' => $validated['order_type'],
            'status' => 'pending', 
            'pickup_address' => $facility->address, 
            'delivery_address' => $validated['delivery_address'], 
            'details' => [
                'service_ids' => $validated['services'],
                'service_details' => $request->input('details', []),
                'test_notes' => $validated['test_notes'] ?? null,
            ],
            'payment_status' => 'pending', 
            'payment_method' => $validated['payment_method'],
            'total_amount' => $totalAmount,
            'payment_gateway_ref' => 'TR-'.Str::random(10),
        ]);

        // For scheduled orders
        if (!empty($validated['scheduled_time'])) {
            $order->update([
                'pickup_scheduled_time' => $validated['scheduled_time'],
                // Estimate delivery time to be 2 hours after pickup
                'delivery_scheduled_time' => date('Y-m-d H:i:s', strtotime($validated['scheduled_time'] . ' +2 hours')),
            ]);
        }

        // If payment method is not cash, go to payment simulation
        if ($validated['payment_method'] !== 'cash') {
            // Corrected: Redirect to payment simulation for card/bank
            return redirect()->route('consumer.orders.confirmation', $order)->with('success', 'Order placed successfully.');
        }

        // For cash payments, go straight to confirmation
        return redirect()->route('consumer.orders.confirmation', $order)->with('success', 'Order placed successfully. You will pay cash on delivery.');
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        // Ensure the user can only see their own orders
        if ($order->consumer_id !== Auth::id()) {
            abort(403);
        }
        
        $order->load(['facility', 'service', 'biker']);
        
        return view('consumer.orders.show', compact('order'));
    }
    
   
    
    /**
     * Process the payment and mark as paid.
     */
    public function confirmPayment(Request $request, Order $order)
    {
        // Ensure the user can only pay for their own orders
        if ($order->consumer_id !== Auth::id()) {
            abort(403);
        }
        
        // In a real system, we'd validate payment with Paystack here
        // For now, we'll just mark it as paid
        
        $order->update([
            'payment_status' => 'paid',
            'payment_details' => [
                'amount' => $order->total_amount, 
                'currency' => 'NGN',
                'method' => $order->payment_method,
                'time' => now()->toIso8601String(),
            ],
        ]);
        
        return redirect()->route('consumer.orders.confirmation', $order);
    }
    
    /**
     * Show the order confirmation page.
     */
    public function confirmation(Order $order)
    {
        // Ensure the user can only see their own orders
        if ($order->consumer_id !== Auth::id()) {
            abort(403);
        }
        
        $order->load(['facility', 'service']);
        
        return view('consumer.orders.confirmation', compact('order'));
    }
    
    /**
     * Cancel an order.
     */
    public function cancel(Order $order)
    {
        // Ensure the user can only cancel their own orders
        if ($order->consumer_id !== Auth::id()) {
            abort(403);
        }
        
        // Only allow cancellation of pending orders
        if ($order->status !== 'pending') {
            return back()->with('error', 'This order cannot be canceled.');
        }
        
        $order->update(['status' => 'cancelled']);
        
        return redirect()->route('consumer.orders.index')->with('success', 'Order cancelled successfully.');
    }
}
