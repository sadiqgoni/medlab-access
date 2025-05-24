<x-filament-panels::page>
    <!-- Intro Banner -->
    <div class="rounded-lg bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200 p-6 mb-6">
        <div class="flex flex-col md:flex-row gap-6">
            <div class="md:w-8/12">
                <h1 class="text-2xl font-bold text-amber-800 mb-2">Provider Approval Dashboard</h1>
                <p class="text-amber-700">
                    This dashboard helps you manage new service providers who have registered on the platform. 
                    Review their details carefully before approving or rejecting their application.
                </p>
                <div class="flex flex-wrap gap-3 mt-4">
                    <div class="bg-white/50 rounded-full px-4 py-2 flex items-center gap-2 shadow-sm">
                        <div class="h-3 w-3 rounded-full bg-amber-400"></div>
                        <span class="text-sm font-medium text-amber-800">Pending Review</span>
                    </div>
                    <div class="bg-white/50 rounded-full px-4 py-2 flex items-center gap-2 shadow-sm">
                        <div class="h-3 w-3 rounded-full bg-green-500"></div>
                        <span class="text-sm font-medium text-amber-800">Approved</span>
                    </div>
                    <div class="bg-white/50 rounded-full px-4 py-2 flex items-center gap-2 shadow-sm">
                        <div class="h-3 w-3 rounded-full bg-red-500"></div>
                        <span class="text-sm font-medium text-amber-800">Rejected</span>
                    </div>
                </div>
            </div>
            <div class="md:w-4/12 flex justify-center md:justify-end">
                <div class="h-32 w-32 bg-amber-100 rounded-full flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Component -->
    {{ $this->table }}
    
    <!-- Help Section -->
    <div class="mt-8 bg-white rounded-lg shadow-sm p-6 border border-gray-200">
        <h2 class="text-lg font-medium text-gray-900 mb-3">Review Process Guidelines</h2>
        <div class="prose max-w-none text-gray-500">
            <p>When reviewing provider applications, please verify the following:</p>
            <ul>
                <li>The provider's Government ID is valid and matches their name</li>
                <li>The facility address exists and is valid (check the map)</li>
                <li>The facility's license number is valid and registered</li>
                <li>The services offered match the facility type</li>
                <li>The contact information is functional and reachable</li>
            </ul>
            <p class="text-sm mt-4">For any questions regarding the provider approval process, please refer to the <a href="#" class="text-amber-600 hover:text-amber-800">Administrator Guidelines</a> or contact the system administrator.</p>
        </div>
    </div>
</x-filament-panels::page>