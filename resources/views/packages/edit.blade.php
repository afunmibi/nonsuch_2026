<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            Edit Package
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto bg-white p-8 rounded-xl shadow">
            <form method="POST" action="{{ route('packages.update', $package->id) }}">
                @csrf
                @method('PUT')

                <div class="space-y-5">
                    <div>
                        <label class="font-bold text-sm">Package Name</label>
                        <x-text-input class="w-full"
                            name="package_name"
                            value="{{ old('package_name', $package->package_name) }}" />
                    </div>

                    <div>
                        <label class="font-bold text-sm">Package Code</label>
                        <x-text-input class="w-full"
                            name="package_code"
                            value="{{ old('package_code', $package->package_code) }}" />
                    </div>
                     <div>
                        <label class="font-bold text-sm">Package Description</label>
                        <x-text-input class="w-full"
                            name="package_description"
                            value="{{ old('package_description', $package->package_description) }}" />
                    </div>

                    <div>
                        <label class="font-bold text-sm">Price</label>
                        <x-text-input class="w-full"
                            name="package_price"
                            value="{{ old('package_price', $package->package_price) }}" />
                    </div>

                    <div>
                        <label class="font-bold text-sm">Limit</label>
                        <x-text-input class="w-full"
                            name="package_limit"
                            value="{{ old('package_limit', $package->package_limit) }}" />
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <button class="bg-indigo-600 text-white px-8 py-3 rounded-lg font-bold">
                        Update Package
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
