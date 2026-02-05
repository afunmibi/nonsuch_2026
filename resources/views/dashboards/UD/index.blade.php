<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Underwriter (UD) Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- KEY METRICS GRID -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <!-- Bills Processed -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-slate-100 flex items-center justify-between">
                    <div>
                        <p class="text-xs uppercase font-bold text-slate-400 tracking-wider">Total Bills</p>
                        <h3 class="text-3xl font-black text-slate-800 mt-1">{{ number_format($totalBills) }}</h3>
                        <p class="text-[10px] text-slate-500 font-bold mt-2">All Time</p>
                    </div>
                    <div class="bg-blue-50 text-blue-600 p-4 rounded-xl">
                        <i class="fas fa-file-invoice fa-2x"></i>
                    </div>
                </div>

                <!-- Outstanding -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-slate-100 flex items-center justify-between">
                    <div>
                        <p class="text-xs uppercase font-bold text-slate-400 tracking-wider">Pending Settlement</p>
                        <h3 class="text-3xl font-black text-slate-800 mt-1">{{ number_format($outstandingBills) }}</h3>
                        <p class="text-[10px] text-amber-600 font-bold mt-2">Requires Action</p>
                    </div>
                    <div class="bg-amber-50 text-amber-600 p-4 rounded-xl">
                        <i class="fas fa-clock fa-2x"></i>
                    </div>
                </div>

                <!-- Action Card -->
                <div class="bg-indigo-900 rounded-2xl shadow-lg p-6 text-white text-center">
                    <div class="bg-white/10 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3 text-indigo-400">
                        <i class="fas fa-file-invoice text-xl"></i>
                    </div>
                    <h3 class="font-bold text-lg mb-1">Bill Submissions</h3>
                    <p class="text-indigo-400 text-[10px] mb-4">View and download provider uploads.</p>
                    <a href="{{ route('hcp-uploads.admin') }}" class="bg-indigo-600 hover:bg-indigo-500 text-white py-2 px-4 rounded-lg font-bold text-xs transition inline-flex items-center gap-2">
                        <i class="fas fa-arrow-right"></i> Download Files
                    </a>
                </div>
            </div>

            <!-- Recent Activity List -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                <h3 class="font-bold text-slate-700 mb-4 text-sm uppercase tracking-wider">Recent Activity</h3>
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
</x-app-layout>
