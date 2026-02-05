<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Medical Log Requests') }}
            </h2>
            <a href="{{ route('logRequests.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                + New Request
            </a>
        </div>
    </x-slot>
  {{-- delete details here i only delete data --}}
    <div class="py-12 bg-gray-50">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 shadow-lg rounded-xl space-y-6">
                <h3 class="text-xl font-bold border-b border-gray-200 pb-4 mb-6">Delete Log Request</h3>
                <p class="text-red-600 font-semibold">Are you sure you want to delete this log request?</p>
                <form action="{{ route('logRequests.destroy', $logRequest->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this log request?');">
                    @csrf
                    @method('DELETE')
                    <div class="mt-4">
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-bold shadow">Delete</button>
                        <a href="{{ route('logRequests.index') }}" class="ml-4 bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg font-bold shadow">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

