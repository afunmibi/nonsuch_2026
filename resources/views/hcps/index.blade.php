<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold leading-tight text-gray-800">
                {{ __('Health Care Providers (HCPs)') }}
            </h2>
            <a href="{{ route('hcps.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Add New HCP
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-200">
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">S/N</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Provider Details</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Location & Contact</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Banking Info</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach ($hcps as $index => $hcp)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-900">{{ $hcp->hcp_name }}</div>
                                        <div class="text-xs text-indigo-600 font-medium">{{ $hcp->hcp_code }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-700">{{ $hcp->hcp_location }}</div>
                                        <div class="text-xs text-gray-500">{{ $hcp->hcp_contact }} | {{ $hcp->hcp_email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 font-mono">{{ $hcp->hcp_account_number }}</div>
                                        <div class="text-[10px] uppercase text-gray-400 font-bold">{{ $hcp->hcp_bank_name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end items-center space-x-3">
                                            <a href="{{ route('hcps.show', $hcp) }}" class="text-blue-600 hover:text-blue-900 bg-blue-50 px-2 py-1 rounded">View</a>
                                            <a href="{{ route('hcps.edit', $hcp) }}" class="text-green-600 hover:text-green-900 bg-green-50 px-2 py-1 rounded">Edit</a>
                                            
                                            <form action="{{ route('hcps.destroy', $hcp) }}" method="POST" onsubmit="return confirm('Delete this HCP?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 px-2 py-1 rounded">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($hcps->hasPages())
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                        {{ $hcps->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
