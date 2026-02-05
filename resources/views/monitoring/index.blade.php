<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-bold leading-tight text-gray-800">
                {{ __('PA Monitoring Logs') }}
            </h2>
            <a href="{{ route('monitoring.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition">
                New Monitoring Log
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-3xl overflow-hidden border border-gray-100">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100">
                            <th class="px-6 py-4 text-xs font-black uppercase text-gray-400 tracking-widest">PA Code</th>
                            <th class="px-6 py-4 text-xs font-black uppercase text-gray-400 tracking-widest">Patient</th>
                            <th class="px-6 py-4 text-xs font-black uppercase text-gray-400 tracking-widest">Status</th>
                            <th class="px-6 py-4 text-xs font-black uppercase text-gray-400 tracking-widest">Days Spent</th>
                            <th class="px-6 py-4 text-xs font-black uppercase text-gray-400 tracking-widest">Last Update</th>
                            <th class="px-6 py-4 text-xs font-black uppercase text-gray-400 tracking-widest text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($logs as $log)
                        <tr class="hover:bg-indigo-50/30 transition-colors group">
                            <td class="px-6 py-4">
                                <span class="bg-indigo-50 text-indigo-700 px-3 py-1 rounded-lg font-mono font-bold text-xs ring-1 ring-indigo-200 uppercase">
                                    {{ $log->pa_code }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900">{{ $log->full_name }}</div>
                                <div class="text-[10px] text-gray-400 font-mono">{{ $log->policy_no }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider
                                    {{ $log->monitoring_status == 'Discharged' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }}">
                                    {{ $log->monitoring_status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-black text-gray-700">
                                {{ $log->days_spent }} Days
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-500 font-medium">
                                {{ $log->updated_at->diffForHumans() }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('monitoring.edit', $log->id) }}" class="text-indigo-600 hover:text-indigo-900 font-bold text-sm">Update</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="text-gray-400 italic">No monitoring logs found. Start by authorizing a PA code.</div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-6 py-4 bg-gray-50/30">
                    {{ $logs->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
