<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-bold leading-tight text-gray-900">
                {{ __('Medical Log Requests') }}
            </h2>
            <a href="{{ route('logRequests.create') }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition ease-in-out duration-150 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                New Request
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Flash Messages --}}
            @if (session('success'))
                <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 px-4 py-4 rounded-r-lg mb-6 shadow-sm transition-all duration-300">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <p class="font-bold">Action Successful</p>
                    </div>
                    <p class="mt-1 text-sm">{{ session('success') }}</p>

                    @if (session('pa_code'))
                        <div class="mt-3 p-3 bg-white border border-emerald-200 rounded-lg flex justify-between items-center shadow-inner">
                            <div>
                                <span class="text-[10px] uppercase text-gray-400 block font-bold">Generated PA Code</span>
                                <code class="text-lg font-mono font-bold text-emerald-700" id="paCode">{{ session('pa_code') }}</code>
                            </div>
                            <button onclick="copyToClipboard()" class="flex items-center space-x-1 text-xs bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-2 rounded-md transition font-semibold">
                                <span id="copyText">Copy Code</span>
                            </button>
                        </div>
                    @endif
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Policy Info</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">HCP Details</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Medical Case</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Authorization</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($logRequests as $log)
                                <tr class="hover:bg-gray-50/80 transition duration-150">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-bold text-gray-900">{{ $log->full_name }}</div>
                                        <div class="text-xs text-gray-500 font-mono">{{ $log->policy_no }}</div>
                                        <span class="mt-1 inline-block px-2 py-0.5 rounded text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-100 uppercase tracking-tight">
                                            {{ $log->package_code }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-xs">
                                        <div class="font-medium text-gray-700 leading-relaxed">
                                            <span class="text-gray-400 font-bold uppercase text-[9px]">Pry HCP: {{ $log->pry_hcp }}</span> <span>/: {{ $log->pry_hcp_code }}</span>

                                        </div>
                                        <div class="font-medium text-indigo-700 mt-1 leading-relaxed">
                                            <span class="text-gray-400 font-bold uppercase text-[9px]">Sec HCP: {{ $log->sec_hcp }}</span><span>/: {{ $log->sec_hcp_code }}</span></span>

                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="text-xs font-bold text-red-600 truncate max-w-[180px]" title="{{ $log->diagnosis }}">
                                           <span>Diag:/</span> {{ $log->diagnosis }}
                                        </div>
                                        <div class="text-[11px] text-gray-500 italic mt-1 truncate max-w-[180px]">
                                           <span>treatment_plan:/ </span> {{ $log->treatment_plan }}
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusClasses = [
                                                'approved' => 'bg-emerald-100 text-emerald-800',
                                                'rejected' => 'bg-red-100 text-red-800',
                                                'pending'  => 'bg-amber-100 text-amber-800',
                                            ][$log->pa_code_status] ?? 'bg-gray-100 text-gray-800';
                                            
                                            $dotClasses = [
                                                'approved' => 'bg-emerald-500',
                                                'rejected' => 'bg-red-500',
                                                'pending'  => 'bg-amber-500',
                                            ][$log->pa_code_status] ?? 'bg-gray-500';
                                        @endphp

                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $statusClasses }}">
                                            <span class="w-1 h-1 mr-1.5 rounded-full {{ $dotClasses }}"></span>
                                            {{ strtoupper($log->pa_code_status) }}
                                        </span>

                                        @if($log->pa_code_status === 'approved')
                                            <div class="text-[10px] font-mono font-bold text-gray-400 mt-1 tracking-tighter">
                                                {{ $log->pa_code ?? 'NO CODE' }}
                                            </div>
                                        @endif
                                        <div class="text-[9px] text-gray-400 mt-1 font-medium italic uppercase">
                                            {{ $log->created_at->format('d M, H:i') }}
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <div class="flex items-center justify-center space-x-2">
                                            @if ($log->pa_code_status === 'pending')
                                                <form action="{{ route('logRequests.approve', $log->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1.5 rounded shadow-sm text-[10px] font-bold uppercase transition">
                                                        Approve
                                                    </button>
                                                </form>

                                                <form id="reject-form-{{ $log->id }}" action="{{ route('logRequests.reject', $log->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <input type="hidden" name="rejection_reason" id="reason-{{ $log->id }}">
                                                    <button type="button" onclick="triggerReject({{ $log->id }})" class="bg-white border border-red-200 text-red-600 hover:bg-red-50 px-3 py-1.5 rounded text-[10px] font-bold uppercase transition">
                                                        Reject
                                                    </button>
                                                </form>
                                            @elseif ($log->pa_code)
                                                <a href="{{ route('bill-vetting.show', base64_encode($log->pa_code)) }}" 
                                                   class="bg-indigo-50 text-indigo-600 border border-indigo-200 hover:bg-indigo-600 hover:text-white px-3 py-1.5 rounded text-[10px] font-bold uppercase transition shadow-sm">
                                                    View
                                                </a>
                                                <a href="{{ route('bill-vetting.delete', base64_encode($log->pa_code)) }}" 
                                                   onclick="return confirm('Are you sure you want to delete this record?')"
                                                   class="bg-white border border-red-200 text-red-500 hover:bg-red-600 hover:text-white px-3 py-1.5 rounded text-[10px] font-bold uppercase transition shadow-sm">
                                                    Delete
                                                </a>
                                            @else
                                                <span class="text-[10px] text-red-400 font-bold italic tracking-tight">DATA UNAVAILABLE</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-20 text-center">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <p class="text-gray-500 text-sm font-medium">No medical log requests found.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard() {
            const code = document.getElementById('paCode').innerText;
            navigator.clipboard.writeText(code).then(() => {
                const btnText = document.getElementById('copyText');
                const originalText = btnText.innerText;
                btnText.innerText = 'Copied!';
                setTimeout(() => {
                    btnText.innerText = originalText;
                }, 2000);
            }).catch(err => {
                console.error('Failed to copy code: ', err);
            });
        }

        function triggerReject(id) {
            const reason = prompt("Please provide a reason for rejection:");
            if (reason === null) return; // Cancelled
            
            if (reason.trim() === "") {
                alert("Rejection reason is required.");
                return;
            }
            
            document.getElementById('reason-' + id).value = reason;
            document.getElementById('reject-form-' + id).submit();
        }
    </script>
</x-app-layout>