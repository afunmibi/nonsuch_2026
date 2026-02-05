<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold leading-tight text-gray-800">
            {{ __('Update Monitoring Log') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50/50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('monitoring.update', $log->id) }}" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')
                
                {{-- PA Info (Read-only) --}}
                <div class="bg-white p-8 shadow-sm rounded-2xl border border-gray-100">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="p-3 bg-indigo-50 rounded-xl text-indigo-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Encounter Monitoring</h3>
                            <p class="text-sm text-gray-500">Updating progress for PA: <span class="font-mono font-bold">{{ $log->pa_code }}</span></p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <label class="block text-xs font-black uppercase text-gray-400 tracking-widest">PA Authorization Code</label>
                            <input type="text" value="{{ $log->pa_code }}" class="w-full rounded-xl border-gray-100 bg-gray-50 font-mono font-bold text-gray-400" readonly>
                        </div>

                        <div class="space-y-1">
                            <label class="block text-xs font-black uppercase text-gray-400 tracking-widest">Monitoring Status</label>
                            <select name="monitoring_status" class="w-full rounded-xl border-gray-100 focus:ring-indigo-500 font-bold text-gray-700" required>
                                <option value="Admitted" {{ $log->monitoring_status == 'Admitted' ? 'selected' : '' }}>Currently Admitted</option>
                                <option value="Discharged" {{ $log->monitoring_status == 'Discharged' ? 'selected' : '' }}>Discharged</option>
                                <option value="Observation" {{ $log->monitoring_status == 'Observation' ? 'selected' : '' }}>Under Observation</option>
                                <option value="Transferred" {{ $log->monitoring_status == 'Transferred' ? 'selected' : '' }}>Transferred</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Patient Details --}}
                <div class="bg-white p-8 shadow-sm rounded-2xl border border-gray-100">
                    <h4 class="text-xs font-black uppercase text-gray-400 tracking-widest mb-6 border-b border-gray-50 pb-2">Patient Information</h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1" title="Read-only">
                            <label class="block text-xs font-bold text-gray-500">Full Name</label>
                            <input type="text" value="{{ $log->full_name }}" class="w-full rounded-xl border-gray-100 bg-gray-50 font-semibold text-gray-400" readonly>
                        </div>
                        <div class="space-y-1" title="Read-only">
                            <label class="block text-xs font-bold text-gray-500">Policy Number</label>
                            <input type="text" value="{{ $log->policy_no }}" class="w-full rounded-xl border-gray-100 bg-gray-50 font-semibold text-gray-400" readonly>
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-gray-500">Number of Days Spent</label>
                            <div class="relative">
                                <input type="number" name="days_spent" value="{{ $log->days_spent }}" class="w-full rounded-xl border-gray-100 focus:ring-indigo-500 font-black pl-10" required>
                                <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Clinical Details --}}
                <div class="bg-white p-8 shadow-sm rounded-2xl border border-gray-100">
                    <h4 class="text-xs font-black uppercase text-gray-400 tracking-widest mb-6 border-b border-gray-50 pb-2">Treatment & Remarks</h4>
                    
                    <div class="space-y-5">
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-gray-500">Current Diagnosis</label>
                            <input type="text" name="diagnosis" value="{{ $log->diagnosis }}" class="w-full rounded-xl border-gray-100 focus:ring-indigo-500 font-semibold">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-gray-500">Treatment Received</label>
                            <textarea name="treatment_received" rows="3" class="w-full rounded-xl border-gray-100 focus:ring-indigo-500 font-semibold">{{ $log->treatment_received }}</textarea>
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-gray-500">Monitoring Remarks</label>
                            <textarea name="remarks" rows="3" class="w-full rounded-xl border-gray-100 focus:ring-indigo-500 font-semibold">{{ $log->remarks }}</textarea>
                        </div>
                        
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-gray-500">Update Document (Clinical Notes, Scans, etc.)</label>
                            @if($log->file_path)
                            <div class="mb-3 p-3 bg-indigo-50 rounded-xl flex items-center justify-between">
                                <span class="text-xs font-bold text-indigo-700 flex items-center gap-2">
                                    <i class="fas fa-file-alt"></i> Existing file attached
                                </span>
                                <a href="{{ Storage::url($log->file_path) }}" target="_blank" class="text-xs font-black uppercase tracking-widest text-indigo-600 hover:underline">View Current</a>
                            </div>
                            @endif
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:bg-gray-50 transition-colors">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="file_upload" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                            <span>Upload a new file</span>
                                            <input id="file_upload" name="file_upload" type="file" class="sr-only">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PDF, PNG, JPG up to 5MB</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-4 pt-4">
                    <a href="{{ route('monitoring.index') }}" class="px-6 py-3 text-sm font-bold text-gray-500 hover:text-gray-700 transition">Cancel</a>
                    <button type="submit" class="px-10 py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-black shadow-xl shadow-indigo-100 transition-all">
                        Update Monitoring Log
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
