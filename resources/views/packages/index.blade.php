<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Packages') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold">Packages List</h1>
                    <a href="{{ route('packages.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        + Add New Package
                    </a>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto border-collapse border border-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="border p-3 text-left">ID</th>
                                <th class="border p-3 text-left">Name</th>
                                <th class="border p-3 text-left">Description</th>
                                <th class="border p-3 text-left">Code</th>
                                <th class="border p-3 text-left">Price</th>
                                <th class="border p-3 text-left">Limit</th>
                                <th class="border p-3 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($packages as $package)
                            <tr class="hover:bg-gray-50">
                                <td class="border p-3">{{ $package->id }}</td>
                                <td class="border p-3 font-semibold">{{ $package->package_name }}</td>
                                <td class="border p-3 text-gray-600">{{ $package->package_description }}</td>
                                <td class="border p-3">{{ $package->package_code }}</td>
                                <td class="border p-3">N{{ number_format($package->package_price, 2) }}</td>
                                <td class="border p-3">N{{ number_format($package->package_limit, 2) }}</td>
                                <td class="border p-3 text-center">
                                    <div class="flex justify-center space-x-2">
                                        <a href="{{ route('packages.show', $package->id) }}" class="text-blue-600 hover:underline">View</a>
                                        <span class="text-gray-300">|</span>
                                        <a href="{{ route('packages.edit', $package->id) }}" class="text-yellow-600 hover:underline">Edit</a>
                                        <span class="text-gray-300">|</span>
                                        <form action="{{ route('packages.destroy', $package->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
    </div>
</x-app-layout>