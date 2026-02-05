<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Hospital Bill Submissions') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-800">All Provider Uploads</h3>
                    <div class="text-xs text-gray-400 font-bold uppercase tracking-widest">
                        Total Submissions: {{ $uploads->total() }}
                    </div>
                </div>

                @if($uploads->isEmpty())
                <div class="text-center py-12">
                    <div class="text-gray-300 mb-4">
                        <i class="fas fa-file-invoice-dollar text-6xl"></i>
                    </div>
                    <p class="text-gray-500 font-medium">No bills have been uploaded by providers yet.</p>
                </div>
                @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-100 text-xs text-gray-400 font-black uppercase tracking-widest">
                                <th class="py-4 px-2">Provider</th>
                                <th class="py-4 px-2">Period</th>
                                <th class="py-4 px-2">Officer</th>
                                <th class="py-4 px-2">Amount</th>
                                <th class="py-4 px-2">Status</th>
                                <th class="py-4 px-2 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($uploads as $upload)
                            <tr class="hover:bg-gray-50 transition border-b border-gray-50">
                                <td class="py-4 px-2">
                                    <div class="font-bold text-gray-800">{{ $upload->hcp_name }}</div>
                                    <div class="text-[10px] text-gray-400 font-bold uppercase">{{ $upload->hcp_code ?? 'NO CODE' }}</div>
                                </td>
                                <td class="py-4 px-2 text-sm text-gray-600">
                                    {{ $upload->billing_month }}
                                </td>
                                <td class="py-4 px-2 text-sm text-gray-500 italic">
                                    {{ $upload->hmo_officer ?? 'N/A' }}
                                </td>
                                <td class="py-4 px-2 text-sm font-mono font-bold text-indigo-600">
                                    ₦{{ number_format($upload->amount_claimed, 2) }}
                                </td>
                                <td class="py-4 px-2">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider
                                        {{ $upload->status == 'Pending' ? 'bg-amber-100 text-amber-700' : 'bg-green-100 text-green-700' }}">
                                        {{ $upload->status }}
                                    </span>
                                </td>
                                <td class="py-4 px-2 text-right space-x-2">
                                    <a href="{{ route('hcp-uploads.download', $upload->id) }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white rounded-xl text-xs font-black uppercase tracking-wider hover:bg-emerald-700 shadow-lg shadow-emerald-100 transition transform hover:-translate-y-0.5">
                                        <i class="fas fa-cloud-download-alt mr-2"></i> Download Bill
                                    </a>
                                    <a href="{{ route('hcp-uploads.show', $upload->id) }}" class="inline-flex items-center px-4 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-black uppercase tracking-wider hover:bg-slate-200 transition">
                                        Details
                                    </a>
                                    @if(auth()->user()->role === 'admin')
                                    <form action="{{ route('hcp-uploads.destroy', $upload->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this record forever?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-red-400 hover:text-red-600 transition">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-6">
                    {{ $uploads->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
