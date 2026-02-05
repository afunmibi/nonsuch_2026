<x-app-layout>
    <div class="py-12 bg-slate-50">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Replace the previous form in your show.blade.php with this --}}
<div class="flex gap-3">
    <a href="{{ route('bill-management.md.index') }}" class="bg-white border border-slate-300 px-4 py-2 rounded-lg text-sm font-bold text-slate-600">Back</a>
    
    @if($bill->status === 'vetted')
        <form action="{{ route('bill-management.md.approve', $bill->pa_code) }}" method="POST" onsubmit="return confirm('Are you sure you want to authorize this payment?')">
            @csrf
            @method('PATCH')
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg text-sm font-bold shadow-lg transition">
                Authorize Payment
            </button>
        </form>
    @else
        <span class="bg-gray-100 text-gray-500 px-6 py-2 rounded-lg text-sm font-bold border border-gray-200">
            Already {{ strtoupper($bill->status) }}
        </span>
    @endif
</div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200">
                    <p class="text-[10px] font-bold text-slate-400 uppercase">Patient</p>
                    <p class="text-lg font-bold text-slate-800">{{ $bill->full_name }}</p>
                    <p class="text-sm text-slate-500">{{ $bill->policy_no }}</p>
                </div>
                <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200">
                    <p class="text-[10px] font-bold text-slate-400 uppercase">Provider (HCP)</p>
                    <p class="text-sm font-bold text-slate-800">{{ $bill->sec_hcp ?? $bill->pry_hcp }}</p>
                    <p class="text-sm text-slate-500">Month: {{ $bill->billing_month }}</p>
                </div>
                <div class="bg-white p-5 rounded-xl shadow-sm border border-red-100 bg-red-50/30">
                    <p class="text-[10px] font-bold text-red-400 uppercase">Total Amount Due</p>
                    <p class="text-2xl font-black text-red-600">₦{{ number_format($bill->hcp_amount_due_grandtotal, 2) }}</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-4 bg-slate-50 border-b border-slate-200">
                    <h3 class="font-bold text-slate-700">Line Item Breakdown</h3>
                </div>
                
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50/50">
                        <tr>
                            <th class="px-6 py-3 text-left text-[10px] font-bold text-slate-400 uppercase">Description</th>
                            <th class="px-6 py-3 text-center text-[10px] font-bold text-slate-400 uppercase">Qty</th>
                            <th class="px-6 py-3 text-right text-[10px] font-bold text-slate-400 uppercase">Tariff</th>
                            <th class="px-6 py-3 text-right text-[10px] font-bold text-slate-400 uppercase">Total Due</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($services as $service)
                        <tr>
                            <td class="px-6 py-4 text-sm text-slate-700 font-medium">{{ $service->service_name }}</td>
                            <td class="px-6 py-4 text-center text-sm text-slate-600">{{ $service->qty }}</td>
                            <td class="px-6 py-4 text-right text-sm text-slate-600">₦{{ number_format($service->tariff, 2) }}</td>
                            <td class="px-6 py-4 text-right text-sm font-bold text-slate-800">₦{{ number_format($service->hcp_amount_due_total_services, 2) }}</td>
                        </tr>
                        @endforeach

                        @foreach($drugs as $drug)
                        <tr>
                            <td class="px-6 py-4 text-sm text-slate-700 font-medium">{{ $drug->drug_name }} <span class="text-[10px] bg-blue-50 text-blue-600 px-1 rounded ml-1">Drug</span></td>
                            <td class="px-6 py-4 text-center text-sm text-slate-600">{{ $drug->qty }}</td>
                            <td class="px-6 py-4 text-right text-sm text-slate-600">₦{{ number_format($drug->tariff, 2) }}</td>
                            <td class="px-6 py-4 text-right text-sm font-bold text-slate-800">₦{{ number_format($drug->hcp_amount_due_total_drugs, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-slate-50 font-bold">
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-right text-slate-600 uppercase text-xs">Grand Total Verified:</td>
                            <td class="px-6 py-4 text-right text-lg text-red-600">₦{{ number_format($bill->hcp_amount_due_grandtotal, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="mt-4 flex justify-between text-[11px] text-slate-400 italic">
                <span>Vetted by: {{ $bill->vetted_by }}</span>
                <span>Date Processed: {{ $bill->created_at->format('M d, Y H:i') }}</span>
            </div>
        </div>
    </div>
</x-app-layout>