<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Packages') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-4">Package Details</h1>

                <div class="mb-4">
                    <h2 class="text-lg font-semibold">Name:</h2>
                    <p class="text-gray-700">{{ $package->package_name }}</p>
                </div>

                <div class="mb-4">
                    <h2 class="text-lg font-semibold">Description:</h2>
                    <p class="text-gray-700">{{ $package->package_description }}</p>
                </div>

                <div class="mb-4">
                    <h2 class="text-lg font-semibold">Code:</h2>
                    <p class="text-gray-700">{{ $package->package_code }}</p>
                </div>

                <div class="mb-4">
                    <h2 class="text-lg font-semibold">Price:</h2>
                    <p class="text-gray-700">N{{ number_format($package->package_price, 2) }}</p>
                </div>

                <div class="mb-4">
                    <h2 class="text-lg font-semibold">Limit:</h2>
                    <p class="text-gray-700">N{{ number_format($package->package_limit, 2) }}</p>
                </div>

                <a href="{{ route('packages.index') }}" class="mt-6 inline-block bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to Packages
                </a>
            </div>
        </div>
    </div>
</x-app-layout>