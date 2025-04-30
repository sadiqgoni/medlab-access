<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Consumer\StoreOrderRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class ConsumerOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $orders = Order::where('consumer_id', Auth::id())
                       ->orderBy('created_at', 'desc')
                       ->paginate(10); // Example pagination
                       
        return view('consumer.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        // Fetch available facilities (you might want to filter these later based on location/service)
        $facilities = Facility::orderBy('name')->get(); 
        
        return view('consumer.orders.create', compact('facilities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        
        // Basic Order Data
        $orderData = [
            'consumer_id' => Auth::id(),
            'facility_id' => $validated['facility_id'],
            'order_type' => $validated['order_type'],
            'delivery_address' => $validated['delivery_address'],
            'scheduled_time' => $validated['scheduled_time'] ?? null,
            'status' => 'pending', // Initial status
            'payment_method' => $validated['payment_method'],
            'payment_status' => 'pending', // Default payment status
            'total_amount' => 0, // Initialize total amount
            'details' => [], // Initialize details array
        ];

        // Placeholder Costs
        $baseDeliveryFee = 500;
        $testCost = 1500; // Cost per test
        $bloodRequestCost = 3000; // Base cost for blood request
        $bloodDonateCost = 0; // Donating is free

        // Add order-type specific details and calculate cost
        if ($validated['order_type'] === 'test') {
            $orderData['details']['tests'] = $validated['tests'];
            $orderData['details']['notes'] = $validated['test_notes'] ?? null;
            $orderData['total_amount'] = (count($validated['tests']) * $testCost) + $baseDeliveryFee;
        } elseif ($validated['order_type'] === 'blood') {
            $orderData['details']['service_type'] = $validated['blood_service'];
            $orderData['details']['blood_group'] = $validated['blood_group'];
            if ($validated['blood_service'] === 'request') {
                $orderData['details']['units'] = $validated['blood_units'];
                $orderData['details']['urgency'] = $validated['urgency'];
                $orderData['details']['purpose'] = $validated['blood_purpose'];
                $orderData['total_amount'] = $bloodRequestCost + $baseDeliveryFee; // Add per-unit cost later if needed
            } else { // Donating
                 $orderData['total_amount'] = $bloodDonateCost; // Free
            }
        }

        // Simulate Payment
        if ($orderData['payment_method'] === 'paystack') {
            // In real scenario: redirect to Paystack, handle callback.
            // For now: Simulate successful payment if amount > 0
             if ($orderData['total_amount'] > 0) {
                $orderData['payment_status'] = 'paid';
                $orderData['status'] = 'accepted'; // Move status forward if paid
                $orderData['payment_gateway_ref'] = 'FAKE_PAYSTACK_'.Str::random(10);
             } else {
                 // If it's free (like donation), mark as paid and accepted
                 $orderData['payment_status'] = 'paid'; 
                 $orderData['status'] = 'accepted';
             }
        } else { // Cash payment
             $orderData['payment_status'] = 'pending';
             $orderData['status'] = 'pending'; // Remains pending until cash confirmed
        }
        
        $order = Order::create($orderData);
        
        return redirect()->route('consumer.orders.show', $order)->with('success', 'Order placed successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order): View
    {
        // Ensure the authenticated user owns this order
        if ($order->consumer_id !== Auth::id()) {
            abort(403);
        }
        return view('consumer.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        // Consumers likely won't edit orders, maybe cancel?
        abort(404); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
         // Consumers likely won't edit orders, maybe cancel?
         abort(404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        // Consumers likely won't delete orders directly, maybe cancel?
        // Add cancellation logic if needed
        abort(404);
    }
}
