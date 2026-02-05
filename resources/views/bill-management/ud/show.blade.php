<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800 leading-tight">
                Vetting Details: <span class="text-indigo-600 font-mono">{{ $log->pa_code }}</span>
            </h2>
            <a href="{{ route('bill-management.ud.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition ease-in-out duration-150">
                ← Back to Portal
            </a>
        </div>
    </x-slot>

    <div class="py-10 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-200">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-6">
                        <h3 class="text-lg font-bold text-slate-800 border-b-2 border-indigo-500 pb-1">Primary Bill Information</h3>
                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold uppercase tracking-tight">Staff Vetted</span>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase">Patient / Policy</p>
                            <p class="text-sm font-semibold text-slate-900">{{ $log->full_name }}</p>
                            <p class="text-xs text-slate-500 font-mono">{{ $log->policy_no }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase">Billing Period</p>
                            <p class="text-sm font-semibold text-slate-900">{{ $log->billing_month }}</p>
                            <p class="text-xs text-slate-500">Days Admitted: {{ $log->admission_days }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase">Staff Auditor</p>
                            <p class="text-sm font-semibold text-slate-900">{{ $log->vetted_by ?? 'System' }}</p>
                            <p class="text-xs text-slate-500">Date: {{ $log->updated_at->format('d M, Y H:i') }}</p>
                        </div>
                    </div>

                    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4 bg-slate-50 rounded-lg border border-slate-200">
                            <p class="text-xs text-slate-500 font-bold uppercase">Grand Total Claimed (HCP)</p>
                            <p class="text-2xl font-black text-slate-700">₦{{ number_format($log->hcp_amount_claimed_grandtotal, 2) }}</p>
                        </div>
                        <div class="p-4 bg-indigo-50 rounded-lg border border-indigo-200">
                            <p class="text-xs text-indigo-500 font-bold uppercase">Grand Total Due (Authorized)</p>
                            <p class="text-2xl font-black text-indigo-700">₦{{ number_format($log->hcp_amount_due_grandtotal, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white shadow-sm sm:rounded-xl border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 bg-slate-50 border-b border-slate-200 flex justify-between items-center">
                        <h3 class="text-sm font-bold text-slate-700 uppercase italic">Associated Services</h3>
                        <span class="text-[10px] text-slate-400 font-bold uppercase">Total: {{ $log->services->count() }}</span>
                    </div>
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50/50">
                            <tr class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                <th class="px-6 py-3 text-left">Service Description</th>
                                <th class="px-4 py-3 text-right">Claimed</th>
                                <th class="px-6 py-3 text-right">Due</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-100">
                            @forelse($log->services as $service)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4">
                                    <p class="text-sm text-slate-700 font-medium">{{ $service->service_name }}</p>
                                    @if($service->remarks)
                                        <p class="text-[10px] text-slate-400 italic mt-1 font-mono">Note: {{ $service->remarks }}</p>
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-right text-xs text-slate-400 font-semibold italic">
                                    ₦{{ number_format($service->hcp_amount_claimed_total_services, 2) }}
                                </td>
                                <td class="px-6 py-4 text-right text-sm font-black text-blue-700">
                                    ₦{{ number_format($service->tariff * $service->qty, 2) }}
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="px-6 py-10 text-center text-slate-400 italic text-sm">No services recorded for this PA.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

     <div class="bg-white shadow-sm sm:rounded-xl border border-slate-200 overflow-hidden">
    <div class="px-6 py-4 bg-slate-50 border-b border-slate-200">
        <h3 class="text-sm font-bold text-slate-700 uppercase">Associated Drugs</h3>
    </div>
    <table class="min-w-full divide-y divide-slate-200">
        <thead class="bg-slate-50">
            <tr class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">
                <th class="px-4 py-3 text-left">Drug Item</th>
                <th class="px-4 py-3 text-center">Tariff</th>
                <th class="px-4 py-3 text-center">Qty</th>
                <th class="px-4 py-3 text-right">Claimed (HCP)</th>
                <th class="px-4 py-3 text-right">Due (90%)</th>
                <th class="px-4 py-3 text-center">10% Copay</th>
                <th class="px-4 py-3 text-left">Remarks</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-slate-100">
            @forelse($log->drugs as $drug)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-4 text-sm text-slate-700">
                    {{ $drug->drug_name }}
                </td>

                <td class="px-4 py-4 text-center text-sm text-slate-600 font-mono">
                    ₦{{ number_format($drug->tariff, 2) }}
                </td>

                <td class="px-4 py-4 text-center text-sm text-slate-600">
                    {{ $drug->qty }}
                </td>

                <td class="px-4 py-4 text-right text-sm font-mono text-slate-500">
                    ₦{{ number_format($drug->hcp_amount_claimed_total_drugs, 2) }}
                </td>

                <td class="px-4 py-4 text-right text-sm font-bold text-emerald-700">
                    ₦{{ number_format($drug->tariff * $drug->qty * 0.9, 2) }}
                </td>

                <td class="px-4 py-4 text-center text-sm font-semibold text-red-500 bg-red-50/30">
                    ₦{{ number_format($drug->tariff * $drug->qty * 0.1, 2) }}
                </td>

                <td class="px-4 py-4 text-sm text-slate-500 italic">
                    {{ $drug->remarks ?? 'N/A' }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-10 text-center text-slate-400 text-sm italic">
                    No drug records found for this PA.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
            </div>

            <div class="flex justify-end pt-4">
                <a href="{{ route('bill-management.ud.edit', base64_encode($log->pa_code)) }}" 
                   class="inline-flex items-center px-10 py-4 bg-indigo-600 border border-transparent rounded-xl font-bold text-sm text-white uppercase tracking-widest hover:bg-indigo-700 active:scale-95 shadow-xl transition-all duration-150">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Modify Authorization
                </a>
            </div>
        </div>
    </div>
</x-app-layout>