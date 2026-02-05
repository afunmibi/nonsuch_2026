<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Uploads History') }}
            </h2>
            <a href="{{ route('hcp-uploads.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-bold shadow-md hover:bg-indigo-700 transition">
                New Upload
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                
                @if($uploads->isEmpty())
                <div class="text-center py-12">
                    <div class="text-gray-300 mb-4">
                        <i class="fas fa-folder-open text-6xl"></i>
                    </div>
                    <p class="text-gray-500 font-medium">No uploads found.</p>
                </div>
                @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-100 text-xs text-gray-400 font-black uppercase tracking-widest">
                                <th class="py-4">Date</th>
                                <th class="py-4">Billing Month</th>
                                <th class="py-4">Amount</th>
                                <th class="py-4">Status</th>
                                <th class="py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($uploads as $upload)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="py-4 text-sm font-bold text-gray-700">
                                    {{ $upload->created_at->format('M d, Y') }}
                                </td>
                                <td class="py-4 text-sm text-gray-600">{{ $upload->billing_month }}</td>
                                <td class="py-4 text-sm font-mono font-bold text-gray-900">
                                    ₦{{ number_format($upload->amount_claimed, 2) }}
                                </td>
                                <td class="py-4">
                                     <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider
                                        {{ $upload->status == 'Pending' ? 'bg-amber-100 text-amber-700' : 'bg-green-100 text-green-700' }}">
                                        {{ $upload->status }}
                                    </span>
                                </td>
                                <td class="py-4 text-right space-x-3">
                                    <a href="{{ route('hcp-uploads.download', $upload->id) }}" class="text-blue-600 hover:text-blue-800 text-xs font-bold">
                                        <i class="fas fa-download mr-1"></i> Download
                                    </a>
                                    <a href="{{ route('hcp-uploads.show', $upload->id) }}" class="text-indigo-600 hover:text-indigo-800 text-xs font-bold">View</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $uploads->links() }}
                </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
