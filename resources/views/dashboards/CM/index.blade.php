<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Case Manager Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <!-- KEY METRICS GRID -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Active Monitoring (Shared with CC) -->
                <div class="bg-indigo-600 rounded-2xl shadow-lg p-6 text-white flex items-center justify-between relative overflow-hidden">
                    <div class="relative z-10">
                        <p class="text-xs uppercase font-bold text-indigo-200 tracking-wider">Active Monitoring</p>
                        <h3 class="text-4xl font-black mt-1">{{ $activeCases }}</h3>
                        <p class="text-[10px] text-indigo-100 font-bold mt-2">Patients Admitted</p>
                    </div>
                    <div class="bg-white/20 p-4 rounded-xl text-white relative z-10">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 011.414.586l5.414 5.414a1 1 0 01.586 1.414V19a2 2 0 01-2 2z" /></svg>
                    </div>
                    <!-- Decorative Circle -->
                    <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                </div>

                <!-- Outstanding Bills -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 flex items-center justify-between">
                    <div>
                        <p class="text-xs uppercase font-bold text-gray-400 tracking-wider">Pending Bills</p>
                        <h3 class="text-3xl font-black text-amber-500 mt-1">{{ number_format($outstandingBills) }}</h3>
                        <p class="text-[10px] text-gray-400 font-bold mt-2">Awaiting Processing</p>
                    </div>
                    <div class="bg-amber-50 text-amber-500 p-4 rounded-xl">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                </div>

                <!-- Total Bills -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 flex items-center justify-between">
                    <div>
                        <p class="text-xs uppercase font-bold text-gray-400 tracking-wider">Total Bills</p>
                        <h3 class="text-3xl font-black text-gray-800 mt-1">{{ number_format($totalBills) }}</h3>
                        <p class="text-[10px] text-gray-400 font-bold mt-2">Processed Lifetime</p>
                    </div>
                    <div class="bg-emerald-50 text-emerald-600 p-4 rounded-xl">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-800 mb-4">Monitoring Actions</h3>
                    <div class="grid grid-cols-1 gap-4">
                        <a href="{{ route('monitoring.create') }}" class="group flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-indigo-50 transition border border-transparent hover:border-indigo-100">
                            <span class="font-bold text-gray-700 group-hover:text-indigo-700">Update Patient Status</span>
                            <span class="text-gray-400 group-hover:text-indigo-500">&rarr;</span>
                        </a>
                        <a href="{{ route('monitoring.index') }}" class="group flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-indigo-50 transition border border-transparent hover:border-indigo-100">
                            <span class="font-bold text-gray-700 group-hover:text-indigo-700">View All Logs</span>
                            <span class="text-gray-400 group-hover:text-indigo-500">&rarr;</span>
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-800 mb-4">Billing Actions</h3>
                    <div class="grid grid-cols-1 gap-4">
                        <a href="{{ route('bill-management.cm.index') }}" class="group flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-indigo-50 transition border border-transparent hover:border-indigo-100">
                            <span class="font-bold text-gray-700 group-hover:text-indigo-700">Process Pending Bills</span>
                            <span class="text-gray-400 group-hover:text-indigo-500">&rarr;</span>
                        </a>
                        <a href="{{ route('hcp.search') }}" class="group flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-indigo-50 transition border border-transparent hover:border-indigo-100">
                            <span class="font-bold text-gray-700 group-hover:text-indigo-700">Search HCP Network</span>
                            <span class="text-gray-400 group-hover:text-indigo-500">&rarr;</span>
                        </a>
                        <a href="{{ route('hcp-uploads.admin') }}" class="group flex items-center justify-between p-4 bg-indigo-50/50 rounded-xl hover:bg-indigo-50 transition border border-transparent hover:border-indigo-200">
                            <span class="font-bold text-indigo-700">Download Hospital Submissions</span>
                            <span class="text-indigo-400">&rarr;</span>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
