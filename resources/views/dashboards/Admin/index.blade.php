<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Executive Dashboard') }}
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

            <!-- MANAGEMENT TIER ACCESS -->
            <div class="space-y-4">
                <h3 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em] flex items-center gap-2">
                    <i class="fas fa-layer-group text-indigo-500"></i>
                    Management Tier Hub
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                    <!-- UD -->
                    <a href="{{ route('bill-management.ud.index') }}" class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:border-indigo-200 transition-all group">
                        <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600 mb-3 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <p class="text-xs font-bold text-slate-800">UD Underwriter</p>
                        <p class="text-[10px] text-slate-400 mt-1">First-level vetting review</p>
                    </a>

                    <!-- GM -->
                    <a href="{{ route('bill-management.gm.index') }}" class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:border-emerald-200 transition-all group">
                        <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600 mb-3 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <p class="text-xs font-bold text-slate-800">GM Management</p>
                        <p class="text-[10px] text-slate-400 mt-1">Executive oversight & audit</p>
                    </a>

                    <!-- MD -->
                    <a href="{{ route('bill-management.md.index') }}" class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:border-rose-200 transition-all group">
                        <div class="w-10 h-10 bg-rose-50 rounded-xl flex items-center justify-center text-rose-600 mb-3 group-hover:bg-rose-600 group-hover:text-white transition-colors">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <p class="text-xs font-bold text-slate-800">MD Approval</p>
                        <p class="text-[10px] text-slate-400 mt-1">Final medical authorization</p>
                    </a>

                    <!-- CM -->
                    <a href="{{ route('bill-management.cm.index') }}" class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:border-amber-200 transition-all group">
                        <div class="w-10 h-10 bg-amber-50 rounded-xl flex items-center justify-center text-amber-600 mb-3 group-hover:bg-amber-600 group-hover:text-white transition-colors">
                            <i class="fas fa-tasks"></i>
                        </div>
                        <p class="text-xs font-bold text-slate-800">CM Review</p>
                        <p class="text-[10px] text-slate-400 mt-1">Case & financial processing</p>
                    </a>

                    <!-- Accounts -->
                    <a href="{{ route('bill-management.accounts.index') }}" class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:border-blue-200 transition-all group">
                        <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600 mb-3 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                            <i class="fas fa-file-invoice-dollar"></i>
                        </div>
                        <p class="text-xs font-bold text-slate-800">Accounts Dept</p>
                        <p class="text-[10px] text-slate-400 mt-1">Disbursement & Settlement</p>
                    </a>
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

                <!-- Export & Quick Actions -->
                <div class="space-y-6">
                    <!-- Export Card -->
                    <div class="bg-slate-900 rounded-2xl shadow-lg p-6 text-white text-center">
                        <div class="bg-white/10 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 text-emerald-400">
                            <i class="fas fa-cloud-download-alt text-2xl"></i>
                        </div>
                        <h3 class="font-bold text-lg mb-2">Export Data</h3>
                        <p class="text-slate-400 text-xs mb-6 px-4">Download comprehensive reports for Enrolments, Bills, and User Activity in CSV format.</p>
                        
                        <div class="grid grid-cols-1 gap-3">
                            <a href="{{ route('bill-management.cm.export') }}?period=month" class="bg-emerald-600 hover:bg-emerald-500 text-white py-3 rounded-xl font-bold text-sm transition flex items-center justify-center gap-2">
                                <i class="fas fa-file-csv"></i> Monthly Financial Report
                            </a>
                            <button disabled class="bg-white/10 text-white/50 py-3 rounded-xl font-bold text-sm cursor-not-allowed">
                                <i class="fas fa-users"></i> Export Enrollee DB
                            </button>
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