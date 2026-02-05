<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Create Package') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 overflow-hidden shadow-sm sm:rounded-lg">
                <form action="{{ route('packages.store') }}" method="POST">
                    @csrf

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <div class="mb-4">
                        <label for="package_name" class="block text-sm font-medium text-gray-700">Package Name</label>
                        <input type="text" name="package_name" id="package_name"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            required>
                    </div>

                    <div class="mb-4">
                        <label for="package_description" class="block text-sm font-medium text-gray-700">Package
                            Description</label>
                        <textarea name="package_description" id="package_description" rows="3"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="package_code" class="block text-sm font-medium text-gray-700">Package
                                Code</label>
                            <input type="text" name="package_code" id="package_code"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                required>
                        </div>

                        <div>
                            <label for="package_price" class="block text-sm font-medium text-gray-700">Package
                                Price</label>
                            <input type="number" name="package_price" id="package_price" step="0.01"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                required>
                        </div>

                        <div>
                            <label for="package_limit" class="block text-sm font-medium text-gray-700">Package
                                Limit</label>
                            <input type="number" name="package_limit" id="package_limit" value="1"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                required>
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-gray-300 transition ease-in-out duration-150">
                            Create Package
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
