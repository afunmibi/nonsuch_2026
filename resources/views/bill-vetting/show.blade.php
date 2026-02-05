<x-app-layout>
    <div class="max-w-7xl mx-auto p-4 md:p-6 space-y-6">
        
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-gradient-to-r from-indigo-50 to-blue-50 p-6 rounded-2xl border-2 border-indigo-200 shadow-lg">
            <div>
                <h1 class="text-2xl font-black text-indigo-900 mb-1">Bill Vetting Details</h1>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-indigo-600 uppercase tracking-wider">PA Code:</span>
                    <span class="text-lg font-mono font-black text-indigo-700 bg-white px-3 py-1 rounded-lg border border-indigo-200">{{ $log->pa_code }}</span>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div x-data="{ 
                    copyLink() {
                        const link = '{{ route('feedback.create', ['pa_code' => $log->pa_code, 'policy_no' => $log->policy_no]) }}';
                        navigator.clipboard.writeText(link).then(() => {
                            $dispatch('notify', { message: 'Feedback Link Copied!', type: 'success' });
                        });
                    }
                }">
                    <button @click="copyLink" 
                       class="inline-flex items-center gap-2 bg-emerald-600 text-white hover:bg-emerald-700 px-6 py-3 rounded-xl font-bold transition-all shadow-md hover:shadow-lg">
                        <i class="fas fa-copy"></i>
                        Copy Feedback Link
                    </button>
                </div>

                <a href="{{ route('bill-vetting.index') }}" 
                   class="inline-flex items-center gap-2 bg-white border-2 border-indigo-200 text-indigo-600 hover:bg-indigo-600 hover:text-white px-6 py-3 rounded-xl font-bold transition-all shadow-md hover:shadow-lg">
                    <i class="fas fa-arrow-left"></i>
                    Back to Portal
                </a>
            </div>
        </div>

        <!-- Patient & Clinical Info Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Patient Details Card -->
            <div class="bg-white rounded-2xl shadow-xl border-2 border-slate-200 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b-2 border-slate-200">
                    <h3 class="text-sm font-bold text-indigo-900 uppercase tracking-wide flex items-center gap-2">
                        <i class="fas fa-user-circle text-indigo-500"></i>
                        Patient Information
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Full Name</label>
                        <p class="text-lg font-bold text-slate-900">{{ $log->full_name }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Policy Number</label>
                        <p class="text-sm font-mono font-bold text-indigo-600 bg-indigo-50 px-3 py-2 rounded-lg inline-block">{{ $log->policy_no }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Provider</label>
                        <p class="text-sm font-semibold text-slate-700">{{ $log->pry_hcp ?? 'N/A' }}</p>
                    </div>

                    @if($log->monitoring)
                    <div class="pt-4 border-t border-slate-100">
                        <a href="{{ route('monitoring.show', $log->monitoring->id) }}" target="_blank"
                           class="flex items-center justify-center gap-2 p-3 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-700 hover:bg-emerald-100 transition-all font-bold text-xs ring-4 ring-emerald-50/50">
                            <i class="fas fa-notes-medical animate-pulse"></i>
                            VIEW CLINICAL MONITORING
                            <span class="bg-emerald-200 px-2 py-0.5 rounded text-[10px]">{{ $log->monitoring->monitoring_status }}</span>
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Clinical Information Card -->
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-xl border-2 border-slate-200 overflow-hidden">
                <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-4 border-b-2 border-slate-200">
                    <h3 class="text-sm font-bold text-emerald-900 uppercase tracking-wide flex items-center gap-2">
                        <i class="fas fa-stethoscope text-emerald-500"></i>
                        Clinical Information
                    </h3>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-2 flex items-center gap-1">
                            <i class="fas fa-diagnoses text-xs"></i>
                            Diagnosis
                        </label>
                        <p class="text-sm text-slate-700 leading-relaxed">{{ $log->diagnosis ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-2 flex items-center gap-1">
                            <i class="fas fa-notes-medical text-xs"></i>
                            Treatment Plan
                        </label>
                        <p class="text-sm text-slate-700 leading-relaxed">{{ $log->treatment_plan ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-2 flex items-center gap-1">
                            <i class="fas fa-microscope text-xs"></i>
                            Investigation
                        </label>
                        <p class="text-sm text-slate-700 leading-relaxed">{{ $log->further_investigation ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Services Table -->
        <div class="bg-white rounded-2xl shadow-xl border-2 border-slate-200 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b-2 border-slate-200 flex justify-between items-center">
                <h3 class="text-sm font-bold text-indigo-900 uppercase tracking-wide flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-blue-500 shadow-lg shadow-blue-300 animate-pulse"></span>
                    Medical Services
                </h3>
                <span class="text-xs font-bold text-indigo-600 bg-white px-3 py-1.5 rounded-lg border border-indigo-200">
                    {{ $log->services->count() }} {{ Str::plural('item', $log->services->count()) }}
                </span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-b from-slate-50 to-slate-100 border-b-2 border-slate-200">
                            <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Service Name</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Rate</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Qty</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Claimed</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Remarks</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($log->services as $service)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 text-sm font-medium text-slate-900">{{ $service->service_name }}</td>
                                <td class="px-6 py-4 text-center text-sm font-mono text-slate-700">₦{{ number_format($service->tariff ?? 0, 2) }}</td>
                                <td class="px-6 py-4 text-center text-sm font-bold text-slate-700">{{ $service->qty ?? 0 }}</td>
                                <td class="px-6 py-4 text-right text-sm font-bold text-indigo-600">₦{{ number_format(($service->tariff ?? 0) * ($service->qty ?? 0), 2) }}</td>
                                <td class="px-6 py-4 text-right text-sm font-bold text-emerald-600">₦{{ number_format($service->hcp_amount_claimed_total_services ?? 0, 2) }}</td>
                                <td class="px-6 py-4 text-sm text-slate-500 italic">{{ $service->remarks ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <i class="fas fa-notes-medical text-4xl text-slate-200 mb-3 block"></i>
                                    <p class="text-slate-400 text-sm font-medium italic">No services recorded</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if($log->services->count() > 0)
                    <tfoot class="bg-gradient-to-r from-slate-50 to-slate-100 border-t-2 border-slate-300">
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-right font-bold text-slate-700 uppercase text-sm">Total Services:</td>
                            <td class="px-6 py-4 text-right font-black text-indigo-600 text-lg">
                                ₦{{ number_format($log->services->sum(fn($s) => ($s->tariff ?? 0) * ($s->qty ?? 0)), 2) }}
                            </td>
                            <td class="px-6 py-4 text-right font-black text-emerald-600 text-lg">
                                ₦{{ number_format($log->services->sum('hcp_amount_claimed_total_services'), 2) }}
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>
        </div>

        <!-- Drugs Table -->
        <div class="bg-white rounded-2xl shadow-xl border-2 border-slate-200 overflow-hidden">
            <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-4 border-b-2 border-slate-200 flex justify-between items-center">
                <h3 class="text-sm font-bold text-emerald-900 uppercase tracking-wide flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 shadow-lg shadow-emerald-300 animate-pulse"></span>
                    Drugs & Consumables
                </h3>
                <span class="text-xs font-bold text-emerald-600 bg-white px-3 py-1.5 rounded-lg border border-emerald-200">
                    {{ $log->drugs->count() }} {{ Str::plural('item', $log->drugs->count()) }}
                </span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-b from-slate-50 to-slate-100 border-b-2 border-slate-200">
                            <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Drug Name</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Rate</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Qty</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Net (90%)</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Copay (10%)</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Claimed</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Remarks</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($log->drugs as $drug)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 text-sm font-medium text-slate-900">{{ $drug->drug_name }}</td>
                                <td class="px-6 py-4 text-center text-sm font-mono text-slate-700">₦{{ number_format($drug->tariff ?? 0, 2) }}</td>
                                <td class="px-6 py-4 text-center text-sm font-bold text-slate-700">{{ $drug->qty ?? 0 }}</td>
                                <td class="px-6 py-4 text-right text-sm font-bold text-indigo-600">₦{{ number_format(($drug->tariff ?? 0) * ($drug->qty ?? 0) * 0.9, 2) }}</td>
                                <td class="px-6 py-4 text-right text-sm font-bold text-orange-500">₦{{ number_format(($drug->tariff ?? 0) * ($drug->qty ?? 0) * 0.1, 2) }}</td>
                                <td class="px-6 py-4 text-right text-sm font-bold text-emerald-600">₦{{ number_format($drug->hcp_amount_claimed_total_drugs ?? 0, 2) }}</td>
                                <td class="px-6 py-4 text-sm text-slate-500 italic">{{ $drug->remarks ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <i class="fas fa-capsules text-4xl text-slate-200 mb-3 block"></i>
                                    <p class="text-slate-400 text-sm font-medium italic">No drugs recorded</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if($log->drugs->count() > 0)
                    <tfoot class="bg-gradient-to-r from-slate-50 to-slate-100 border-t-2 border-slate-300">
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-right font-bold text-slate-700 uppercase text-sm">Total Drugs:</td>
                            <td class="px-6 py-4 text-right font-black text-indigo-600 text-lg">
                                ₦{{ number_format($log->drugs->sum(fn($d) => ($d->tariff ?? 0) * ($d->qty ?? 0) * 0.9), 2) }}
                            </td>
                            <td class="px-6 py-4 text-right font-black text-orange-500 text-lg">
                                ₦{{ number_format($log->drugs->sum(fn($d) => ($d->tariff ?? 0) * ($d->qty ?? 0) * 0.1), 2) }}
                            </td>
                            <td class="px-6 py-4 text-right font-black text-emerald-600 text-lg">
                                ₦{{ number_format($log->drugs->sum('hcp_amount_claimed_total_drugs'), 2) }}
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>
        </div>

        <!-- Summary & Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Financial Summary -->
            <div class="bg-gradient-to-br from-indigo-50 to-blue-50 rounded-2xl p-6 border-2 border-indigo-200 shadow-lg">
                <h3 class="text-sm font-bold text-indigo-900 uppercase tracking-wide mb-4 flex items-center gap-2">
                    <i class="fas fa-calculator text-indigo-500"></i>
                    Financial Summary
                </h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-slate-600">Total Approved:</span>
                        <span class="text-lg font-black text-indigo-600">₦{{ number_format($log->hcp_amount_due_grandtotal ?? 0, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-slate-600">Total Claimed:</span>
                        <span class="text-lg font-black text-emerald-600">₦{{ number_format($log->hcp_amount_claimed_grandtotal ?? 0, 2) }}</span>
                    </div>
                    <hr class="border-indigo-200">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-bold text-slate-700">Billing Month:</span>
                        <span class="text-sm font-bold text-slate-900">{{ $log->billing_month ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-bold text-slate-700">Adm. Date:</span>
                        <span class="text-sm font-bold text-slate-900">{{ $log->admission_date ? \Carbon\Carbon::parse($log->admission_date)->format('d M, Y') : 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-bold text-slate-700">Dis. Date:</span>
                        <span class="text-sm font-bold text-slate-900">{{ $log->discharge_date ? \Carbon\Carbon::parse($log->discharge_date)->format('d M, Y') : 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-bold text-slate-700">Admission Days:</span>
                        <span class="text-sm font-bold text-slate-900">{{ $log->admission_days ?? 0 }} days</span>
                    </div>
                </div>
            </div>

            <!-- Vetting Status -->
            <div class="bg-white rounded-2xl p-6 border-2 border-slate-200 shadow-lg">
                <h3 class="text-sm font-bold text-slate-700 uppercase tracking-wide mb-4 flex items-center gap-2">
                    <i class="fas fa-check-circle text-slate-500"></i>
                    Vetting Status
                </h3>
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full {{ $log->vetted_by ? 'bg-green-100 text-green-600' : 'bg-slate-100 text-slate-400' }} flex items-center justify-center">
                            <i class="fas {{ $log->vetted_by ? 'fa-check' : 'fa-clock' }}"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase">Staff Vetting</p>
                            <p class="text-sm font-bold text-slate-700">{{ $log->vetted_by ?? 'Pending' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full {{ $log->checked_by ? 'bg-green-100 text-green-600' : 'bg-slate-100 text-slate-400' }} flex items-center justify-center">
                            <i class="fas {{ $log->checked_by ? 'fa-check' : 'fa-clock' }}"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase">UD Check</p>
                            <p class="text-sm font-bold text-slate-700">{{ $log->checked_by ?? 'Pending' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-end">
            <a href="{{ route('bill-vetting.index') }}" 
               class="inline-flex items-center justify-center gap-2 bg-white border-2 border-slate-200 text-slate-600 hover:bg-slate-50 px-8 py-4 rounded-xl font-bold transition-all shadow-md">
                <i class="fas fa-times"></i>
                Close
            </a>
            @if(!$log->vetted_by)
            <a href="{{ route('bill-vetting.edit', base64_encode($log->pa_code)) }}" 
               class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-indigo-600 to-blue-600 text-white hover:from-indigo-700 hover:to-blue-700 px-8 py-4 rounded-xl font-bold transition-all shadow-lg hover:shadow-xl">
                <i class="fas fa-edit"></i>
                Start Vetting
            </a>
            @endif
        </div>

    </div>
</x-app-layout>