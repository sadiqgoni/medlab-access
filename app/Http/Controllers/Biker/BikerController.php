<?php

namespace App\Http\Controllers\Biker;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Add Log facade

class BikerController extends Controller
{
    /**
     * Display the route map for a delivery order.
     *
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\View\View
     */
    public function mapRoute(Order $order)
    {
        // Eager load relationships
        $order->load(['consumer', 'facility']);

        // Check if order belongs to the authenticated biker
        if ($order->biker_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Determine actual pickup and delivery coordinates based on order type
        $pickupLat = null;
        $pickupLng = null;
        $deliveryLat = null;
        $deliveryLng = null;

        if ($order->order_type === 'test') {
            // Pickup from Consumer, Deliver to Facility
            $pickupLat = $order->consumer_latitude; // Assuming these fields exist on Order
            $pickupLng = $order->consumer_longitude;
            $deliveryLat = $order->facility->latitude ?? null; // Assuming Facility model has lat/lng
            $deliveryLng = $order->facility->longitude ?? null;
        } elseif ($order->order_type === 'blood') {
            // Pickup from Facility, Deliver to Consumer
            $pickupLat = $order->facility->latitude ?? null;
            $pickupLng = $order->facility->longitude ?? null;
            $deliveryLat = $order->consumer_latitude;
            $deliveryLng = $order->consumer_longitude;
        }

        // Fallback or error handling if coordinates are missing
        if (is_null($pickupLat) || is_null($pickupLng) || is_null($deliveryLat) || is_null($deliveryLng)) {
            Log::error("Missing coordinates for Order ID: {$order->id}. Pickup: ($pickupLat, $pickupLng), Delivery: ($deliveryLat, $deliveryLng)");
            // Provide default coordinates or show an error message
            // Using Lagos defaults as a fallback for demonstration
            $defaultCoords = config('mapbox.defaults.center', ['lat' => 6.5244, 'lng' => 3.3792]);
            $pickupLat = $pickupLat ?? $defaultCoords['lat'];
            $pickupLng = $pickupLng ?? $defaultCoords['lng'];
            $deliveryLat = $deliveryLat ?? $defaultCoords['lat'];
            $deliveryLng = $deliveryLng ?? $defaultCoords['lng'];
            // Optionally add a flash message to inform the user about fallback coordinates
            // session()->flash('warning', 'Could not determine exact coordinates, using default location.');
        }

        $pickupCoordinates = ['lat' => $pickupLat, 'lng' => $pickupLng];
        $deliveryCoordinates = ['lat' => $deliveryLat, 'lng' => $deliveryLng];

        // Get Google Maps API key from config (assuming it's stored under 'mapbox.api_key')
        $googleMapsApiKey = config('mapbox.api_key'); // Check config/mapbox.php or config/services.php

        return view('biker.map-route', compact('order', 'pickupCoordinates', 'deliveryCoordinates', 'googleMapsApiKey'));
    }

    /**
     * Helper method to get coordinates from address - REMOVED as we now use stored coordinates
     *
     * @param string $address
     * @return array
     */
    // private function getCoordinatesFromAddress($address) { ... } // Removed

    /**
     * Update the order status from the biker's perspective.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateOrderStatus(Request $request, Order $order)
    {
        // Check if order belongs to the authenticated biker
        if ($order->biker_id !== Auth::id()) {
            // Use Filament notification or standard session flash
             \Filament\Notifications\Notification::make()
                ->title('Unauthorized Action')
                ->danger()
                ->send();
            return redirect()->back();
            // abort(403, 'Unauthorized action.'); // Or use abort
        }

        // Validate request
        $validated = $request->validate([
            'status' => 'required|in:sample_collected,in_transit,delivered',
            // Removed timestamp validation - should be set server-side
        ]);

        // Update order status
        $order->status = $validated['status'];

        // Update timestamps based on status - Use Carbon::now() for accuracy
        if ($validated['status'] === 'sample_collected' && is_null($order->actual_pickup_time)) {
            $order->actual_pickup_time = now();
        }

        if ($validated['status'] === 'delivered' && is_null($order->actual_delivery_time)) {
            $order->actual_delivery_time = now();
            // Optionally update pickup time if status jumped directly to delivered
            if (is_null($order->actual_pickup_time)) {
                 $order->actual_pickup_time = now();
            }
        }

        $order->save();

        // Use Filament notification or standard session flash
        \Filament\Notifications\Notification::make()
            ->title('Order status updated successfully')
            ->success()
            ->send();

        // Redirect back to the order edit page or the map route page
        // return redirect()->route('filament.biker.resources.orders.edit', $order)->with('success', 'Order status updated successfully');
         return redirect()->back()->with('success', 'Order status updated successfully');
    }
}
