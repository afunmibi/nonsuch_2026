<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            IT Support Dashboard
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- System Status -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-800 mb-4">Support & Logistics</h3>
                    <p class="text-sm text-gray-500 mb-6 italic">You are logged in as IT Support. You have access to user management and system auditing tools.</p>
                    <a href="{{ route('profile.edit') }}" class="text-indigo-600 text-sm font-bold hover:underline">Update System Profile &rarr;</a>
                </div>

                <!-- Document Audit -->
                <div class="bg-slate-900 p-6 rounded-2xl shadow-xl text-white">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="bg-indigo-500/20 p-3 rounded-xl text-indigo-400">
                            <i class="fas fa-file-shield text-xl"></i>
                        </div>
                        <h3 class="font-bold">Provider Document Audit</h3>
                    </div>
                    <p class="text-slate-400 text-xs mb-6 font-medium leading-relaxed">Oversee all digital submissions from healthcare providers. Verify file integrity and ensure documentation standards are met.</p>
                    <a href="{{ route('hcp-uploads.admin') }}" class="inline-block w-full text-center px-4 py-3 bg-white text-slate-900 rounded-xl font-black text-xs hover:bg-slate-50 transition">
                        Audit Hospital Submissions
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
