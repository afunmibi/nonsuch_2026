<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Healthcare Provider Network Search') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Search Box -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
                <div class="flex gap-4">
                    <div class="flex-1">
                        <input 
                            type="text" 
                            id="searchInput" 
                            placeholder="Search by hospital name or code..." 
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        >
                    </div>
                    <button 
                        onclick="searchHospitals()" 
                        class="px-8 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">
                        <i class="fas fa-search mr-2"></i> Search
                    </button>
                </div>
            </div>

            <!-- Results Container -->
            <div id="resultsContainer" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="text-center py-12 text-gray-400">
                    <i class="fas fa-hospital text-6xl mb-4"></i>
                    <p class="font-medium">Enter a hospital name or code to search</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function searchHospitals() {
            const query = document.getElementById('searchInput').value;
            const resultsContainer = document.getElementById('resultsContainer');
            
            if (!query.trim()) {
                resultsContainer.innerHTML = `
                    <div class="text-center py-12 text-gray-400">
                        <i class="fas fa-hospital text-6xl mb-4"></i>
                        <p class="font-medium">Enter a hospital name or code to search</p>
                    </div>
                `;
                return;
            }

            // Show loading state
            resultsContainer.innerHTML = `
                <div class="text-center py-12">
                    <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600"></div>
                    <p class="mt-4 text-gray-500">Searching...</p>
                </div>
            `;

            // Fetch results
            fetch(`/api/hcp-search?query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length === 0) {
                        resultsContainer.innerHTML = `
                            <div class="text-center py-12 text-gray-400">
                                <i class="fas fa-search text-6xl mb-4"></i>
                                <p class="font-medium">No hospitals found matching "${query}"</p>
                            </div>
                        `;
                        return;
                    }

                    let html = `
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Search Results (${data.length})</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    `;

                    data.forEach(hospital => {
                        html += `
                            <div class="border border-gray-200 rounded-xl p-6 hover:shadow-lg transition">
                                <div class="flex items-start justify-between mb-4">
                                    <div>
                                        <h4 class="text-lg font-bold text-gray-900">${hospital.hcp_name}</h4>
                                        <p class="text-xs text-gray-400 font-bold uppercase mt-1">${hospital.hcp_code}</p>
                                    </div>
                                    <span class="px-3 py-1 rounded-full text-xs font-black uppercase ${hospital.hcp_accreditation_status === 'Accredited' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700'}">
                                        ${hospital.hcp_accreditation_status}
                                    </span>
                                </div>
                                
                                <div class="space-y-2 text-sm">
                                    <div class="flex items-center text-gray-600">
                                        <i class="fas fa-map-marker-alt w-5 mr-2 text-gray-400"></i>
                                        <span>${hospital.hcp_location}</span>
                                    </div>
                                    <div class="flex items-center text-gray-600">
                                        <i class="fas fa-phone w-5 mr-2 text-gray-400"></i>
                                        <span>${hospital.hcp_contact}</span>
                                    </div>
                                    <div class="flex items-center text-gray-600">
                                        <i class="fas fa-envelope w-5 mr-2 text-gray-400"></i>
                                        <span>${hospital.hcp_email}</span>
                                    </div>
                                </div>

                                <div class="mt-4 pt-4 border-t border-gray-100">
                                    <p class="text-xs text-gray-500 font-bold mb-1">Banking Details</p>
                                    <p class="text-sm text-gray-700">${hospital.hcp_bank_name} - ${hospital.hcp_account_number}</p>
                                    <p class="text-xs text-gray-500">${hospital.hcp_account_name}</p>
                                </div>
                            </div>
                        `;
                    });

                    html += '</div>';
                    resultsContainer.innerHTML = html;
                })
                .catch(error => {
                    resultsContainer.innerHTML = `
                        <div class="text-center py-12 text-red-500">
                            <i class="fas fa-exclamation-triangle text-6xl mb-4"></i>
                            <p class="font-medium">Error loading results. Please try again.</p>
                        </div>
                    `;
                    console.error('Search error:', error);
                });
        }

        // Allow Enter key to trigger search
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                searchHospitals();
            }
        });
    </script>
</x-app-layout>
