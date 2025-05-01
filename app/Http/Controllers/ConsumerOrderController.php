<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Facility;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Consumer\StoreOrderRequest; // Use the updated request
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Arr; // Import Arr facade

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
        $services = Service::findMany($selectedServiceIds);

        // Calculate costs
        $baseDeliveryFee = 500; // Define base fee
        $totalServiceCost = $services->sum('price');
        // Delivery is required if any service has a price > 0 or is a test/blood request
        $requiresDelivery = $services->contains(fn ($service) => $service->price > 0 || in_array($service->type, ['test', 'blood']));
        $deliveryFee = $requiresDelivery ? $baseDeliveryFee : 0;
        $totalAmount = $totalServiceCost + $deliveryFee;

        // Prepare base order data
        $orderData = [
            'consumer_id' => Auth::id(),
            'facility_id' => $validated['facility_id'],
            'order_type' => $validated['order_type'], // Get type directly from validated request
            'delivery_address' => $validated['delivery_address'],
            'scheduled_time' => $validated['scheduled_time'] ?? null,
            'payment_method' => $validated['payment_method'],
            'total_amount' => $totalAmount,
            // Merge validated 'details' array and 'test_notes'
            'details' => array_merge(
                Arr::get($validated, 'details', []), // Get validated dynamic attributes
                ['service_ids' => $selectedServiceIds], // Keep track of selected service IDs
                // Add test_notes if order type is 'test' and notes are provided
                ($validated['order_type'] === 'test' && !empty($validated['test_notes'])) ? ['test_notes' => $validated['test_notes']] : [] 
            ),
        ];

        // Set initial status based on payment method
        switch ($validated['payment_method']) {
            case 'card':
                // Simulate successful card payment for now
                $orderData['payment_status'] = 'paid';
                $orderData['status'] = 'accepted'; // Move directly to accepted if paid
                $orderData['payment_gateway_ref'] = 'SIM_CARD_' . Str::random(10);
                break;
            case 'bank':
                $orderData['payment_status'] = 'pending'; // Requires manual confirmation
                $orderData['status'] = 'pending_payment'; // Specific status for bank transfer
                $orderData['payment_gateway_ref'] = 'SIM_BANK_' . Str::random(10); // Simulate a reference
                break;
            case 'cash':
            default:
                $orderData['payment_status'] = 'pending'; // To be paid on delivery
                $orderData['status'] = 'pending'; // Standard pending status
                break;
        }

        // Create the order
        $order = Order::create($orderData);

        // Attach services to the order using the pivot table (if you created an Order-Service relationship)
        // $order->services()->attach($selectedServiceIds); // Uncomment if you have this relationship

        // Redirect to confirmation page
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