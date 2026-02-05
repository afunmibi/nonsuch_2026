<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Accounts - HCP Payment Disbursement
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto p-4 md:p-6 pb-20">
        <div class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-gray-800 mb-6 flex flex-col md:flex-row items-center gap-4">
            <div class="flex-1">
                <h2 class="text-sm font-bold text-slate-700 uppercase tracking-tight">Payment Workstation</h2>
                <p class="text-[10px] text-slate-500 font-medium">Search PA Code to process final HCP disbursement</p>
            </div>
            <div class="w-full md:w-64">
                <form action="{{ route('bill-management.accounts.index') }}" method="GET" class="flex gap-2">
                    <input type="text" name="pa_code" value="{{ request('pa_code') }}" placeholder="Enter PA Code"
                           class="w-full border-slate-300 rounded-md shadow-sm px-3 py-2 text-sm focus:ring-gray-800 focus:border-gray-800" required>
                    <button type="submit" class="bg-slate-800 hover:bg-black text-white font-bold py-2 px-4 rounded-md text-sm transition shadow-sm">
                        Unlock
                    </button>
                </form>
            </div>
        </div>
        <!-- EXPORT SECTION -->
        <div class="bg-gradient-to-r from-slate-800 to-slate-900 p-6 rounded-2xl shadow-lg border border-slate-700 mb-8 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 p-4 opacity-10">
                <i class="fas fa-file-csv fa-8x"></i>
            </div>
            
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-4">
                    <span class="bg-emerald-500 text-black text-[10px] font-black uppercase px-2 py-1 rounded shadow-sm">Reporting</span>
                    <h3 class="text-lg font-bold">Generate Disbursement Reports</h3>
                </div>
                
                <form action="{{ route('bill-management.accounts.export-csv') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
                    <div class="w-full md:w-48">
                        <label class="text-[10px] uppercase font-bold text-slate-400 mb-1 block">Time Period</label>
                        <select name="period" class="w-full bg-slate-700 border-slate-600 rounded-lg text-sm text-white focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="today">Today</option>
                            <option value="week">This Week</option>
                            <option value="month">This Month</option>
                            <option value="3_months">Last 3 Months</option>
                            <option value="6_months">Last 6 Months</option>
                            <option value="year">Last Year</option>
                            <option value="all">All Time</option>
                        </select>
                    </div>

                    <div class="w-full md:w-64">
                         <label class="text-[10px] uppercase font-bold text-slate-400 mb-1 block">Provider (Optional)</label>
                        <input type="text" name="hcp" placeholder="Filter by HCP Name or Code" 
                               class="w-full bg-slate-700 border-slate-600 rounded-lg text-sm text-white placeholder-slate-400 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>

                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-2.5 px-6 rounded-lg shadow-lg flex items-center gap-2 transition">
                        <i class="fas fa-download"></i>
                        <span>Export CSV</span>
                    </button>
                </form>
            </div>
        </div>

        <div class="flex justify-between items-center mb-4">
            <h3 class="text-sm font-bold text-slate-700 uppercase">Pending Payments</h3>
        </div>



        <div class="bg-white p-4 rounded-lg shadow-sm border border-slate-200">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-[10px] font-bold text-slate-500 uppercase">Beneficiary (HCP)</th>
                        <th class="px-6 py-3 text-left text-[10px] font-bold text-slate-500 uppercase">Bank / Account</th>
                        <th class="px-6 py-3 text-left text-[10px] font-bold text-slate-500 uppercase">PA Code</th>
                        <th class="px-6 py-3 text-left text-[10px] font-bold text-slate-500 uppercase">Final Total</th>
                        <th class="px-6 py-3 text-right text-[10px] font-bold text-slate-500 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse ($billvetting as $bill)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-slate-900">{{ $bill->sec_hcp ?? $bill->pry_hcp }}</div>
                                <div class="text-[10px] text-slate-500">{{ $bill->sec_hcp_code ?? $bill->pry_hcp_code }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-xs font-medium text-slate-700">{{ $bill->sec_hcp_bank_name }}</div>
                                <div class="text-xs font-mono text-indigo-600">{{ $bill->sec_hcp_account_number }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs font-mono text-slate-500">{{ $bill->pa_code }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-black text-slate-900">₦{{ number_format($bill->hcp_amount_due_grandtotal, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm flex items-center justify-end gap-2">
                                <a href="{{ route('bill-management.accounts.summary-pdf', $bill->pa_code) }}" target="_blank" 
                                   class="inline-block bg-slate-50 text-slate-700 px-3 py-1.5 rounded-lg border border-slate-200 hover:bg-slate-600 hover:text-white transition font-bold text-xs" title="Summary Bill">
                                    <i class="fas fa-file-invoice"></i>
                                </a>
                                <a href="{{ route('bill-management.accounts.comprehensive-pdf', $bill->pa_code) }}" target="_blank" 
                                   class="inline-block bg-emerald-50 text-emerald-700 px-3 py-1.5 rounded-lg border border-emerald-200 hover:bg-emerald-600 hover:text-white transition font-bold text-xs" title="Comprehensive Vetting">
                                    <i class="fas fa-file-medical"></i>
                                </a>
                                <form action="{{ route('bill-management.accounts.pay', $bill->pa_code) }}" method="POST" onsubmit="return confirm('Confirm that payment has been made via the bank portal?')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded font-bold text-xs shadow-sm transition">
                                        Mark as Paid
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400 italic text-sm">
                                @if(request('pa_code'))
                                    Record not found or not yet processed by Case Manager.
                                @else
                                    Account Workstation Locked.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAID HISTORY SECTION -->
        <div class="mt-8">
            <h3 class="text-sm font-bold text-slate-700 uppercase mb-4 tracking-tight">Recent Payments (Re-Download Receipts)</h3>
            <div class="bg-white p-4 rounded-lg shadow-sm border border-slate-200">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-[10px] font-bold text-slate-500 uppercase">PA Code</th>
                            <th class="px-6 py-3 text-left text-[10px] font-bold text-slate-500 uppercase">Beneficiary</th>
                            <th class="px-6 py-3 text-left text-[10px] font-bold text-slate-500 uppercase">Paid At</th>
                            <th class="px-6 py-3 text-left text-[10px] font-bold text-slate-500 uppercase">Amount</th>
                            <th class="px-6 py-3 text-right text-[10px] font-bold text-slate-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse($paidBills as $history)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-xs font-mono font-bold text-slate-600">{{ $history->pa_code }}</td>
                            <td class="px-6 py-4">
                                <div class="text-xs font-bold text-slate-800">{{ $history->sec_hcp ?? $history->pry_hcp }}</div>
                                <div class="text-[10px] text-slate-500">{{ $history->sec_hcp_bank_name }} - {{ $history->sec_hcp_account_number }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs text-slate-500">
                                {{ $history->paid_at ? \Carbon\Carbon::parse($history->paid_at)->format('d M Y, h:i A') : 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs font-bold text-emerald-600">
                                ₦{{ number_format($history->hcp_amount_due_grandtotal, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right space-x-2">
                                <a href="{{ route('bill-management.accounts.summary-pdf', $history->pa_code) }}" target="_blank" 
                                   class="text-blue-600 hover:text-blue-900 text-xs font-bold underline">
                                    Summary
                                </a>
                                <span class="text-slate-300">|</span>
                                <a href="{{ route('bill-management.accounts.comprehensive-pdf', $history->pa_code) }}" target="_blank" 
                                   class="text-emerald-600 hover:text-emerald-900 text-xs font-bold underline">
                                    Comp.
                                </a>
                                <span class="text-slate-300">|</span>
                                <a href="{{ route('bill-management.accounts.pdf', $history->pa_code) }}" target="_blank" 
                                   class="text-slate-600 hover:text-slate-900 text-xs font-bold underline">
                                    Voucher
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-slate-400 italic text-xs">No payment history found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>