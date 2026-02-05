<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Staff Dashboard
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 text-center max-w-2xl mx-auto">
                <div class="bg-indigo-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 text-indigo-600">
                    <i class="fas fa-file-invoice-dollar text-3xl"></i>
                </div>
                <h3 class="text-2xl font-black text-gray-800 mb-2">Hospital Billing Portal</h3>
                <p class="text-gray-500 mb-8 font-medium">As a staff member, you can monitor and download all uploaded bills from our healthcare provider network for auditing purposes.</p>
                
                <a href="{{ route('hcp-uploads.admin') }}" class="inline-flex items-center px-8 py-4 bg-indigo-600 text-white rounded-xl font-black shadow-xl shadow-indigo-100 hover:bg-indigo-700 transition transform hover:-translate-y-1">
                    <i class="fas fa-download mr-3"></i> View & Download Submissions
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
