<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create New Bill Vetting
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('bill-vetting.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- PA Code Selection -->
                    <div>
                        <label for="pa_code" class="block text-sm font-medium text-gray-700 mb-2">Select PA Code</label>
                        <select id="pa_code" name="pa_code" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select a PA Code...</option>
                            @foreach(\App\Models\LogRequest::all() as $log)
                                <option value="{{ $log->pa_code }}">{{ $log->pa_code }} - {{ $log->full_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Billing Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="billing_month" class="block text-sm font-medium text-gray-700 mb-2">Billing Month</label>
                            <select id="billing_month" name="billing_month" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @foreach(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $month)
                                    <option value="{{ $month }}">{{ $month }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="admission_days" class="block text-sm font-medium text-gray-700 mb-2">Days Admitted</label>
                            <input type="number" id="admission_days" name="admission_days" min="0" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <!-- Package Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="package_limit" class="block text-sm font-medium text-gray-700 mb-2">Package Limit</label>
                            <input type="text" id="package_limit" name="package_limit" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="hcp_amount_due_grandtotal" class="block text-sm font-medium text-gray-700 mb-2">HCP Amount Due</label>
                            <input type="number" id="hcp_amount_due_grandtotal" name="hcp_amount_due_grandtotal" step="0.01" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('bill-vetting.index') }}" class="mr-4 text-gray-500 hover:text-gray-700">Cancel</a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Create Vetting
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>