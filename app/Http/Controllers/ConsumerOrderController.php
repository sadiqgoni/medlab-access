<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Facility;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Consumer\StoreOrderRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class ConsumerOrderController extends Controller
{
    /**
     * Display a listing of the consumer's orders.
     */
    public function index(): View
    {
        $orders = Order::where('consumer_id', Auth::id())
                       ->orderBy('created_at', 'desc')
                       ->paginate(10);
                       
        return view('consumer.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new order.
     */
    public function create(): View
    {
        $facilities = Facility::orderBy('name')->get();
        return view('consumer.orders.create', compact('facilities'));
    }

    /**
     * Store a newly created order in storage.
     */
    public function store(StoreOrderRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $selectedServiceIds = $validated['services'];
        $services = Service::whereIn('id', $selectedServiceIds)->get();

        // Determine order type from the first service (assuming no mixing)
        $orderType = $services->first()->type === 'test' ? 'test' : 'blood';
        $isBloodRequest = $services->contains('type', 'blood_request');
        $isDonation = $services->contains('type', 'blood_donation');

        // Calculate costs
        $baseDeliveryFee = 500;
        $totalServiceCost = $services->sum('price');
        $requiresDelivery = $services->contains(fn ($service) => $service->type === 'test' || $service->type === 'blood_request');
        $deliveryFee = $requiresDelivery ? $baseDeliveryFee : 0;
        $totalAmount = $totalServiceCost + $deliveryFee;

        // Prepare order data
        $orderData = [
            'consumer_id' => Auth::id(),
            'facility_id' => $validated['facility_id'],
            'order_type' => $orderType,
            'delivery_address' => $validated['delivery_address'],
            'scheduled_time' => $validated['scheduled_time'] ?? null,
            'status' => 'pending',
            'payment_method' => $validated['payment_method'],
            'payment_status' => 'pending',
            'total_amount' => $totalAmount,
            'details' => [
                'service_ids' => $selectedServiceIds,
            ],
        ];
        // dd( $validated['payment_method']);

        // Add service-specific details
        // if ($orderType === 'test') {
        //     $orderData['details']['notes'] = $validated['test_notes'] ?? null;
        // } elseif ($orderType === 'blood') {
        //     $orderData['details']['blood_group'] = $validated['blood_group'] ?? null;
        //     if ($isBloodRequest) {
        //         $orderData['details']['units'] = $validated['blood_units'] ?? null;
        //         $orderData['details']['urgency'] = $validated['urgency'] ?? null;
        //         $orderData['details']['purpose'] = $validated['blood_purpose'] ?? null;
        //     } elseif ($isDonation) {
        //         $orderData['details']['service_type'] = 'donation';
        //     }
        // }

        // Handle payment method logic
        // if ($orderData['payment_method'] === 'paystack') {
        //     // For now, simulate successful card payment
        //     $orderData['payment_status'] = 'paid';
        //     $orderData['status'] = 'accepted';
        //     $orderData['payment_gateway_ref'] = 'PAYSTACK_' . Str::random(10); // Changed prefix for clarity
        // } else { // Assumes 'cash'
        //     // Cash on delivery
            $orderData['payment_status'] = 'pending';
            $orderData['status'] = 'pending';
       // }

        // Create the order
        $order = Order::create($orderData);

        // Always redirect to confirmation page after successful order creation
        return redirect()->route('consumer.orders.confirmation', ['order' => $order->id])->with('success', 'Order placed successfully!');
    }

    /**
     * Display the order confirmation page.
     */
    public function confirmation(Order $order): View
    {
        if ($order->consumer_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('consumer.orders.confirmation', compact('order'));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order): View
    {
        if ($order->consumer_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        return view('consumer.orders.show', compact('order'));
    }

    /**
     * Cancel the specified order.
     */
    public function cancel(Order $order): RedirectResponse
    {
        if ($order->consumer_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $cancellableStatuses = ['pending', 'accepted'];
        if (!in_array($order->status, $cancellableStatuses)) {
            return redirect()->route('consumer.orders.show', $order)->with('error', 'Order cannot be cancelled at its current stage.');
        }

        $order->status = 'cancelled';
        $order->save();

        return redirect()->route('consumer.orders.show', $order)->with('success', 'Order cancelled successfully.');
    }

    /**
     * Show the form for editing the specified order (not implemented).
     */
    public function edit(Order $order): View
    {
        abort(404, 'Order editing not supported.');
    }

    /**
     * Update the specified order in storage (not implemented).
     */
    public function update(Request $request, Order $order): RedirectResponse
    {
        abort(404, 'Order updating not supported.');
    }

    /**
     * Remove the specified order from storage (not implemented).
     */
    public function destroy(Order $order): RedirectResponse
    {
        abort(404, 'Order deletion not supported.');
    }
}