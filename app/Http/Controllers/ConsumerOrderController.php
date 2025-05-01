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
use App\Models\Service;

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
            $selectedServiceIds = $validated['services'];
            $services = Service::whereIn('id', $selectedServiceIds)->get();
            
        // Determine order type from the first service (assuming no mixing)
        $orderType = $services->first()->type === 'test' ? 'test' : 'blood'; // Simplified logic
            $isBloodRequest = $services->contains('type', 'blood_request');
            $isDonation = $services->contains('type', 'blood_donation');
           
            // Basic Order Data
            $orderData = [
                'consumer_id' => Auth::id(),
                'facility_id' => $validated['facility_id'],
                'order_type' => $orderType,
                'delivery_address' => $validated['delivery_address'],
                'scheduled_time' => $validated['scheduled_time'] ?? null,
                'status' => 'pending', // Initial status
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'pending', // Default payment status
                'total_amount' => 0, // Initialize total amount
                'details' => [], // Initialize details array
            ];

            // Placeholder Costs & Calculation
            $baseDeliveryFee = 500;
            $totalServiceCost = $services->sum('price');
        $requiresDelivery = $services->contains(fn ($service) => $service->type === 'test' || $service->type === 'blood_request');
            $deliveryFee = $requiresDelivery ? $baseDeliveryFee : 0;
            $orderData['total_amount'] = $totalServiceCost + $deliveryFee;

            // Add order details
            $orderData['details']['service_ids'] = $selectedServiceIds;
            if ($orderType === 'test') {
                $orderData['details']['notes'] = $validated['test_notes'] ?? null;
            } elseif ($orderType === 'blood') {
             $orderData['details']['blood_group'] = $validated['blood_group'];
                 if ($isBloodRequest) {
                $orderData['details']['units'] = $validated['blood_units'];
                $orderData['details']['urgency'] = $validated['urgency'];
                $orderData['details']['purpose'] = $validated['blood_purpose'];
                 } elseif ($isDonation) {
                     $orderData['details']['service_type'] = 'donation'; // Explicitly mark donation
                 }
            }

            // Simulate Payment
            if ($orderData['payment_method'] === 'paystack') {
                 if ($orderData['total_amount'] > 0) {
                    $orderData['payment_status'] = 'paid';
                    $orderData['status'] = 'accepted'; // Move status forward if paid
                    $orderData['payment_gateway_ref'] = 'FAKE_PAYSTACK_'.Str::random(10);
                 } else { 
                     $orderData['payment_status'] = 'paid'; 
                     $orderData['status'] = 'accepted';
                 }
            } else { // Cash payment
                 $orderData['payment_status'] = 'pending';
                 $orderData['status'] = 'pending';
            }
            
            $order = Order::create($orderData);

            // Handle Payment Redirection or Completion
            if ($orderData['payment_method'] === 'paystack' && $orderData['total_amount'] > 0) {
                // Redirect to simulated payment page
                return redirect()->route('consumer.orders.payment.simulate', $order);
            } else {
                 // For Cash or Free orders, go directly to show page
                return redirect()->route('consumer.orders.show', $order)->with('success', 'Order placed successfully!');
        }
    }

    /**
     * Show the payment simulation page.
     */
    public function showPaymentSimulation(Order $order): View
    {
         // Ensure the authenticated user owns this order and it needs payment
        // if ($order->consumer_id !== Auth::id() || $order->payment_status !== 'pending' || $order->payment_method !== 'paystack') {
        //     abort(403);
        // }
        return view('consumer.orders.payment-simulation', compact('order'));
    }

    /**
     * Confirm the simulated payment.
     */
    public function confirmPayment(Request $request, Order $order): RedirectResponse
    {
         // Ensure the authenticated user owns this order and it needs payment
        // if ($order->consumer_id !== Auth::id() || $order->payment_status !== 'pending' || $order->payment_method !== 'paystack') {
        //     abort(403);
        // }

        // Mark as paid
        $order->payment_status = 'paid';
        $order->status = 'accepted'; // Move status forward
        $order->payment_gateway_ref = 'SIMULATED_PAY_'.Str::random(8);
        $order->save();

        // TODO: Trigger payment confirmation notification

        return redirect()->route('consumer.orders.show', $order)->with('success', 'Payment Confirmed! Order is being processed.');
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

    /**
     * Cancel the specified order.
     */
    public function cancel(Order $order): RedirectResponse
    {
        // Ensure the authenticated user owns this order
        if ($order->consumer_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Define cancellable statuses
        $cancellableStatuses = ['pending', 'accepted'];

        if (!in_array($order->status, $cancellableStatuses)) {
            return redirect()->route('consumer.orders.show', $order)->with('error', 'Order cannot be cancelled at its current stage.');
        }

        // Update the order status
        $order->status = 'cancelled';
        // Optionally update payment status if applicable (e.g., trigger refund if paid)
        // if ($order->payment_status === 'paid') {
        //     $order->payment_status = 'refund_pending'; // Or trigger refund logic
        // }
        $order->save();

        // TODO: Optionally notify facility/biker about cancellation

        return redirect()->route('consumer.orders.show', $order)->with('success', 'Order cancelled successfully.');
    }
}
