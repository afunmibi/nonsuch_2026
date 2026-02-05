<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Medical Director - Executive Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- KEY METRICS GRID -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Enrolments -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-slate-100 flex items-center justify-between">
                    <div>
                        <p class="text-xs uppercase font-bold text-slate-400 tracking-wider">Total Enrolments</p>
                        <h3 class="text-3xl font-black text-slate-800 mt-1">{{ number_format($totalEnrolments) }}</h3>
                        <p class="text-[10px] text-green-600 font-bold mt-2"><i class="fas fa-arrow-up"></i> Active Policy Holders</p>
                    </div>
                    <div class="bg-indigo-50 text-indigo-600 p-4 rounded-xl">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                </div>

                <!-- Bills Processed -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-slate-100 flex items-center justify-between">
                    <div>
                        <p class="text-xs uppercase font-bold text-slate-400 tracking-wider">Bills Processed</p>
                        <h3 class="text-3xl font-black text-slate-800 mt-1">{{ number_format($totalBills) }}</h3>
                        <p class="text-[10px] text-slate-500 font-bold mt-2">
                             <span class="text-emerald-600">{{ $paidBills }} Paid</span> • <span class="text-amber-500">{{ $outstandingBills }} Pending</span>
                        </p>
                    </div>
                    <div class="bg-blue-50 text-blue-600 p-4 rounded-xl">
                        <i class="fas fa-file-invoice-dollar fa-2x"></i>
                    </div>
                </div>

                <!-- Financials: Claims -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-slate-100 flex items-center justify-between">
                    <div>
                        <p class="text-xs uppercase font-bold text-slate-400 tracking-wider">Total Claims</p>
                        <h3 class="text-2xl font-black text-slate-800 mt-1">₦{{ number_format($totalClaimedAmount / 1000000, 2) }}M</h3>
                         <p class="text-[10px] text-slate-400 font-bold mt-2">Gross HCP Claims</p>
                    </div>
                    <div class="bg-orange-50 text-orange-600 p-4 rounded-xl">
                        <i class="fas fa-hand-holding-usd fa-2x"></i>
                    </div>
                </div>

                <!-- Financials: Paid -->
                <div class="bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-2xl shadow-lg p-6 text-white flex items-center justify-between">
                    <div>
                        <p class="text-xs uppercase font-bold text-emerald-200 tracking-wider">Total Settled</p>
                        <h3 class="text-2xl font-black text-white mt-1">₦{{ number_format($totalPaidAmount / 1000000, 2) }}M</h3>
                        <p class="text-[10px] text-emerald-100 font-bold mt-2">Verified & Paid Out</p>
                    </div>
                    <div class="bg-white/20 p-4 rounded-xl text-white">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                </div>
            </div>

            <!-- CHART & RECENT ACTIVITY -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Analytics Chart -->
                <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="font-bold text-slate-700">Financial Overview (Paid vs Outstanding)</h3>
                        <button class="text-xs font-bold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full">This Year</button>
                    </div>
                    <!-- Chart Placeholder -->
                    <div class="relative h-64 w-full bg-slate-50 rounded-xl flex items-center justify-center border border-dashed border-slate-200">
                        <canvas id="financialChart"></canvas>
                    </div>
                </div>

                <!-- Actions Panel -->
                <div class="space-y-6">
                    <!-- Quick Actions Card (MD Specific) -->
                    <div class="bg-slate-900 rounded-2xl shadow-lg p-6 text-white text-center">
                        <div class="bg-white/10 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 text-emerald-400">
                            <i class="fas fa-user-md text-2xl"></i>
                        </div>
                        <h3 class="font-bold text-lg mb-2">Clinical Oversight</h3>
                        <p class="text-slate-400 text-xs mb-6 px-4">Review pending bills and authorize high-value claims.</p>
                        
                        <div class="grid grid-cols-1 gap-3">
                            <a href="{{ route('bill-management.md.index') }}" class="bg-blue-600 hover:bg-blue-500 text-white py-3 rounded-xl font-bold text-sm transition flex items-center justify-center gap-2">
                                <i class="fas fa-check-double"></i> Pending Authorizations
                            </a>
                        </div>
                    </div>

                    <!-- Recent Activity List -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                        <h3 class="font-bold text-slate-700 mb-4 text-sm uppercase tracking-wider">Recent Transactions</h3>
                        <div class="space-y-4">
                            @foreach($recentBills as $bill)
                            <div class="flex items-center justify-between border-b border-slate-50 pb-3 last:border-0 last:pb-0">
                                <div>
                                    <p class="text-xs font-bold text-slate-800">{{ $bill->pa_code }}</p>
                                    <p class="text-[10px] text-slate-500">{{ $bill->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs font-bold {{ $bill->status == 'paid' ? 'text-emerald-600' : 'text-amber-600' }}">
                                        {{ ucfirst($bill->status) }}
                                    </p>
                                    <p class="text-[10px] font-mono text-slate-400">₦{{ number_format($bill->hcp_amount_due_grandtotal) }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Chart.js Integration -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('financialChart');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Paid Bills', 'Outstanding Bills'],
                datasets: [{
                    label: '# of Bills',
                    data: [{{ $paidBills }}, {{ $outstandingBills }}],
                    backgroundColor: [
                        'rgba(16, 185, 129, 0.2)',
                        'rgba(245, 158, 11, 0.2)'
                    ],
                    borderColor: [
                        'rgb(16, 185, 129)',
                        'rgb(245, 158, 11)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>
</x-app-layout>
