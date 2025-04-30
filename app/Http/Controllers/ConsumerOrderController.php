<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ConsumerOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // TODO: Implement order history view for consumer
        $orders = Order::where('user_id', Auth::id())
                       ->orderBy('created_at', 'desc')
                       ->paginate(10); // Paginate results

        return view('consumer.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Fetch only approved facilities for selection
        $facilities = Facility::where('status', 'approved')->orderBy('name')->get();
        
        return view('consumer.orders.create', compact('facilities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_type' => ['required', Rule::in(['test', 'blood'])],
            'facility_id' => ['required', 'exists:facilities,id'],
            'details' => ['required', 'string', 'max:5000'], // Specific tests, blood group info
            'delivery_address' => ['nullable', 'string', 'max:1000'], // Use user default if null
            'pickup_scheduled_time' => ['nullable', 'date'],
            'total_amount' => ['required', 'numeric', 'min:0'], // From placeholder
            'payment_method' => ['required', 'string'], // From placeholder
        ]);

        // Create the order
        $order = Order::create([
            'user_id' => Auth::id(),
            'facility_id' => $validated['facility_id'],
            'order_type' => $validated['order_type'],
            'details' => json_decode($validated['details']) ?? ['info' => $validated['details'] ], // Basic JSON structure
            'status' => 'pending', // Initial status
            'pickup_address' => null, // Logic needed: For tests, pickup is often user's address. For blood, could be facility.
            'delivery_address' => $validated['delivery_address'] ?? Auth::user()->address, // Use provided or user's default
            'pickup_scheduled_time' => $validated['pickup_scheduled_time'] ?? null,
            'delivery_scheduled_time' => null, // To be determined later
            'payment_status' => 'pending', // Default until payment integration
            'payment_method' => $validated['payment_method'],
            'total_amount' => $validated['total_amount'],
        ]);

        // TODO: Implement matching logic (if needed, e.g., finding nearest facility if not selected)
        // TODO: Trigger fake notification
        
        // Redirect to order details page (or order history)
        // return redirect()->route('consumer.orders.show', $order)->with('success', 'Order placed successfully!');
        // For now, redirect back to consumer dashboard
        return redirect()->route('consumer.dashboard')->with('success', 'Order placed successfully! (Payment & Notifications Pending)');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        // Ensure the consumer can only view their own orders
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }
        // TODO: Implement order details view
        return view('consumer.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        // Consumers generally shouldn't edit orders after placement, maybe only cancel?
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        // Consumers generally shouldn't edit orders after placement, maybe only cancel?
         abort(404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        // Maybe allow cancellation if status is 'pending'?
         abort(404);
    }
}
