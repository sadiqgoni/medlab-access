{{-- Facility Information for Biker's Delivery Tasks --}}

@php
    $facility = $getRecord()->facility;
    $orderType = $getRecord()->order_type;
@endphp

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-4 bg-green-50 border-b border-green-100 flex items-center">
        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 01-1 1h-1a1 1 0 01-1-1v-2a1 1 0 00-1-1H8a1 1 0 00-1 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd" />
            </svg>
        </div>
        <div>
            <h3 class="font-medium text-green-900">Facility Information</h3>
            <p class="text-sm text-green-600">
                @if($orderType === 'test')
                    Sample delivery location
                @else
                    Blood pickup location
                @endif
            </p>
        </div>
    </div>
    
    <div class="p-4">
        @if($facility)
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <div>
                    <h4 class="text-sm font-medium text-gray-500 mb-1">Facility Name</h4>
                    <p class="text-gray-900 font-medium">{{ $facility->name }}</p>
                </div>
                
                <div>
                    <h4 class="text-sm font-medium text-gray-500 mb-1">Contact</h4>
                    @if($facility->phone)
                        <p class="text-gray-900">
                            <a href="tel:{{ $facility->phone }}" class="flex items-center group">
                                {{ $facility->phone }}
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 text-green-500 opacity-0 group-hover:opacity-100 transition-opacity" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                </svg>
                            </a>
                        </p>
                    @else
                        <p class="text-gray-400 italic">Not provided</p>
                    @endif
                </div>
            </div>
            
            <div class="mt-4">
                <h4 class="text-sm font-medium text-gray-500 mb-1">
                    @if($orderType === 'test')
                        Delivery Location
                    @else
                        Pickup Location
                    @endif
                </h4>
                <p class="text-gray-900">{{ $facility->address ?? 'No address provided' }}</p>
                @if($facility->address)
                    <a 
                        href="https://maps.google.com/?q={{ urlencode($facility->address) }}" 
                        target="_blank"
                        class="mt-2 inline-flex items-center text-sm text-green-600 hover:text-green-800 transition-colors"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                        </svg>
                        View on Map
                    </a>
                @endif
            </div>
            
            @if($getRecord()->facility_notes)
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <h4 class="text-sm font-medium text-gray-500 mb-1">Facility Instructions</h4>
                    <div class="bg-green-50 text-green-800 p-3 rounded-md text-sm">
                        {{ $getRecord()->facility_notes }}
                    </div>
                </div>
            @endif
            
            @if($orderType === 'test')
                <div class="mt-4 pt-4 border-t border-gray-100 flex items-center space-x-3">
                    <div class="p-2 bg-green-100 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <p class="text-sm text-gray-600">
                        For test orders, <strong>deliver the samples TO this facility</strong> after picking them up from the customer.
                    </p>
                </div>
            @else
                <div class="mt-4 pt-4 border-t border-gray-100 flex items-center space-x-3">
                    <div class="p-2 bg-red-100 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <p class="text-sm text-gray-600">
                        For blood orders, <strong>pick up blood FROM this facility</strong> and deliver it to the customer.
                    </p>
                </div>
            @endif
        @else
            <div class="p-4 text-center">
                <p class="text-gray-500">Facility information not available</p>
            </div>
        @endif
    </div>
</div>