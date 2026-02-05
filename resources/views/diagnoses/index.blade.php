<x-app-layout>
    <div class="max-w-7xl mx-auto p-4 md:p-6 space-y-6">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-6 text-white shadow-xl flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-black italic tracking-tight">Diagnosis Master List</h1>
                <p class="text-sm opacity-90 font-medium">Manage medical diagnosis codes and their associated treatment plans.</p>
            </div>
            <div class="h-12 w-12 bg-white/20 backdrop-blur-md rounded-xl flex items-center justify-center text-2xl">
                <i class="fas fa-stethoscope"></i>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Data Entry Form -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl border-2 border-slate-200 shadow-lg overflow-hidden sticky top-6">
                    <div class="bg-slate-50 px-6 py-4 border-b-2 border-slate-100">
                        <h2 class="text-sm font-black text-slate-800 uppercase tracking-widest flex items-center gap-2">
                            <i class="fas {{ isset($diagnosis) ? 'fa-edit text-orange-500' : 'fa-plus-circle text-blue-500' }}"></i>
                            {{ isset($diagnosis) ? 'Update Records' : 'New Entry' }}
                        </h2>
                    </div>
                    
                    <form action="{{ isset($diagnosis) ? route('diagnoses.update', $diagnosis->id) : route('diagnoses.store') }}" 
                          method="POST" class="p-6 space-y-4">
                        @csrf
                        @if(isset($diagnosis)) @method('PUT') @endif

                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1 block">Diagnosis Code</label>
                            <input type="text" name="diag_code" value="{{ old('diag_code', $diagnosis->diag_code ?? '') }}"
                                   placeholder="e.g. malaria-01" required
                                   class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-4 py-2 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                            @error('diag_code') <p class="text-[10px] text-red-500 mt-1 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1 block">Diagnosis Description</label>
                            <input type="text" name="diagnosis" value="{{ old('diagnosis', $diagnosis->diagnosis ?? '') }}"
                                   placeholder="Full description" required
                                   class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-4 py-2 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                        </div>

                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1 block">Default Treatment Plan</label>
                            <textarea name="treatment_plan" rows="4" placeholder="Standard recommendation..." required
                                      class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-4 py-2 text-sm font-medium text-slate-600 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">{{ old('treatment_plan', $diagnosis->treatment_plan ?? '') }}</textarea>
                        </div>

                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1 block">Estimated Cost (₦)</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold">₦</span>
                                <input type="number" step="0.01" name="cost" value="{{ old('cost', $diagnosis->cost ?? '') }}"
                                       required class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl pl-8 pr-4 py-2 text-sm font-black text-blue-700 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                            </div>
                        </div>

                        <div class="pt-4 flex gap-2">
                            @if(isset($diagnosis))
                                <a href="{{ route('diagnoses.index') }}" class="flex-1 bg-slate-200 text-slate-600 font-bold py-3 rounded-xl uppercase text-xs text-center shadow-md hover:bg-slate-300 transition-all">Cancel</a>
                            @endif
                            <button type="submit" class="flex-[2] bg-blue-600 text-white font-black py-3 rounded-xl uppercase text-xs shadow-lg shadow-blue-200 hover:scale-[1.02] transition-all">
                                {{ isset($diagnosis) ? 'Update Record' : 'Save Diagnosis' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- List Table -->
            <div class="lg:col-span-2">
                @if(session('success'))
                    <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 mb-6 rounded-r-xl shadow-sm animate-bounce">
                        <p class="text-emerald-700 text-sm font-bold">✅ {{ session('success') }}</p>
                    </div>
                @endif

                <div class="bg-white rounded-2xl border-2 border-slate-200 shadow-lg overflow-hidden">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50 border-b-2 border-slate-100">
                            <tr>
                                <th class="px-6 py-4 text-[10px] uppercase font-black text-slate-400">Code</th>
                                <th class="px-6 py-4 text-[10px] uppercase font-black text-slate-400">Diagnosis / Plan</th>
                                <th class="px-6 py-4 text-[10px] uppercase font-black text-slate-400 text-right">Cost</th>
                                <th class="px-6 py-4 text-[10px] uppercase font-black text-slate-400 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($diagnoses as $diag)
                                <tr class="hover:bg-blue-50/30 transition-colors group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="bg-slate-100 text-slate-600 px-2 py-1 rounded text-[10px] font-black font-mono border border-slate-200">
                                            {{ $diag->diag_code }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-sm font-bold text-slate-800">{{ $diag->diagnosis }}</p>
                                        <p class="text-[10px] text-slate-400 italic line-clamp-1 mt-0.5">{{ $diag->treatment_plan }}</p>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="text-sm font-black text-blue-600">₦{{ number_format($diag->cost, 2) }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex items-center justify-center gap-2 opacity-30 group-hover:opacity-100 transition-all">
                                            <a href="{{ route('diagnoses.edit', $diag->id) }}" class="text-orange-400 hover:text-orange-600 p-1">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('diagnoses.destroy', $diag->id) }}" method="POST" onsubmit="return confirm('Delete this record?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-300 hover:text-red-500 p-1">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <i class="fas fa-folder-open text-4xl text-slate-100 mb-3 block"></i>
                                            <p class="text-slate-400 text-sm font-medium">No diagnosis codes found.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    
                    @if($diagnoses->hasPages())
                        <div class="px-6 py-4 bg-slate-50 border-t border-slate-100">
                            {{ $diagnoses->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
