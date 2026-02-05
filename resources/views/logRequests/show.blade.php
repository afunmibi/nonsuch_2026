<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <div>
                <h2 class="text-xl font-bold text-gray-900 tracking-tight">
                    Review Request: <span class="font-mono text-indigo-600">{{ $logRequest->policy_no }}</span>
                </h2>
                <p class="text-xs text-gray-500 mt-1 uppercase tracking-wider font-semibold">
                    Submitted: {{ $logRequest->created_at->format('F d, Y @ H:i') }}
                </p>
            </div>
            
            @php
                $statusColor = [
                    'approved' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                    'rejected' => 'bg-red-100 text-red-700 border-red-200',
                    'pending'  => 'bg-amber-100 text-amber-700 border-amber-200',
                ][$logRequest->pa_code_status] ?? 'bg-gray-100 text-gray-700 border-gray-200';
            @endphp

            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold uppercase border {{ $statusColor }}">
                <span class="w-2 h-2 rounded-full mr-2 bg-current animate-pulse"></span>
                Status: {{ $logRequest->pa_code_status }}
            </span>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/50">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-xl overflow-hidden border border-gray-200">
                
                {{-- Top Section: Member & HCP Info --}}
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <div class="p-8 border-b md:border-b-0 md:border-r border-gray-100 bg-indigo-50/30">
                        <h4 class="text-[10px] font-bold text-indigo-400 uppercase tracking-[0.2em] mb-4">Patient Information</h4>
                        <div class="space-y-1">
                            <p class="text-xl font-extrabold text-gray-900">{{ $logRequest->full_name }}</p>
                            <p class="text-sm font-medium text-gray-600 flex items-center">
                                <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                Policy No: <span class="font-mono ml-1">{{ $logRequest->policy_no }}</span>
                            </p>
                            <span class="inline-block mt-2 px-2 py-0.5 bg-white border border-indigo-100 text-indigo-600 text-[10px] font-bold rounded uppercase">
                                Plan: {{ $logRequest->package_code }}
                            </span>
                        </div>
                    </div>

                    <div class="p-8 border-b border-gray-100 bg-emerald-50/20">
                        <h4 class="text-[10px] font-bold text-emerald-500 uppercase tracking-[0.2em] mb-4">Provider Details</h4>
                        <div class="space-y-3">
                            <div>
                                <span class="text-[10px] text-gray-400 font-bold uppercase block">Primary HCP</span>
                                <p class="text-sm font-semibold text-gray-800">{{ $logRequest->pry_hcp }}</p>
                            </div>
                            <div>
                                <span class="text-[10px] text-gray-400 font-bold uppercase block">Secondary / Referral</span>
                                <p class="text-sm font-semibold text-indigo-600">{{ $logRequest->secondary_hcp }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Clinical Section --}}
                <div class="p-8 space-y-8">
                    <section>
                        <div class="flex items-center mb-3">
                            <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center mr-3 text-blue-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            </div>
                            <h4 class="font-bold text-gray-800 uppercase text-xs tracking-wider">Clinical Diagnosis</h4>
                        </div>
                        <div class="bg-gray-50 p-5 rounded-xl border border-gray-200 text-gray-700 leading-relaxed font-medium shadow-inner">
                            {{ $logRequest->diagnosis }}
                        </div>
                    </section>

                    <section>
                        <div class="flex items-center mb-3">
                            <div class="w-8 h-8 rounded-lg bg-purple-100 flex items-center justify-center mr-3 text-purple-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                            </div>
                            <h4 class="font-bold text-gray-800 uppercase text-xs tracking-wider">Treatment Plan</h4>
                        </div>
                        <div class="bg-gray-50 p-5 rounded-xl border border-gray-200 text-gray-700 leading-relaxed shadow-inner">
                            {{ $logRequest->treatment_plan }}
                        </div>
                    </section>

                    {{-- Show Rejection Reason if exists --}}
                    @if($logRequest->pa_code_status === 'rejected' && $logRequest->rejection_reason)
                        <div class="p-4 bg-red-50 border border-red-100 rounded-lg">
                            <h4 class="text-xs font-bold text-red-600 uppercase mb-1">Reason for Rejection</h4>
                            <p class="text-sm text-red-800 italic">"{{ $logRequest->rejection_reason }}"</p>
                        </div>
                    @endif
                </div>

                {{-- Action Footer --}}
                {{-- Action Footer --}}
<div class="bg-gray-50 px-8 py-6 border-t border-gray-200 flex flex-col sm:flex-row justify-between items-center gap-4 print:hidden">
    <a href="{{ route('logRequests.index') }}" class="text-gray-500 hover:text-gray-800 text-sm font-bold uppercase tracking-tighter flex items-center group transition">
        <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Back to List
    </a>

    <div class="flex items-center space-x-3">
        <div x-data="{ 
            copyLink() {
                const link = '{{ route('feedback.create', ['pa_code' => $logRequest->pa_code, 'policy_no' => $logRequest->policy_no]) }}';
                navigator.clipboard.writeText(link).then(() => {
                    $dispatch('notify', { message: 'Enrollee Feedback Link Copied!', type: 'success' });
                });
            }
        }">
            <button @click="copyLink" 
               class="flex items-center bg-emerald-50 border border-emerald-200 hover:bg-emerald-100 text-emerald-700 px-4 py-2.5 rounded-lg text-xs font-extrabold uppercase shadow-sm transition">
                <i class="fas fa-comment-medical mr-2 text-emerald-500"></i>
                Copy Feedback Link
            </button>
        </div>

        {{-- Print Button (Only shows if approved) --}}
        @if($logRequest->pa_code_status === 'approved')
            <button onclick="window.print()" class="flex items-center bg-white border border-gray-300 hover:bg-gray-100 text-gray-700 px-4 py-2.5 rounded-lg text-xs font-extrabold uppercase shadow-sm transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Print Slip
            </button>
        @endif

        @if($logRequest->pa_code_status === 'pending')
            {{-- ... existing Approve/Reject forms ... --}}
        @endif
    </div>
</div>
</x-app-layout>