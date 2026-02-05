<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Care Coordinator Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <!-- KEY METRICS GRID -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Active Cases -->
                <div class="bg-indigo-600 rounded-2xl shadow-lg p-6 text-white flex items-center justify-between relative overflow-hidden">
                    <div class="relative z-10">
                        <p class="text-xs uppercase font-bold text-indigo-200 tracking-wider">Active Monitoring</p>
                        <h3 class="text-3xl font-black mt-1">{{ $activeCases }}</h3>
                        <p class="text-[10px] text-indigo-100 font-bold mt-2">Current Inpatients</p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-xl text-white relative z-10">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 011.414.586l5.414 5.414a1 1 0 01.586 1.414V19a2 2 0 01-2 2z" /></svg>
                    </div>
                </div>

                <!-- ALOS Metric -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 flex items-center justify-between">
                    <div>
                        <p class="text-xs uppercase font-bold text-gray-400 tracking-wider">Avg Length of Stay</p>
                        <h3 class="text-3xl font-black text-gray-800 mt-1">{{ number_format($avgLos, 1) }}</h3>
                        <p class="text-[10px] text-indigo-500 font-bold mt-2">Days (Discharged)</p>
                    </div>
                    <div class="bg-indigo-50 text-indigo-600 p-3 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                </div>

                <!-- Total Logs -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 flex items-center justify-between">
                    <div>
                        <p class="text-xs uppercase font-bold text-gray-400 tracking-wider">Total Logs</p>
                        <h3 class="text-3xl font-black text-gray-800 mt-1">{{ number_format($totalCases) }}</h3>
                        <p class="text-[10px] text-gray-400 font-bold mt-2">All Records</p>
                    </div>
                    <div class="bg-gray-50 text-gray-400 p-3 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                    </div>
                </div>

                <!-- Quick Action -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 flex flex-col justify-center items-center text-center">
                    <a href="{{ route('monitoring.create') }}" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-3 rounded-xl shadow-lg shadow-emerald-100 transition transform hover:-translate-y-1 block text-sm">
                        + New Monitoring Log
                    </a>
                </div>
            </div>

            <!-- RECENT ACTIVITY SECTION -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Recent Logs List -->
                <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="font-bold text-gray-800 text-lg">Recent Updates</h3>
                        <a href="{{ route('monitoring.index') }}" class="text-indigo-600 text-xs font-bold hover:underline">View All &rarr;</a>
                    </div>
                    
                    <div class="space-y-4">
                        @forelse($recentLogs as $log)
                        <div class="flex items-start justify-between p-4 rounded-xl bg-gray-50 hover:bg-indigo-50/50 transition border border-transparent hover:border-indigo-100">
                            <div class="flex gap-4">
                                <div class="bg-white p-3 rounded-lg shadow-sm text-indigo-600 h-min">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900">{{ $log->full_name }}</h4>
                                    <p class="text-xs text-gray-500 font-mono mb-1">{{ $log->pa_code }} • {{ $log->policy_no }}</p>
                                    <p class="text-sm text-gray-700 italic">"{{ Str::limit($log->remarks, 60) }}"</p>
                                </div>
                            </div>
                            <div class="text-right whitespace-nowrap">
                                <span class="px-2 py-1 rounded text-[10px] font-black uppercase tracking-wider
                                    {{ $log->monitoring_status == 'Discharged' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                                    {{ $log->monitoring_status }}
                                </span>
                                <p class="text-[10px] text-gray-400 font-bold mt-2">{{ $log->updated_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-12 text-gray-400 italic">
                            No recent updates found.
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Notifications / Alerts (Placeholder for now) -->
                <div class="space-y-6">
                     <div class="bg-slate-900 rounded-2xl shadow-lg p-6 text-white">
                        <h3 class="font-bold text-white mb-4 flex items-center gap-2">
                             <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                             Reminders
                        </h3>
                        <p class="text-slate-400 text-sm mb-4">Check for patients who have exceeded their expected length of stay.</p>
                        <div class="p-3 bg-white/5 rounded-lg border border-white/10">
                            <p class="text-xs text-slate-300">Tip: Regularly update patient diagnosis to ensure accurate billing vetting later.</p>
                        </div>
                     </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
