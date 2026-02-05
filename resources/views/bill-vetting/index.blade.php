<x-app-layout>
    <div class="max-w-7xl mx-auto p-6">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Bill Vetting Portal</h1>
                <p class="text-slate-500">Search for a PA Code to begin vetting or select from recent requests.</p>
            </div>
            <a href="{{ route('bill-vetting.create') }}" 
               class="px-5 py-2.5 bg-indigo-600 text-white font-bold rounded-xl shadow-lg hover:bg-indigo-700 hover:shadow-xl transition-all flex items-center gap-2">
                <i class="fas fa-plus-circle"></i>
                <span>New Entry</span>
            </a>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 mb-8">
            <form action="{{ route('bill-vetting.index') }}" method="GET" class="flex gap-4">
                <div class="flex-1">
                    <input type="text" name="pa_code" 
                           class="w-full border-slate-200 rounded-lg focus:ring-blue-500 focus:border-blue-500" 
                           placeholder="Enter PA Code (e.g., PA-12345)..." required>
                </div>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-700 transition-all">
                    Open Workstation
                </button>
            </form>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                <h2 class="text-sm font-bold text-slate-600 uppercase">Recent Requests</h2>
            </div>
            <table class="w-full text-left">
                <thead class="bg-slate-50 text-[11px] font-bold text-slate-400 uppercase">
                    <tr>
                        <th class="px-6 py-3">PA Code</th>
                        <th class="px-6 py-3">Patient</th>
                        <th class="px-6 py-3">Provider</th>
                        <th class="px-6 py-3 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($logRequests as $log)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-mono text-sm text-blue-600">{{ $log->pa_code }}</td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-slate-700">{{ $log->full_name }}</div>
                            <div class="text-xs text-slate-400">{{ $log->policy_no }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $log->pry_hcp }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('bill-vetting.edit', base64_encode($log->pa_code)) }}" 
                               class="text-xs bg-slate-100 text-slate-600 px-3 py-1.5 rounded font-bold hover:bg-blue-600 hover:text-white transition-all">
                                Vet Bill
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="p-4 border-t border-slate-100">
                {{ $logRequests->links() }}
            </div>
        </div>
    </div>
</x-app-layout>