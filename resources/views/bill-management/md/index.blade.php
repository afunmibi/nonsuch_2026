<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            MD Authorization - Clinical Executive Portal
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto p-4 md:p-6 pb-20">
        <div class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-red-600 mb-6 flex flex-col md:flex-row items-center gap-4">
            <div class="flex-1">
                <h2 class="text-sm font-bold text-slate-700 uppercase tracking-tight">MD Authorization Station</h2>
                <p class="text-[10px] text-slate-500 font-medium">Search PA Code to provide final clinical authorization</p>
            </div>
            <div class="w-full md:w-64">
                <form action="{{ route('bill-management.md.index') }}" method="GET" class="flex gap-2">
                    <input type="text" name="pa_code" value="{{ request('pa_code') }}" placeholder="Enter PA Code"
                           class="w-full border border-slate-300 rounded-md shadow-sm px-3 py-2 text-sm focus:ring-red-500 focus:border-red-500" required>
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-md text-sm transition shadow-sm">
                        Unlock
                    </button>
                </form>
            </div>
        </div>

        <div class="bg-white p-4 rounded-lg shadow-sm border border-slate-200">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">PA Code</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Checked (UD)</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Re-Checked (GM)</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Final Amount</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse ($billvetting as $bill)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-mono font-bold text-slate-900">{{ $bill->pa_code }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs text-slate-600">{{ $bill->checked_by }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs font-bold text-green-600 uppercase italic">{{ $bill->re_checked_by }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-red-600">₦{{ number_format($bill->hcp_amount_due_grandtotal, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                <a href="{{ route('bill-management.md.edit', base64_encode($bill->pa_code)) }}" 
                                   class="inline-block bg-red-50 text-red-700 px-4 py-2 rounded-lg border border-red-200 hover:bg-red-600 hover:text-white transition font-bold">
                                    Authorize Bill
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500 italic text-sm">
                                @if(request('pa_code'))
                                    Record not found or not yet re-checked by General Manager.
                                @else
                                    Enter PA Code to begin Medical Director Authorization.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>