{{-- Display all services associated with this order --}}

@php
    $record = $getRecord();
    // Call the renamed method to get the collection
    $orderedServices = $record->getServiceDetailsFromData();
@endphp

<div class="rounded-md bg-gray-50 p-4">
    @if($orderedServices->isEmpty())
        <div class="text-gray-500 text-center py-4">
            <span class="block text-sm">No services found for this order</span>
        </div>
    @else
        <div class="space-y-3">
            @foreach($orderedServices as $service)
                <div class="bg-white rounded-lg shadow-sm p-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            @if($service->category == 'eMedSample')
                                <div class="w-10 h-10 rounded-md bg-blue-100 flex items-center justify-center mr-3 flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M7 2a1 1 0 00-.707 1.707L7 4.414v3.758a1 1 0 01-.293.707l-4 4C.817 14.769 2.156 18 4.828 18h10.343c2.673 0 4.012-3.231 2.122-5.121l-4-4A1 1 0 0113 8.172V4.414l.707-.707A1 1 0 0013 2H7zm2 6.172V4h2v4.172a3 3 0 00.879 2.12l1.027 1.028a4 4 0 00-2.171.102l-.47.156a4 4 0 01-2.53 0l-.563-.187a1.993 1.993 0 00-.114-.035l1.063-1.063A3 3 0 009 8.172z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @else
                                <div class="w-10 h-10 rounded-md bg-red-100 flex items-center justify-center mr-3 flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @endif
                            <div>
                                <h4 class="font-medium text-gray-900">{{ $service->name }}</h4>
                                <p class="text-xs text-gray-500">
                                    {{ $service->category }} 
                                    @if($service->category == 'eMedSample' && $service->turnaround_time)
                                        · Turnaround: {{ $service->turnaround_time }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="font-medium text-gray-900">₦{{ number_format($service->price, 2) }}</span>
                            <span class="block text-xs text-{{ $service->availability_status == 'available' ? 'green' : ($service->availability_status == 'limited' ? 'amber' : 'red') }}-600">
                                {{ ucfirst($service->availability_status) }}
                            </span>
                        </div>
                    </div>
                    
                    @if($service->requirements)
                        <div class="mt-3 pt-3 border-t border-gray-100">
                            <p class="text-xs text-gray-500">
                                <span class="font-medium">Requirements:</span> {{ $service->requirements }}
                            </p>
                        </div>
                    @endif
                    
                    @if($service->notes)
                        <div class="mt-2">
                            <p class="text-xs text-gray-500">
                                <span class="font-medium">Notes:</span> {{ $service->notes }}
                            </p>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>