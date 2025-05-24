@extends('layouts.app')

@section('styles')
<style>
    #map {
        width: 100%;
        height: 500px;
        border-radius: 0.5rem;
    }
    .location-card {
        border-left: 4px solid;
        transition: all 0.3s ease;
    }
    .location-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }
    .location-card.pickup {
        border-color: #3B82F6;
    }
    .location-card.delivery {
        border-color: #10B981;
    }
    .marker {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
    }
    .marker-pickup {
        background-color: #3B82F6;
    }
    .marker-delivery {
        background-color: #10B981;
    }
    .status-timeline {
        position: relative;
    }
    .status-timeline:before {
        content: '';
        position: absolute;
        left: 15px;
        top: 0;
        height: 100%;
        width: 2px;
        background: #E5E7EB;
        z-index: 0;
    }
    .status-item {
        position: relative;
        z-index: 1;
    }
    .status-active {
        color: #3B82F6;
    }
</style>
@endsection

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">
                Delivery Route - Order #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
            </h1>
            <a href="{{ route('filament.biker.resources.orders.edit', $order) }}" class="px-4 py-2 bg-gray-100 rounded-md text-gray-700 hover:bg-gray-200 transition flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                Back to Order
            </a>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Map Column -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Map Card -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-5 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">
                            Navigation Map
                        </h2>
                    </div>
                    <div id="map"></div>
                    <div class="p-4 bg-blue-50 flex items-center gap-3 text-sm text-blue-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                        <span>Click markers for details. Use 'Navigate' buttons to open Google Maps.</span>
                    </div>
                </div>
                
                <!-- Location Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Pickup Location -->
                    <div class="location-card pickup bg-white overflow-hidden shadow-sm rounded-lg">
                        <div class="p-4">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center bg-blue-100 text-blue-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-900">Pickup Location</h3>
                                    <p class="text-sm text-gray-500">
                                        @if($order->order_type === 'test')
                                            {{ $order->consumer->name ?? 'Customer' }}
                                        @else {{-- Blood order --}}
                                            {{ $order->facility->name ?? 'Facility' }}
                                        @endif
                                    </p>                                </div>
                            </div>
                            <p class="text-gray-700 text-sm mb-4">
                                @if($order->order_type === 'test')
                                   {{ $order->delivery_address }} {{-- Customer address for test pickup --}}
                               @else {{-- Blood order --}}
                                   {{ $order->pickup_address }} {{-- Facility address for blood pickup --}}
                               @endif
                           </p>                            <div class="flex justify-between items-center">
                                <div class="text-xs text-gray-500">
                                    <span>Time: </span>
                                    <span class="font-medium">
                                        {{ $order->pickup_scheduled_time ? date('h:i A', strtotime($order->pickup_scheduled_time)) : 'Not scheduled' }}
                                    </span>
                                </div>
                                <button id="navigate-pickup" class="px-3 py-1.5 bg-blue-100 text-blue-700 rounded-md text-sm hover:bg-blue-200 transition">
                                    Navigate
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Delivery Location -->
                    <div class="location-card delivery bg-white overflow-hidden shadow-sm rounded-lg">
                        <div class="p-4">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center bg-green-100 text-green-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-900">Delivery Location</h3>
                                    <p class="text-sm text-gray-500">
                                        @if($order->order_type === 'test')
                                           {{ $order->facility->name ?? 'Facility' }}
                                       @else {{-- Blood order --}}
                                           {{ $order->consumer->name ?? 'Customer' }}
                                       @endif
                                   </p>
                                </div>
                            </div>
                            <p class="text-gray-700 text-sm mb-4">
                                @if($order->order_type === 'test')
                                    {{ $order->pickup_address }} {{-- Facility address for test delivery --}}
                                @else {{-- Blood order --}}
                                    {{ $order->delivery_address }} {{-- Customer address for blood delivery --}}
                                @endif
                            </p>
                            <div class="flex justify-between items-center">
                                <div class="text-xs text-gray-500">
                                    <span>Time: </span>
                                    <span class="font-medium">
                                        {{ $order->delivery_scheduled_time ? date('h:i A', strtotime($order->delivery_scheduled_time)) : 'Not scheduled' }}
                                    </span>
                                </div>
                                <button id="navigate-delivery" class="px-3 py-1.5 bg-green-100 text-green-700 rounded-md text-sm hover:bg-green-200 transition">
                                    Navigate
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Order Info Column -->
            <div class="space-y-6">
                <!-- Order Status Card -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-4 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">
                            Order Status
                        </h2>
                    </div>
                    <div class="p-4">
                        <div class="status-timeline py-2">
                            <div class="status-item pl-10 pb-6">
                                <div class="absolute left-3 w-6 h-6 rounded-full bg-{{ $order->status == 'accepted' ? 'blue-500' : 'gray-200' }} flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <h3 class="text-sm font-semibold {{ $order->status == 'accepted' ? 'text-blue-600' : 'text-gray-700' }}">
                                    Task Assigned
                                </h3>
                                <p class="text-xs text-gray-500">Waiting for pickup</p>
                            </div>
                            
                            <div class="status-item pl-10 pb-6">
                                <div class="absolute left-3 w-6 h-6 rounded-full bg-{{ in_array($order->status, ['sample_collected', 'in_transit', 'delivered']) ? 'blue-500' : 'gray-200' }} flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <h3 class="text-sm font-semibold {{ in_array($order->status, ['sample_collected', 'in_transit', 'delivered']) ? 'text-blue-600' : 'text-gray-700' }}">
                                    Sample Collected
                                </h3>
                                <p class="text-xs text-gray-500">
                                    @if($order->actual_pickup_time)
                                        {{ date('M j, Y - g:i A', strtotime($order->actual_pickup_time)) }}
                                    @else
                                        Not collected yet
                                    @endif
                                </p>
                            </div>
                            
                            <div class="status-item pl-10 pb-6">
                                <div class="absolute left-3 w-6 h-6 rounded-full bg-{{ in_array($order->status, ['in_transit', 'delivered']) ? 'blue-500' : 'gray-200' }} flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <h3 class="text-sm font-semibold {{ in_array($order->status, ['in_transit', 'delivered']) ? 'text-blue-600' : 'text-gray-700' }}">
                                    In Transit
                                </h3>
                                <p class="text-xs text-gray-500">Delivery in progress</p>
                            </div>
                            
                            <div class="status-item pl-10">
                                <div class="absolute left-3 w-6 h-6 rounded-full bg-{{ $order->status == 'delivered' ? 'green-500' : 'gray-200' }} flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <h3 class="text-sm font-semibold {{ $order->status == 'delivered' ? 'text-green-600' : 'text-gray-700' }}">
                                    Delivered
                                </h3>
                                <p class="text-xs text-gray-500">
                                    @if($order->actual_delivery_time)
                                        {{ date('M j, Y - g:i A', strtotime($order->actual_delivery_time)) }}
                                    @else
                                        Not delivered yet
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        <!-- Update Status Form -->
                        <div class="mt-4 border-t pt-4">
                            <h3 class="text-sm font-medium text-gray-700 mb-2">Update Status</h3>
                            <form action="{{ route('biker.update-order-status', $order) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <select name="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-md">
                                        <option value="sample_collected" {{ $order->status == 'sample_collected' ? 'selected' : '' }}>Sample Collected</option>
                                        <option value="in_transit" {{ $order->status == 'in_transit' ? 'selected' : '' }}>In Transit</option>
                                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                    </select>
                                </div>
                                
                                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                    Update Status
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Order Type Info Card -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-4">
                        @if($order->order_type === 'test')
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex flex-shrink-0 items-center justify-center text-blue-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M7 2a1 1 0 00-.707 1.707L7 4.414v3.758a1 1 0 01-.293.707l-4 4C.817 14.769 2.156 18 4.828 18h10.343c2.673 0 4.012-3.231 2.122-5.121l-4-4A1 1 0 0113 8.172V4.414l.707-.707A1 1 0 0013 2H7zm2 6.172V4h2v4.172a3 3 0 00.879 2.12l1.027 1.028a4 4 0 00-2.171.102l-.47.156a4 4 0 01-2.53 0l-.563-.187a1.993 1.993 0 00-.114-.035l1.063-1.063A3 3 0 009 8.172z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900">Laboratory Sample</h3>
                                    <p class="mt-1 text-sm text-gray-500">This is a lab test sample delivery. Handle with care and ensure proper temperature conditions.</p>
                                </div>
                            </div>
                        @else
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-full bg-red-100 flex flex-shrink-0 items-center justify-center text-red-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900">Blood Delivery</h3>
                                    <p class="mt-1 text-sm text-gray-500">This is a blood delivery. Critical! Maintain temperature and deliver promptly.</p>
                                </div>
                            </div>
                        @endif
                        
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-500">Order Time:</span>
                                <span class="text-sm text-gray-700">
                                    {{ $order->created_at->format('M j, Y - g:i A') }}
                                </span>
                            </div>
                            
                            <div class="flex justify-between items-center mt-2">
                                <span class="text-sm font-medium text-gray-500">Estimated Distance:</span>
                                <span class="text-sm text-gray-700">~3.2 km</span>
                            </div>
                            
                            <div class="flex justify-between items-center mt-2">
                                <span class="text-sm font-medium text-gray-500">Estimated Time:</span>
                                <span class="text-sm text-gray-700">15-25 minutes</span>
                            </div>
                        </div>
                        
                        <!-- Contact Buttons -->
                        <div class="mt-6 grid grid-cols-2 gap-3">
                            @if($order->consumer && $order->consumer->phone)
                                <a href="tel:{{ $order->consumer->phone }}" class="inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                    </svg>
                                    Call Customer
                                </a>
                            @else
                                <button disabled class="inline-flex justify-center items-center px-4 py-2 border border-gray-200 shadow-sm text-sm font-medium rounded-md text-gray-400 bg-gray-50 cursor-not-allowed">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                    </svg>
                                    No Phone
                                </button>
                            @endif
                            
                            @if($order->facility && $order->facility->user && $order->facility->user->phone)
                                <a href="tel:{{ $order->facility->user->phone }}" class="inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                    </svg>
                                    Call Facility
                                </a>
                            @else
                                <button disabled class="inline-flex justify-center items-center px-4 py-2 border border-gray-200 shadow-sm text-sm font-medium rounded-md text-gray-400 bg-gray-50 cursor-not-allowed">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                    </svg>
                                    No Phone
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')


{{-- Load Google Maps API asynchronously --}}
{{-- Ensure the API key is correctly outputted by Blade --}}
@if(empty($googleMapsApiKey))
    <div class="p-4 text-red-600 bg-red-100 rounded-lg m-4">Error: Google Maps API Key is missing. Map cannot be loaded. Please check configuration.</div>
    <script>
        console.error("Google Maps API Key is missing in the view variable '$googleMapsApiKey'.");
        // Optionally disable buttons if key is missing
        const navigatePickupButton = document.getElementById('navigate-pickup');
        const navigateDeliveryButton = document.getElementById('navigate-delivery');
        if (navigatePickupButton) navigatePickupButton.disabled = true;
        if (navigateDeliveryButton) navigateDeliveryButton.disabled = true;
    </script>
@else
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key={{ $googleMapsApiKey }}&callback=initMap&libraries=places,marker,directions">
    </script>
    {{-- Added 'directions' library --}}
@endif

@endsection