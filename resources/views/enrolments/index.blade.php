<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800 leading-tight">{{ __('Enrolments') }}</h2>
            <a href="{{ route('enrolments.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-bold shadow">+ New Enrolment</a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('enrolments.index') }}" method="GET" class="mb-6 flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name or policy..." class="w-full md:w-1/3 border-gray-300 rounded-lg shadow-sm">
                <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-lg">Search</button>
            </form>

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 shadow-sm">{{ session('success') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Policy / Member</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Package</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase text-center">Dependants</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Price</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($enrolments as $enrolment)
                        @php
                            $depCount = 0;
                            for($i=1; $i<=4; $i++) {
                                if($enrolment->{"dependants_{$i}_name"}) $depCount++;
                            }
                        @endphp
                        <tr class="hover:bg-gray-50 transition border-b border-gray-100">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        @if($enrolment->photograph)
                                            <img class="h-10 w-10 rounded-full object-cover border-2 border-indigo-200" src="{{ asset('storage/' . $enrolment->photograph) }}" alt="">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-500">
                                                <i class="fas fa-user-tie"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-[10px] font-black font-mono text-blue-600 uppercase tracking-tighter">{{ $enrolment->policy_no }}</div>
                                        <div class="text-sm text-gray-900 font-black uppercase">{{ $enrolment->full_name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-gray-700">{{ $enrolment->package_code }}</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($depCount > 0)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-black bg-blue-100 text-blue-800">
                                        <i class="fas fa-users mr-1 text-[10px]"></i> {{ $depCount }}
                                    </span>
                                @else
                                    <span class="text-[10px] font-bold text-gray-300 uppercase tracking-widest">None</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm font-black text-gray-800">₦{{ number_format($enrolment->package_price, 2) }}</td>
                            <td class="px-6 py-4 text-right text-sm font-medium space-x-3">
                                <a href="{{ route('enrolments.show', $enrolment->id) }}" class="text-blue-600 hover:text-blue-800" title="View Details"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('enrolments.id-card', $enrolment->id) }}" target="_blank" class="text-indigo-600 hover:text-indigo-800" title="ID Card"><i class="fas fa-id-card"></i></a>
                                <a href="{{ route('enrolments.edit', $enrolment->id) }}" class="text-green-600 hover:text-green-800" title="Edit"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('enrolments.destroy', $enrolment->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete entire family record?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-400 hover:text-red-600" title="Delete"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
