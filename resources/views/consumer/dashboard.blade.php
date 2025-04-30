    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Consumer Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Welcome, {{ Auth::user()->name }}!</h3>
                        <a href="{{ route('consumer.orders.create') }}" class="inline-flex items-center px-4 py-2 bg-primary-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-600 active:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Place New Order
                        </a>
                    </div>
                    
                    <p class="mt-2 mb-6">This is your Consumer Dashboard for MedLab-Access.</p>
                    
                    <div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        <!-- eMedSample Card -->
                        <div class="bg-gradient-to-r from-blue-50 to-blue-100 overflow-hidden shadow rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                                        <!-- Test Tube Icon -->
                                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                        </svg>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                        <dt class="text-sm font-medium text-gray-500 truncate">eMedSample</dt>
                                        <dd class="flex items-baseline">
                                            <div class="text-lg font-semibold text-gray-900">Lab Testing</div>
                                        </dd>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-blue-50 px-4 py-4 sm:px-6">
                                <div class="text-sm">
                                    <a href="#" class="font-medium text-blue-700 hover:text-blue-900">
                                        Request a lab test <span aria-hidden="true">&rarr;</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- SharedBlood Card -->
                        <div class="bg-gradient-to-r from-red-50 to-red-100 overflow-hidden shadow rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 bg-red-500 rounded-md p-3">
                                        <!-- Blood Drop Icon -->
                                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m0 0l6.75-6.75M12 19.5l-6.75-6.75" />
                                        </svg>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                        <dt class="text-sm font-medium text-gray-500 truncate">SharedBlood</dt>
                                        <dd class="flex items-baseline">
                                            <div class="text-lg font-semibold text-gray-900">Blood Donation & Requests</div>
                                        </dd>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-red-50 px-4 py-4 sm:px-6">
                                <div class="text-sm">
                                    <a href="#" class="font-medium text-red-700 hover:text-red-900">
                                        Donate or request blood <span aria-hidden="true">&rarr;</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- My Orders Card -->
                        <div class="bg-gradient-to-r from-green-50 to-green-100 overflow-hidden shadow rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                        <!-- Clock Icon -->
                                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                        <dt class="text-sm font-medium text-gray-500 truncate">My Orders</dt>
                                        <dd class="flex items-baseline">
                                            <div class="text-lg font-semibold text-gray-900">Recent Activity</div>
                                        </dd>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-green-50 px-4 py-4 sm:px-6">
                                <div class="text-sm">
                                    <a href="#" class="font-medium text-green-700 hover:text-green-900">
                                        View all orders <span aria-hidden="true">&rarr;</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Orders Section -->
                    <div class="mt-8 pt-6 border-t">
                         <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Orders</h3>
                         
                         <div class="bg-gray-50 p-4 rounded-md">
                             <p class="text-sm text-gray-600">Order history will be displayed here.</p>
                             <a href="{{ route('consumer.orders.index') }}" class="text-sm font-medium text-primary-600 hover:text-primary-800">View All Orders &rarr;</a>
                         </div>
                         <!-- TODO: Implement order list display -->
                    </div>
                </div>
            </div>
        </div>
    </div>
