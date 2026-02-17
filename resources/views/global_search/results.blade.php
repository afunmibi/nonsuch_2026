<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Search Results for "{{ $query }}"
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto p-6 space-y-6">
        
        <!-- Patient & Package Overview -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Patient Profile -->
            <div class="md:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden relative">
                <div class="bg-indigo-600 h-24"></div>
                <div class="px-6 pb-6 mt-[-40px] flex items-end gap-6">
                    <div class="bg-white p-1 rounded-2xl shadow-lg">
                        @if($enrolment->photograph)
                            <img src="{{ asset('storage/' . $enrolment->photograph) }}" class="w-24 h-24 rounded-xl object-cover bg-slate-200">
                        @else
                            <div class="w-24 h-24 rounded-xl bg-slate-100 flex items-center justify-center text-slate-300 text-3xl">
                                <i class="fas fa-user"></i>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 pb-1">
                        <h3 class="text-2xl font-bold text-slate-800">{{ $enrolment->full_name }}</h3>
                        <p class="text-indigo-600 font-mono font-bold">{{ $enrolment->policy_no }}</p>
                    </div>
                </div>
                <div class="p-6 grid grid-cols-2 md:grid-cols-4 gap-4 border-t border-slate-50">
                    <div>
                        <span class="text-[10px] uppercase font-bold text-slate-400">Phone</span>
                        <p class="text-sm font-semibold text-slate-700">{{ $enrolment->phone_no }}</p>
                    </div>
                    <div>
                         <span class="text-[10px] uppercase font-bold text-slate-400">Date of Birth</span>
                        <p class="text-sm font-semibold text-slate-700">{{ $enrolment->dob ?? 'N/A' }}</p>
                    </div>
                    <div>
                         <span class="text-[10px] uppercase font-bold text-slate-400">Company</span>
                        <p class="text-sm font-semibold text-slate-700 truncate">{{ $enrolment->organization_name }}</p>
                    </div>
                     <div>
                         <span class="text-[10px] uppercase font-bold text-slate-400">Primary HCP</span>
                        <p class="text-sm font-semibold text-slate-700 truncate">{{ $enrolment->pry_hcp }}</p>
                    </div>
                </div>
            </div>

            <!-- Package Details -->
            <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-2xl shadow-lg text-white p-6 relative overflow-hidden">
                <div class="absolute top-0 right-0 p-4 opacity-10">
                    <i class="fas fa-box-open fa-6x"></i>
                </div>
                <h4 class="text-sm uppercase font-bold text-emerald-400 mb-4 tracking-widest">Active Plan</h4>
                
                <div class="space-y-4 relative z-10">
                    <div>
                        <span class="text-xs text-slate-400 block">Package Name</span>
                        <p class="text-2xl font-bold leading-none">{{ $package->package_name ?? $enrolment->package_description }}</p>
                        <p class="text-xs text-slate-400 mt-1 font-mono">{{ $enrolment->package_code }}</p>
                    </div>
                    
                    <div class="pt-4 border-t border-white/10 grid grid-cols-2 gap-4">
                        <div>
                            <span class="text-[10px] uppercase text-slate-500 font-bold">Annual Limit</span>
                            <p class="text-lg font-bold text-emerald-300">₦{{ number_format($enrolment->package_limit, 2) }}</p>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase text-slate-500 font-bold">Premium</span>
                            <p class="text-lg font-bold text-white">₦{{ number_format($enrolment->package_price, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Utilization Analysis & Management Alert -->
        <div class="bg-white rounded-2xl shadow-sm border {{ $enrolment->isHighUtilization() ? 'border-amber-400 ring-2 ring-amber-100' : 'border-slate-200' }} overflow-hidden">
            <div class="px-6 py-4 bg-slate-50 border-b border-slate-200 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h3 class="font-bold text-slate-700 uppercase tracking-wider text-sm flex items-center gap-2">
                        <i class="fas fa-chart-line text-indigo-500"></i>
                        Utilization Analysis
                    </h3>
                    <p class="text-[10px] text-slate-500 font-medium mt-0.5">
                        <i class="fas fa-info-circle mr-1 text-indigo-400"></i>
                         Reminder: <strong>Package Limit</strong> (₦{{ number_format($enrolment->package_limit, 2) }}) is what the company can afford for this client. 
                         (Package Price: ₦{{ number_format($enrolment->package_price, 2) }})
                    </p>
                </div>
                @if($enrolment->isHighUtilization())
                    <div class="flex items-center gap-2 bg-amber-600 text-white text-[10px] font-black px-3 py-1.5 rounded-full animate-pulse shadow-sm">
                        <i class="fas fa-exclamation-triangle"></i>
                        MANAGEMENT ALERT: HIGH UTILIZATION
                    </div>
                @endif
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-center text-center md:text-left">
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                        <span class="text-[10px] uppercase font-bold text-slate-400 block mb-1 tracking-widest">Total Utilized</span>
                        <p class="text-xl font-black text-slate-800 tracking-tight">₦{{ number_format($enrolment->total_utilized, 2) }}</p>
                    </div>

                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                        <span class="text-[10px] uppercase font-bold text-slate-400 block mb-1 tracking-widest">Remaining Balance</span>
                        <p class="text-xl font-black {{ $enrolment->remaining_balance < 0 ? 'text-red-600' : 'text-emerald-600' }} tracking-tight">
                            ₦{{ number_format($enrolment->remaining_balance, 2) }}
                        </p>
                    </div>

                    <div class="md:col-span-2 px-2">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-[10px] uppercase font-bold text-indigo-600 tracking-widest">Utilization Rate</span>
                            <span class="text-xs font-bold font-mono {{ $enrolment->utilization_rate >= 80 ? 'text-amber-600' : 'text-indigo-600' }}">
                                {{ $enrolment->utilization_rate }}%
                            </span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden shadow-inner">
                            <div class="h-full rounded-full transition-all duration-1000 ease-out {{ $enrolment->utilization_rate >= 80 ? 'bg-gradient-to-r from-amber-400 to-amber-600' : 'bg-gradient-to-r from-indigo-500 to-indigo-600' }}" 
                                 style="width: {{ min($enrolment->utilization_rate, 100) }}%"></div>
                        </div>
                        @if($enrolment->isHighUtilization())
                            <p class="text-[10px] text-amber-700 font-bold mt-3 bg-amber-50 p-2 rounded border border-amber-100">
                                <i class="fas fa-user-shield mr-1"></i> Informed Management: Client utilization is excessively high for the current plan limits.
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Visits (Last 5) -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 bg-slate-50 border-b border-slate-200 flex justify-between items-center">
                <h3 class="font-bold text-slate-700">Last 5 Visits (Payment History)</h3>
                <span class="text-xs font-bold bg-blue-100 text-blue-700 px-2 py-1 rounded-full">Recent Activity</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-xs">
                        <tr>
                            <th class="px-6 py-3">Date</th>
                            <th class="px-6 py-3">PA Code</th>
                            <th class="px-6 py-3">Provider (HCP)</th>
                            <th class="px-6 py-3">Diagnosis</th>
                            <th class="px-6 py-3 text-right">Amount Paid</th>
                            <th class="px-6 py-3 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($recentVisits as $visit)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4">{{ optional($visit->created_at)->format('M d, Y') }}</td>
                            <td class="px-6 py-4 font-mono text-xs">{{ $visit->pa_code }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $visit->sec_hcp ?? $visit->pry_hcp }}</td>
                            <td class="px-6 py-4 text-slate-600 truncate max-w-xs">{{ $visit->diagnosis }}</td>
                            <td class="px-6 py-4 text-right font-bold text-slate-800">
                                @if($visit->status === 'paid')
                                    ₦{{ number_format($visit->hcp_amount_due_grandtotal, 2) }}
                                @else
                                    <span class="text-slate-400 italic">Pending</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-2 py-1 rounded text-[10px] font-bold uppercase
                                    {{ $visit->status === 'paid' ? 'bg-emerald-100 text-emerald-700' : 
                                      ($visit->status === 'approved' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-600') }}">
                                    {{ $visit->status }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-400 italic">No recent visit history found for this policy.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Log Request History -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
             <div class="px-6 py-4 bg-slate-50 border-b border-slate-200">
                <h3 class="font-bold text-slate-700">Recent Request Logs</h3>
            </div>
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3">Logged Date</th>
                        <th class="px-6 py-3">PA Code</th>
                        <th class="px-6 py-3">Diagnosis</th>
                        <th class="px-6 py-3">Treatment Plan</th>
                        <th class="px-6 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($logRequests as $log)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-3">{{ $log->created_at->format('M d, Y H:i') }}</td>
                        <td class="px-6 py-3 font-mono text-xs">{{ $log->pa_code }}</td>
                        <td class="px-6 py-3 truncate max-w-xs">{{ $log->diagnosis }}</td>
                        <td class="px-6 py-3 truncate max-w-xs">{{ $log->treatment_plan }}</td>
                        <td class="px-6 py-3">
                            <span class="text-xs font-bold {{ $log->pa_code_status == 'approved' || $log->pa_code_status == 'paid' ? 'text-emerald-600' : 'text-amber-600' }}">
                                {{ ucfirst($log->pa_code_status ?? 'Pending') }}
                            </span>
                        </td>
                    </tr>
                    @empty
                     <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-400 italic">No authorization requests logs found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>
