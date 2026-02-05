<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('HCPs') }}
        </h2>
    </x-slot>
    {{-- edit hcp details --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 overflow-hidden shadow-sm sm:rounded-lg">
                <form action="{{ route('hcps.update', $hcp->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <a href="{{ route('hcps.index') }}" class="text-blue-600 hover:underline">← Back to List</a>
                    <div class="mb-4">
                        <label for="hcp_name" class="block text-gray-700 font-bold mb-2">HCP Name:</label>
                        <input type="text" name="hcp_name" id="hcp_name" value="{{ $hcp->hcp_name }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required>
                    </div>
                    <div class="mb-4">
                        <label for="hcp_code" class="block text-gray-700 font-bold mb-2">HCP Code:</label>
                        <input type="text" name="hcp_code" id="hcp_code" value="{{ $hcp->hcp_code }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required>
                    </div>
                    <div class="mb-4">
                        <label for="hcp_location" class="block text-gray-700 font-bold mb-2">Location:</label>
                        <input type="text" name="hcp_location" id="hcp_location" value="{{ $hcp->hcp_location }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required>
                    </div>
                    <div class="mb-4">
                        <label for="hcp_contact" class="block text-gray-700 font-bold mb-2">Contact:</label>
                        <input type="text" name="hcp_contact" id="hcp_contact" value="{{ $hcp->hcp_contact }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required>
                    </div>
                    <div class="mb-4">
                        <label for="hcp_email" class="block text-gray-700 font-bold mb-2">Email:</label>
                        <input type="email" name="hcp_email" id="hcp_email" value="{{ $hcp->hcp_email }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required>
                    </div>
                    <div class="mb-4">
                        <label for="hcp_account_number" class="block text-gray-700 font-bold mb-2">Account
                            Number:</label>
                        <input type="text" name="hcp_account_number" id="hcp_account_number"
                            value="{{ $hcp->hcp_account_number }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required>
                    </div>
                    <div class="mb-4">
                        <label for="hcp_account_name" class="block text-gray-700 font-bold mb-2">Account Name:</label>
                        <input type="text" name="hcp_account_name" id="hcp_account_name"
                            value="{{ $hcp->hcp_account_name }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required>
                    </div>
                    <div class="mb-4">
                        <label for="hcp_bank_name" class="block text-gray-700 font-bold mb-2">Bank Name:</label>
                        <input type="text" name="hcp_bank_name" id="hcp_bank_name" value="{{ $hcp->hcp_bank_name }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required>
                    </div>
                    <div class="mb-4">
                        <label for="hcp_accreditation_status" class="block text-gray-700 font-bold mb-2">Accreditation
                            Status:</label>
                        <input type="text" name="hcp_accreditation_status" id="hcp_accreditation_status"
                            value="{{ $hcp->hcp_accreditation_status }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required>
                    </div>
                    <div class="flex items-center justify-between">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Update HCP
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
