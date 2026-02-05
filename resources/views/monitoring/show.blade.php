<x-app-layout>
    <div class="max-w-4xl mx-auto p-4 md:p-6 space-y-6">
        
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-gradient-to-r from-emerald-50 to-teal-50 p-6 rounded-2xl border-2 border-emerald-200 shadow-lg">
            <div>
                <h1 class="text-2xl font-black text-emerald-900 mb-1">Monitoring Details</h1>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-emerald-600 uppercase tracking-wider">PA Code:</span>
                    <span class="text-lg font-mono font-black text-emerald-700 bg-white px-3 py-1 rounded-lg border border-emerald-200">{{ $log->pa_code }}</span>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('monitoring.index') }}" 
                   class="inline-flex items-center gap-2 bg-white border-2 border-slate-200 text-slate-600 hover:bg-slate-50 px-6 py-3 rounded-xl font-bold transition-all shadow-md">
                    <i class="fas fa-arrow-left"></i>
                    Back
                </a>
                <a href="{{ route('monitoring.edit', $log->id) }}" 
                   class="inline-flex items-center gap-2 bg-indigo-600 text-white hover:bg-indigo-700 px-6 py-3 rounded-xl font-bold transition-all shadow-md">
                    <i class="fas fa-edit"></i>
                    Update
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Patient Info -->
            <div class="bg-white rounded-2xl shadow-xl border-2 border-slate-200 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b-2 border-slate-200">
                    <h3 class="text-sm font-bold text-indigo-900 uppercase tracking-wide flex items-center gap-2">
                        <i class="fas fa-user-circle text-indigo-500"></i>
                        Patient Information
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Full Name</label>
                        <p class="text-lg font-bold text-slate-900">{{ $log->full_name }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Policy Number</label>
                        <p class="text-sm font-mono font-bold text-indigo-600 bg-indigo-50 px-3 py-2 rounded-lg inline-block">{{ $log->policy_no }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Phone Number</label>
                        <p class="text-sm font-semibold text-slate-700">{{ $log->phone_no ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <!-- Stay Info -->
            <div class="bg-white rounded-2xl shadow-xl border-2 border-slate-200 overflow-hidden">
                <div class="bg-gradient-to-r from-amber-50 to-orange-50 px-6 py-4 border-b-2 border-slate-200">
                    <h3 class="text-sm font-bold text-amber-900 uppercase tracking-wide flex items-center gap-2">
                        <i class="fas fa-hospital text-amber-500"></i>
                        Admission Details
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Monitoring Status</label>
                        <span class="px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider
                            {{ $log->monitoring_status == 'Discharged' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                            {{ $log->monitoring_status }}
                        </span>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Days Spent</label>
                        <p class="text-xl font-black text-slate-900">{{ $log->days_spent }} Days</p>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Last Updated</label>
                        <p class="text-sm text-slate-500 font-medium">{{ $log->updated_at->format('d M Y, h:i A') }} ({{ $log->updated_at->diffForHumans() }})</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Clinical Details -->
        <div class="bg-white rounded-2xl shadow-xl border-2 border-slate-200 overflow-hidden">
            <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-4 border-b-2 border-slate-200">
                <h3 class="text-sm font-bold text-emerald-900 uppercase tracking-wide flex items-center gap-2">
                    <i class="fas fa-stethoscope text-emerald-500"></i>
                    Clinical Presentation & Treatment
                </h3>
            </div>
            <div class="p-6 space-y-6">
                <div>
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-2">Diagnosis</label>
                    <p class="text-sm text-slate-700 leading-relaxed bg-slate-50 p-4 rounded-xl border border-slate-100">{{ $log->diagnosis ?? 'No diagnosis recorded' }}</p>
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-2">Treatment Received</label>
                    <p class="text-sm text-slate-700 leading-relaxed bg-slate-50 p-4 rounded-xl border border-slate-100">{{ $log->treatment_received ?? 'No treatment plan recorded' }}</p>
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-2">Monitoring Remarks</label>
                    <p class="text-sm text-slate-700 leading-relaxed bg-slate-50 p-4 rounded-xl border border-slate-100">{{ $log->remarks ?? 'No remarks provided' }}</p>
                </div>

                @if($log->file_path)
                <div>
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-2">Attached Document</label>
                    <div class="flex items-center gap-4 p-4 bg-indigo-50 border-2 border-indigo-100 rounded-2xl">
                        <div class="p-3 bg-white rounded-xl text-indigo-600">
                            <i class="fas fa-file-alt text-2xl"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-bold text-indigo-900">Medical Document / Attachment</p>
                            <p class="text-xs text-indigo-500 uppercase font-bold tracking-widest">Click to view or download</p>
                        </div>
                        <a href="{{ Storage::url($log->file_path) }}" target="_blank" 
                           class="px-6 py-2 bg-indigo-600 text-white rounded-lg font-bold text-xs hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                            View File
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>

    </div>
</x-app-layout>
