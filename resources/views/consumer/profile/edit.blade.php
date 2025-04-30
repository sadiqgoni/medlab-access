<x-consumer-dashboard-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('consumer.dashboard') }}" class="mr-2 bg-primary-100 hover:bg-primary-200 rounded-full p-2 transition-colors">
                <i class="fas fa-arrow-left text-primary-700"></i>
            </a>
            <div>
                <h1 class="text-2xl md:text-3xl font-display font-bold text-gray-800">Edit Profile</h1>
                <p class="mt-1 text-gray-500">Update your personal information</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Profile Edit Form Here -->
            <div class="bg-white shadow rounded-lg p-6">
                <p>Profile edit form content goes here...</p>
                <!-- Replace with actual form elements -->
            </div>
        </div>
    </div>
</x-consumer-dashboard-layout>
