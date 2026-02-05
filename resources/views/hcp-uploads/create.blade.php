<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Upload Monthly Bill') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50/50">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-2xl shadow-xl border border-gray-100">
                <form method="POST" action="{{ route('hcp-uploads.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <div class="border-b border-gray-100 pb-4 mb-6">
                        <h3 class="text-lg font-bold text-gray-900">Hospital Details</h3>
                        <p class="text-sm text-gray-500">Please provide accurate billing information.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-xs font-black uppercase text-gray-400 tracking-widest">Hospital Name</label>
                            <input type="text" name="hcp_name" value="{{ auth()->user()->name }}" class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold text-gray-700" required>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-xs font-black uppercase text-gray-400 tracking-widest">HCP Code (Optional)</label>
                            <input type="text" name="hcp_code" class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold text-gray-700" placeholder="e.g. NS-001">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                         <div class="space-y-2">
                            <label class="block text-xs font-black uppercase text-gray-400 tracking-widest">Billing Month</label>
                            <input type="month" name="billing_month" class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold text-gray-700" required>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-xs font-black uppercase text-gray-400 tracking-widest">HMO Officer Name</label>
                            <input type="text" name="hmo_officer" class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-bold text-gray-700" placeholder="Officer in charge">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-xs font-black uppercase text-gray-400 tracking-widest">Total Amount Claimed (₦)</label>
                        <input type="number" step="0.01" name="amount_claimed" class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 font-black text-2xl text-gray-800" placeholder="0.00" required>
                    </div>

                    <div class="space-y-2">
                         <label class="block text-xs font-black uppercase text-gray-400 tracking-widest">Upload Bill File</label>
                         <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center bg-gray-50 hover:bg-white hover:border-indigo-400 transition cursor-pointer relative">
                             <input type="file" name="file_path" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" required accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx">
                             <div class="pointer-events-none">
                                 <i class="fas fa-cloud-upload-alt text-4xl text-gray-300 mb-2"></i>
                                 <p class="text-sm font-bold text-gray-600">Click to upload bill document</p>
                                 <p class="text-[10px] text-gray-400 mt-1">PDF, Excel, Images (Max 10MB)</p>
                             </div>
                         </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-xs font-black uppercase text-gray-400 tracking-widest">Remarks / Notes</label>
                        <textarea name="remarks" rows="3" class="w-full rounded-xl border-gray-200 focus:ring-indigo-500 text-sm" placeholder="Any additional details..."></textarea>
                    </div>

                    <div class="flex justify-end pt-4">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-black py-4 px-10 rounded-xl shadow-xl shadow-indigo-100 transform transition hover:-translate-y-1">
                            Submit Bill for Vetting
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
