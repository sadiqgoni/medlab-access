<!-- Simulated Payment View -->
<x-consumer-dashboard-layout>
    <x-slot name="header">
        <h1 class="text-2xl md:text-3xl font-display font-bold text-gray-800">Complete Your Payment</h1>
    </x-slot>

    <div class="py-8">
        <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6 md:p-8">
                <h2 class="text-xl font-medium text-gray-900 mb-4">Order #{{ $order->id }} - Payment Simulation</h2>
                
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M8.485 3.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 3.495zM10 14a1 1 0 110-2 1 1 0 010 2zm0-7a1 1 0 011 1v3a1 1 0 11-2 0V8a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                This is a **simulated payment page** for demonstration purposes. In a real application, you would be redirected to Paystack.
                            </p>
                        </div>
                    </div>
                </div>

                <p class="mb-4 text-gray-600">Please review the order total and confirm payment.</p>

                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <dl class="space-y-2">
                        <div class="flex justify-between text-sm text-gray-600">
                            <dt>Total Amount:</dt>
                            <dd class="font-medium">₦{{ number_format($order->total_amount, 2) }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Fake Card/Bank Input -->
                <div class="space-y-4 mb-6">
                     <div>
                        <label for="fake_card" class="block text-sm font-medium text-gray-700">Card Number (Fake)</label>
                        <input type="text" id="fake_card" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100" placeholder="**** **** **** 4242" disabled>
                     </div>
                     <!-- Add more fake inputs if desired -->
                </div>

                <form method="POST" action="{{ route('consumer.orders.confirm-payment', $order) }}">
                    @csrf 
                    <button type="submit" class="w-full inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Confirm Payment (Simulated)
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-consumer-dashboard-layout> 