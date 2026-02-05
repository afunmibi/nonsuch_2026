<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('HCP Dashboard') }}
            </h2>
            <a href="{{ route('hcp-uploads.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg font-bold shadow-lg hover:bg-indigo-700 transition">
                <i class="fas fa-cloud-upload-alt mr-2"></i> Upload Bill
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <!-- STATS GRID -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Total Uploads -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 flex items-center justify-between">
                    <div>
                        <p class="text-xs uppercase font-bold text-gray-400 tracking-wider">Total Uploads</p>
                        <h3 class="text-3xl font-black text-gray-800 mt-1">{{ number_format($totalUploads) }}</h3>
                        <p class="text-[10px] text-gray-400 font-bold mt-2">Submitted Bills</p>
                    </div>
                    <div class="bg-blue-50 text-blue-600 p-4 rounded-xl">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" /></svg>
                    </div>
                </div>

                <!-- Pending Status -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 flex items-center justify-between">
                    <div>
                        <p class="text-xs uppercase font-bold text-gray-400 tracking-wider">Pending Vetting</p>
                        <h3 class="text-3xl font-black text-amber-500 mt-1">{{ number_format($pendingUploads) }}</h3>
                        <p class="text-[10px] text-gray-400 font-bold mt-2">Awaiting Processing</p>
                    </div>
                    <div class="bg-amber-50 text-amber-500 p-4 rounded-xl">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                </div>

                <!-- Verified/Paid (Placeholder logic if needed later) -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 flex items-center justify-between">
                    <div>
                        <p class="text-xs uppercase font-bold text-gray-400 tracking-wider">Verified & Paid</p>
                        <h3 class="text-3xl font-black text-emerald-600 mt-1">{{ number_format($totalUploads - $pendingUploads) }}</h3>
                        <p class="text-[10px] text-gray-400 font-bold mt-2">Completed</p>
                    </div>
                    <div class="bg-emerald-50 text-emerald-600 p-4 rounded-xl">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                </div>
            </div>

            <!-- RECENT UPLOADS TABLE -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-800 mb-6">Recent Bill Submissions</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-gray-100">
                                <th class="pb-3 text-xs font-black uppercase text-gray-400 tracking-widest text-left">Period</th>
                                <th class="pb-3 text-xs font-black uppercase text-gray-400 tracking-widest text-left">HMO Officer</th>
                                <th class="pb-3 text-xs font-black uppercase text-gray-400 tracking-widest text-left">Amount Claimed</th>
                                <th class="pb-3 text-xs font-black uppercase text-gray-400 tracking-widest text-center">Status</th>
                                <th class="pb-3 text-xs font-black uppercase text-gray-400 tracking-widest text-right">Submitted</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($recentUploads as $upload)
                            <tr class="group hover:bg-gray-50 transition">
                                <td class="py-4 font-bold text-gray-700">{{ $upload->billing_month }}</td>
                                <td class="py-4 text-sm text-gray-600">{{ $upload->hmo_officer ?? 'N/A' }}</td>
                                <td class="py-4 font-mono font-bold text-slate-800">₦{{ number_format($upload->amount_claimed, 2) }}</td>
                                <td class="py-4 text-center">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider
                                        {{ $upload->status == 'Pending' ? 'bg-amber-100 text-amber-700' : 'bg-green-100 text-green-700' }}">
                                        {{ $upload->status }}
                                    </span>
                                </td>
                                <td class="py-4 text-right text-xs text-gray-400 font-mono">
                                    {{ $upload->created_at->format('M d, Y h:i A') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-gray-400 italic">No uploads found. Claim your bills now.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
