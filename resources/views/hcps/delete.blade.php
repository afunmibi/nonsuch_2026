<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('HCPs') }}
        </h2>
    </x-slot>
    {{-- delete hcp details --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 overflow-hidden shadow-sm sm:rounded-lg">
                <form action="{{ route('hcps.destroy', $hcp->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <p class="mb-4 text-red-600">Are you sure you want to delete the HCP: <strong>{{ $hcp->hcp_name }}</strong>?</p>
                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Yes, Delete HCP
                        </button>
                        <a href="{{ route('hcps.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
  