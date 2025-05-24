<x-filament-panels::page>
    <div class="flex flex-col gap-y-8">
            <div class="flex flex-col gap-y-2">
                <x-filament-panels::header :actions="$this->getCachedHeaderActions()" :breadcrumbs="$this->getBreadcrumbs()" :heading="$this->getHeading()" :subheading="$this->getSubheading()">
                    {{ $this->getHeader() }}
                </x-filament-panels::header>

                @if ($this->getHeaderWidgets())
                    <x-filament-widgets::widgets :columns="$this->getHeaderWidgetsColumns()" :widgets="$this->getHeaderWidgets()" />
                @endif
            </div>

        <div class="filament-widgets-container">
            <div class="p-6 bg-white shadow rounded-xl">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-medium text-gray-900">Service Management</h2>
                    <a href="{{ \App\Filament\Provider\Resources\ServiceResource::getUrl() }}" class="text-primary-600 hover:text-primary-500 text-sm font-medium">
                        View all services
                    </a>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Quick Service Actions -->
                    <div class="col-span-1 lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-primary-50 p-5 rounded-lg border border-primary-200 flex flex-col">
                            <div class="flex items-center mb-3">
                                <span class="text-primary-700 bg-primary-100 p-2 rounded-full mr-3">
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                                <h3 class="font-medium text-gray-900">Add New Service</h3>
                            </div>
                            <p class="text-sm text-gray-600 mb-4">Define laboratory tests or blood donation services your facility offers.</p>
                            <a href="{{ \App\Filament\Provider\Resources\ServiceResource::getUrl('create') }}" class="mt-auto text-sm font-medium text-primary-600 hover:text-primary-500 inline-flex items-center">
                                Add service
                                <svg class="ml-1 w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                        
                        <div class="bg-gray-50 p-5 rounded-lg border border-gray-200 flex flex-col">
                            <div class="flex items-center mb-3">
                                <span class="text-gray-700 bg-gray-100 p-2 rounded-full mr-3">
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                                <h3 class="font-medium text-gray-900">Service Approval Status</h3>
                            </div>
                            <p class="text-sm text-gray-600 mb-4">Check the approval status of your submitted services.</p>
                            <a href="{{ route('filament.provider.resources.services.index') }}?tableFilters[status]=pending" class="mt-auto text-sm font-medium text-gray-600 hover:text-gray-500 inline-flex items-center">
                                View pending approvals
                                <svg class="ml-1 w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Latest Services -->
                    <div class="col-span-1">
                        <div class="bg-white rounded-lg border border-gray-200 p-5">
                            <h3 class="font-medium text-gray-900 mb-3">Latest Services</h3>
                            @php
                                $latestServices = \App\Models\Service::where('facility_id', auth()->user()->facility_id)
                                    ->latest()
                                    ->limit(5)
                                    ->get();
                            @endphp
                            
                            @if($latestServices->count() > 0)
                                <ul class="space-y-3">
                                    @foreach($latestServices as $service)
                                        <li class="flex items-center justify-between">
                                            <div>
                                                <span class="block text-sm font-medium text-gray-900">{{ $service->name }}</span>
                                                <span class="block text-xs text-gray-500">₦{{ number_format($service->price, 2) }}</span>
                                            </div>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                {{ $service->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                                   ($service->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                {{ ucfirst($service->status) }}
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="text-sm text-gray-500 italic">
                                    No services added yet. Start by adding your first service.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
            
        @if ($this->getFooterWidgets())
            <x-filament-widgets::widgets :columns="$this->getFooterWidgetsColumns()" :widgets="$this->getFooterWidgets()" />
        @endif
    </div>
</x-filament-panels::page>
