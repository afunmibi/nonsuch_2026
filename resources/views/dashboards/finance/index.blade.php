<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Finance Dashboard
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Stats Cards -->
            <div class="flex flex-wrap gap-4">
                <!-- Total Revenue -->
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
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Revenue</dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total_revenue'], 2) }}</div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Revenue This Month -->
                <div class="bg-white overflow-hidden shadow rounded-lg w-40">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">This Month</dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl font-semibold text-gray-900">{{ number_format($stats['revenue_this_month'], 2) }}</div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Payments -->
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
                                    <dt class="text-sm font-medium text-gray-500 truncate">Pending Payments</dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl font-semibold text-gray-900">{{ $stats['pending_payments'] }}</div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Expenses -->
                <div class="bg-white overflow-hidden shadow rounded-lg w-40">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Expenses</dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total_expenses'], 2) }}</div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Financial Summary -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Financial Summary</h3>
                    <div class="mt-5 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-green-50 p-4 rounded-lg">
                            <p class="text-sm text-green-800 font-medium">Net Profit</p>
                            <p class="text-2xl font-bold text-green-900">{{ number_format($stats['total_revenue'] - $stats['total_expenses'], 2) }}</p>
                        </div>
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <p class="text-sm text-blue-800 font-medium">Monthly Growth</p>
                            <p class="text-2xl font-bold text-blue-900">+12.5%</p>
                        </div>
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <p class="text-sm text-purple-800 font-medium">Projected Annual</p>
                            <p class="text-2xl font-bold text-purple-900">{{ number_format($stats['revenue_this_month'] * 12, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>