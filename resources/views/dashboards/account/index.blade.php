<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Account Dashboard
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Stats Cards -->
            <div class="flex flex-wrap gap-4">
                <!-- Pending Invoices -->
                <div class="bg-white overflow-hidden shadow rounded-lg w-40">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2-1.343-2-3-2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1l-2.5 2.5M14.599 3c1.11 0 2.08.402 2.599 1M14.599 3L12 4.401M14.599 3V2m0 1c1.11 0 2.08.402 2.599 1"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Pending Invoices</dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl font-semibold text-gray-900">{{ $stats['pending_invoices'] }}</div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Paid This Month -->
                <div class="bg-white overflow-hidden shadow rounded-lg w-40">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2-1.343-2-3-2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1l-2.5 2.5M14.599 3c1.11 0 2.08.402 2.599 1M14.599 3L12 4.401M14.599 3V2m0 1c1.11 0 2.08.402 2.599 1"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Paid This Month</dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl font-semibold text-gray-900">{{ number_format($stats['paid_this_month'], 2) }}</div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total HCPs -->
                <div class="bg-white overflow-hidden shadow rounded-lg w-40">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total HCPs</dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl font-semibold text-gray-900">{{ $stats['total_hcps'] }}</div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Active Contracts -->
                <div class="bg-white overflow-hidden shadow rounded-lg w-40">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Active Contracts</dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl font-semibold text-gray-900">{{ $stats['active_contracts'] }}</div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Invoices -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Recent Invoices</h3>
                    <div class="mt-5">
                        @if($recentInvoices->count() > 0)
                            <div class="flex flex-col">
                                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                        <div class="overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                            <table class="min-w-full divide-y divide-gray-200">
                                                <thead class="bg-gray-50">
                                                    <tr>
                                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">PA Code</th>
                                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($recentInvoices as $invoice)
                                                        <tr class="hover:bg-gray-50">
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $invoice->pa_code }}</td>
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $invoice->amount_due ?? 'N/A' }}</td>
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $invoice->payment_status ?? 'Pending' }}</td>
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $invoice->created_at->format('M j, Y') }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <p class="text-gray-500">No invoices found.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>