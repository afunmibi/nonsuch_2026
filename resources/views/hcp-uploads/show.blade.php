<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Upload Details') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50/50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                <div class="p-8 border-b border-gray-100 flex justify-between items-start">
                    <div>
                        <p class="text-xs font-black uppercase text-gray-400 tracking-widest mb-1">Billing Month</p>
                        <h3 class="text-2xl font-bold text-gray-900">{{ $hcpBillUpload->billing_month }}</h3>
                    </div>
                    <span class="px-4 py-2 rounded-xl text-xs font-black uppercase tracking-wider
                        {{ $hcpBillUpload->status == 'Pending' ? 'bg-amber-100 text-amber-700' : 'bg-green-100 text-green-700' }}">
                        {{ $hcpBillUpload->status }}
                    </span>
                </div>

                <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h4 class="text-sm font-bold text-gray-900 mb-4">Hospital Information</h4>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Name:</span>
                                <span class="font-medium">{{ $hcpBillUpload->hcp_name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Code:</span>
                                <span class="font-medium">{{ $hcpBillUpload->hcp_code ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Officer:</span>
                                <span class="font-medium">{{ $hcpBillUpload->hmo_officer ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-sm font-bold text-gray-900 mb-4">Claim Details</h4>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Amount:</span>
                                <span class="font-mono font-bold text-lg">₦{{ number_format($hcpBillUpload->amount_claimed, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Submitted:</span>
                                <span class="font-medium">{{ $hcpBillUpload->created_at ? $hcpBillUpload->created_at->format('M d, Y h:i A') : 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-8 bg-gray-50 border-t border-gray-100">
                    <h4 class="text-sm font-bold text-gray-900 mb-4">Uploaded Document</h4>
                    <div class="flex items-center gap-4 bg-white p-4 rounded-xl border border-gray-200">
                        <div class="bg-indigo-50 p-3 rounded-lg text-indigo-600">
                            <i class="fas fa-file-alt text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-bold text-gray-700">Bill Attachment</p>
                            <p class="text-xs text-gray-400">Click to view original file</p>
                        </div>
                        <a href="{{ route('hcp-uploads.download', $hcpBillUpload->id) }}" class="px-4 py-2 bg-indigo-600 text-white text-xs font-bold rounded-lg hover:bg-indigo-700 transition">
                            Download / View
                        </a>
                    </div>
                    
                    @if($hcpBillUpload->remarks)
                    <div class="mt-6">
                        <h4 class="text-xs font-black uppercase text-gray-400 tracking-widest mb-2">Remarks</h4>
                        <div class="p-4 bg-yellow-50 text-yellow-800 rounded-xl text-sm italic">
                            "{{ $hcpBillUpload->remarks }}"
                        </div>
                    </div>
                    @endif
                </div>
                
                <div class="p-6 bg-gray-100 text-right">
                    <form action="{{ route('hcp-uploads.destroy', $hcpBillUpload->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-bold uppercase tracking-wider">
                            Delete Upload
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
