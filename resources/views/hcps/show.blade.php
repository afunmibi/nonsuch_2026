<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('HCP Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-900">{{ $hcp->hcp_name }}</h3>
                    <a href="{{ route('hcps.index') }}" class="text-blue-600 hover:underline">← Back to List</a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-t pt-6">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase">HCP Code</p>
                        <p class="text-lg text-gray-900">{{ $hcp->hcp_code }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase">Location</p>
                        <p class="text-lg text-gray-900">{{ $hcp->hcp_location }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase">Contact Number</p>
                        <p class="text-lg text-gray-900">{{ $hcp->hcp_contact }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase">Email Address</p>
                        <p class="text-lg text-gray-900">{{ $hcp->hcp_email }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase">Accreditation Status</p>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            {{ $hcp->hcp_accreditation_status }}
                        </span>
                    </div>
                </div>
                <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6 border-t pt-6">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase">Account Number</p>
                        <p class="text-lg text-gray-900">{{ $hcp->hcp_account_number }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase">Account Name</p>
                        <p class="text-lg text-gray-900">{{ $hcp->hcp_account_name }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase">Bank Name</p>
                        <p class="text-lg text-gray-900">{{ $hcp->hcp_bank_name }}</p>
                    </div>
                </div>
                

                <div class="mt-8 flex gap-4">
                    <a href="{{ route('hcps.edit', $hcp->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">
                        Edit Details
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>