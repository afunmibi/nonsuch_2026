<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bill Management - Underwriter Portal') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto p-4 md:p-6 pb-20">
        
       @if(session('success') || request()->has('message'))
    <div x-data="{ show: true }" 
         x-show="show" 
         x-init="setTimeout(() => show = false, 4000)"
         class="mb-4 flex items-center p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 rounded shadow-sm transition-all">
        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
        </svg>
        <span>{{ session('success') ?? request()->get('message') }}</span>
    </div>
@endif

        <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200 mb-6 flex flex-col md:flex-row items-center justify-between gap-4">
            <div>
                <h2 class="text-lg font-bold text-slate-800 tracking-tight">UD Vetting Station</h2>
                <p class="text-xs text-slate-500 font-medium">Verify PA Codes to authorize processed hospital bills.</p>
            </div>
            
            <div class="w-full md:w-96">
                <form action="{{ route('bill-management.ud.index') }}" method="GET" class="flex gap-2">
                    <div class="relative flex-1">
                        <input type="text" name="pa_code" value="{{ request('pa_code') }}" 
                               placeholder="Scan or Type PA Code..."
                               class="w-full border border-slate-300 rounded-lg shadow-sm px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all" 
                               required>
                    </div>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-6 rounded-lg text-sm shadow-sm transition-colors flex items-center">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        Unlock
                    </button>
                </form>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Patient / Policy</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">PA Code</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Staff Review</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Billing Period</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Calculated Due</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">HCP Claim</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100">
                        @forelse ($billvetting as $bill)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-semibold text-slate-900">{{ $bill->full_name ?? 'N/A' }}</div>
                                    <div class="text-[11px] text-slate-500 font-mono">{{ $bill->policy_no }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 bg-slate-100 text-slate-700 rounded text-xs font-mono border border-slate-200">
                                        {{ $bill->pa_code }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center text-sm text-slate-600">
                                        <div class="h-6 w-6 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center mr-2">
                                            <span class="text-[10px] font-bold">{{ substr($bill->vetted_by ?? 'S', 0, 1) }}</span>
                                        </div>
                                        {{ $bill->vetted_by }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-700 font-medium">
                                    {{ $bill->billing_month }}
                                </td>
                                <td class="px-6 py-4 text-sm font-bold text-blue-700">
                                    ₦{{ number_format($bill->hcp_amount_due_grandtotal, 2) }}
                                </td>
                                <td class="px-6 py-4 text-sm font-bold text-emerald-700">
                                    ₦{{ number_format($bill->hcp_amount_claimed_grandtotal, 2) }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('bill-management.ud.edit', base64_encode($bill->pa_code)) }}" 
                                           class="inline-flex items-center px-3 py-1.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 shadow-sm transition-all text-xs font-bold">
                                            <i class="fas fa-edit mr-1"></i> Edit & Update
                                        </a>
                                        <a href="{{ route('bill-management.ud.show', base64_encode($bill->pa_code)) }}" 
                                           class="inline-flex items-center px-3 py-1.5 bg-white border border-slate-200 text-slate-600 rounded-lg hover:bg-slate-50 transition-all text-xs font-bold">
                                            <i class="fas fa-eye mr-1"></i> View
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <!-- Structured Breakdown Row -->
                            <tr class="bg-slate-50/30">
                                <td colspan="7" class="px-6 py-4 border-t border-slate-100">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <!-- Services Breakdown -->
                                        <div class="bg-white p-3 rounded-lg border border-slate-200 shadow-sm">
                                            <h4 class="text-[10px] font-black text-blue-600 uppercase mb-2 flex items-center gap-1">
                                                <i class="fas fa-hand-holding-medical"></i> Medical Services
                                            </h4>
                                            <div class="space-y-1">
                                                @forelse($bill->services as $s)
                                                    <div class="flex justify-between text-[11px] border-b border-slate-50 pb-1">
                                                        <span class="text-slate-600">{{ $s->service_name }} (x{{ $s->qty }})</span>
                                                        <span class="font-bold text-blue-700">₦{{ number_format($s->tariff * $s->qty, 2) }}</span>
                                                    </div>
                                                @empty
                                                    <p class="text-[10px] text-slate-400 italic">No services listed</p>
                                                @endforelse
                                            </div>
                                        </div>
                                        <!-- Drugs Breakdown -->
                                        <div class="bg-white p-3 rounded-lg border border-slate-200 shadow-sm">
                                            <h4 class="text-[10px] font-black text-emerald-600 uppercase mb-2 flex items-center gap-1">
                                                <i class="fas fa-capsules"></i> Drugs & Consumables
                                            </h4>
                                            <div class="space-y-1">
                                                @forelse($bill->drugs as $d)
                                                    <div class="flex justify-between text-[11px] border-b border-slate-50 pb-1">
                                                        <span class="text-slate-600">{{ $d->drug_name }} (x{{ $d->qty }})</span>
                                                        <span class="font-bold text-emerald-700">₦{{ number_format($d->tariff * $d->qty * 0.9, 2) }}</span>
                                                    </div>
                                                @empty
                                                    <p class="text-[10px] text-slate-400 italic">No drugs listed</p>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="p-3 bg-slate-50 rounded-full mb-3">
                                            <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        </div>
                                        @if(request('pa_code'))
                                            <p class="text-slate-500 text-sm font-medium">No vetting records found for <span class="text-indigo-600">"{{ request('pa_code') }}"</span></p>
                                            <p class="text-[11px] text-slate-400 mt-1">Make sure the Staff member has finalized the initial vetting process.</p>
                                        @else
                                            <p class="text-slate-500 text-sm font-medium italic">Station Locked</p>
                                            <p class="text-[11px] text-slate-400 mt-1 uppercase tracking-widest font-bold">Enter a PA Code above to begin Underwriter Review</p>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>