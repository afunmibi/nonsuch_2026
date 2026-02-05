<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-bold leading-tight text-gray-900">
                {{ __('Medical Log Requests') }}
            </h2>
            <a href="{{ route('logRequests.create') }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
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
                <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 px-4 py-4 rounded-r-lg relative mb-6 shadow-sm animate-fade-in">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <p class="font-bold">Action Successful</p>
                    </div>
                    <p class="mt-1 text-sm">{{ session('success') }}</p>
                    
                    @if (session('pa_code'))
                        <div class="mt-3 p-3 bg-white border border-emerald-200 rounded-lg flex justify-between items-center shadow-inner">
                            <div>
                                <span class="text-[10px] uppercase text-gray-400 block font-bold">Generated PA
                                    Code</span>
                                <code class="text-lg font-mono font-bold text-emerald-700"
                                    id="paCode">{{ session('pa_code') }}</code>
                            </div>
                            <button onclick="copyToClipboard()"
                                class="flex items-center space-x-1 text-xs bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-2 rounded-md transition font-semibold">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 5H6a2 2 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span id="copyText" x-text="'Copied!' : 'Copy Code'" x-transition="duration-200">{{ session('pa_code') }}</span>
                            </button>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Policy Info</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                HCP Details</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Medical Case</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Authorization</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($logRequests as $log)
                            <tr class="hover:bg-gray-50/80 transition duration-150">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-gray-900">{{ $log->full_name }}</div>
                                        <div class="text-xs text-gray-500 font-mono">{{ $log->policy_no }}</div>
                                        <div>
                                            <div class="mt-1 inline-block px-2 py-0.5 rounded text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-100">
                                                {{ $log->package_code }}
                                            </div>
                                        </td>
                                
                                <td class="px-6 py-4 text-xs">
                                        <div class="font-semibold text-gray-700"><span class="text-gray-400">Pry:</span>
                                            {{ $log->pry_hcp }}</div>
                                        <div class="font-semibold text-indigo-700 mt-1"><span class="text-gray-400">Sec:</span> {{ $log->secondary_hcp }}</div>
                                    </td>
                                
                                <td class="px-6 py-4">
                                    <div class="text-xs font-bold text-red-600 truncate max-w-[180px]"
                                            title="{{ $log->diagnosis }}">
                                            {{ $log->diagnosis }}
                                        </div>
                                        <div class="text-[11px] text-gray-500 italic mt-1 truncate max-w-[180px]">
                                            {{ $log->treatment_plan }}
                                        </div>
                                    </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($log->pa_code_status === 'approved')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                            <span class="w-1 h-1 mr-1.5 rounded-full bg-emerald-500"></span>
                                            APPROVED
                                        </span>
                                        <div class="text-[10px] font-mono text-gray-400 mt-1 uppercase">
                                            {{ $log->pa_code }}</div>
                                    @elseif($log->pa_code_status === 'rejected')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-red-100 text-red-800">
                                            <span class="w-1 h-1 mr-1.5 rounded-full bg-red-500"></span>
                                            REJECTED
                                        </span>
                                        <div class="text-[9px] text-red-400 mt-1 italic truncate max-w-[120px]"
                                            title="{{ $log->pa_code_rejection_reason }}">
                                            {{ $log->pa_code_rejection_reason }}
                                        </div>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">
                                            <span class="w-1 h-1 mr-1.5 rounded-full bg-amber-500"></span>
                                            PENDING
                                        </span>
                                        <div class="text-[9px] text-gray-400 mt-1 uppercase">
                                            {{ $log->created_at->format('d M - H:i') }}</div>
                                    @endif
                                </td>
                                
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        {{-- Actions for pending requests --}}
                                        @if($log->pa_code_status === 'pending')
                                            <form action="{{ route('logRequests.update', $log->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="pa_code_status" value="approved">
                                                <button type="submit" 
                                                        class="bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1.5 rounded text-[10px] font-bold uppercase transition">
                                                    Approve
                                                </button>
                                            </form>
                                            
                                            <form action="{{ route('logRequests.update', $log->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="pa_code_status" value="rejected">
                                                <input type="hidden" name="pa_code_rejection_reason" id="reason-{{ $log->id }}">
                                                <button type="button" 
                                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded text-[10px] font-bold uppercase transition">
                                                    Reject
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('logRequests.show', $log->id) }}" 
                                               class="inline-flex items-center px-3 py-1.5 bg-indigo-600 text-white text-[10px] font-bold uppercase rounded hover:bg-indigo-700 transition">
                                                View Details
                                            </a>
                                        @endif
                                        
                                        <a href="{{ route('logRequests.edit', $log->id) }}" 
                                           class="text-amber-600 hover:text-amber-900 font-bold text-[10px] uppercase">
                                            Edit
                                        </a>
                                        
                                        <form action="{{ route('logRequests.destroy', $log->id) }}" 
                                               method="POST" 
                                               onsubmit="return confirm('Delete this record? This action cannot be undone.');" 
                                               class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-500 hover:text-red-700 font-bold text-[10px] uppercase transition">
                                                    Delete
                                                </button>
                                            </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-20 text-center text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        />
                                    </svg>
                                    <p class="mt-4 text-gray-500 text-sm font-medium italic">No pending
                                        authorization requests.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if (method_exists($logRequests, 'links'))
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                    {{ $logRequests->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>