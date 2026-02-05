<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">{{ __('New Member Enrolment') }}</h2>
    </x-slot>
{{-- show enrolment id --}}
            <a href="{{ route('enrolments.index') }}" class="mt-4 inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Back to Enrolments</a>
    <div class="py-12 bg-gray-50">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 shadow-lg rounded-xl space-y-6">
                <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
                    <h3 class="text-xl font-bold">Enrolment Details</h3>
                    <div class="flex gap-2">
                        <div x-data="{ 
                            copyLink() {
                                const link = '{{ route('feedback.create', ['policy_no' => $enrolment->policy_no]) }}';
                                navigator.clipboard.writeText(link).then(() => {
                                    $dispatch('notify', { message: 'Feedback Link Copied!', type: 'success' });
                                });
                            }
                        }">
                            <button @click="copyLink" 
                               class="bg-emerald-600 text-white px-4 py-2 rounded-lg text-xs font-black shadow-lg shadow-emerald-100 hover:scale-105 transition-all flex items-center gap-2">
                                <i class="fas fa-copy"></i> Copy Feedback Link
                            </button>
                        </div>
                        <a href="{{ route('enrolments.id-card', $enrolment->id) }}" target="_blank" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-xs font-black shadow-lg shadow-indigo-100 hover:scale-105 transition-all">
                            <i class="fas fa-id-card mr-2"></i> Print ID Cards
                        </a>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="md:col-span-2 space-y-6">
                        <div>
                            <h4 class="text-xs uppercase font-black text-blue-600 mb-4 tracking-widest border-b pb-1">Member Information</h4>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-[10px] text-gray-400 uppercase font-bold">Full Name</p>
                                    <p class="font-bold text-gray-800">{{ $enrolment->full_name }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-400 uppercase font-bold">Policy Number</p>
                                    <p class="font-mono font-bold text-blue-600">{{ $enrolment->policy_no }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-400 uppercase font-bold">Date of Birth</p>
                                    <p class="font-semibold text-gray-700">{{ $enrolment->dob }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-400 uppercase font-bold">Email Address</p>
                                    <p class="font-semibold text-gray-700">{{ $enrolment->email }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-400 uppercase font-bold">Phone Number</p>
                                    <p class="font-semibold text-gray-700">{{ $enrolment->phone_no }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-400 uppercase font-bold">Location</p>
                                    <p class="font-semibold text-gray-700">{{ $enrolment->location }}</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-xs uppercase font-black text-emerald-600 mb-4 tracking-widest border-b pb-1">Health Plan & Provider</h4>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-[10px] text-gray-400 uppercase font-bold">Primary Hospital (HCP)</p>
                                    <p class="font-bold text-gray-800">{{ $enrolment->pry_hcp }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-400 uppercase font-bold">Package Code</p>
                                    <p class="font-bold text-gray-800">{{ $enrolment->package_code }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-400 uppercase font-bold">Limit / Price</p>
                                    <p class="font-bold text-gray-800">₦{{ number_format($enrolment->package_limit, 2) }} / ₦{{ number_format($enrolment->package_price, 2) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 flex flex-col items-center justify-center">
                        <p class="text-[10px] text-gray-400 uppercase font-black mb-2 self-start">Principal Photo</p>
                        @if($enrolment->photograph)
                            <img src="{{ asset('storage/' . $enrolment->photograph) }}" alt="Member Photograph" class="w-full aspect-square object-cover rounded-lg shadow-md border-4 border-white">
                        @else
                            <div class="w-full aspect-square bg-gray-200 rounded-lg flex items-center justify-center text-gray-400">
                                <i class="fas fa-user-circle text-6xl"></i>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Dependants Section -->
                <div class="mt-12 pt-8 border-t border-gray-100">
                    <h3 class="text-xl font-black text-gray-800 mb-6 flex items-center gap-2">
                        <i class="fas fa-users text-blue-500"></i>
                        Family Dependants
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @for($i=1; $i<=4; $i++)
                            @php 
                                $name = "dependants_{$i}_name";
                                $dob = "dependants_{$i}_dob";
                                $status = "dependants_{$i}_status";
                                $photo = "dependants_{$i}_photograph";
                            @endphp

                            @if($enrolment->$name)
                                <div class="bg-white border rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow">
                                    <div class="relative mb-4">
                                        @if($enrolment->$photo)
                                            <img src="{{ asset('storage/' . $enrolment->$photo) }}" class="w-full h-40 object-cover rounded-lg">
                                        @else
                                            <div class="w-full h-40 bg-slate-100 rounded-lg flex items-center justify-center text-slate-300">
                                                <i class="fas fa-user text-4xl"></i>
                                            </div>
                                        @endif
                                        <span class="absolute top-2 right-2 bg-blue-600 text-white text-[10px] font-black px-2 py-1 rounded shadow-sm">
                                            {{ strtoupper($enrolment->$status) }}
                                        </span>
                                    </div>
                                    <p class="text-sm font-bold text-gray-800 leading-tight mb-1">{{ $enrolment->$name }}</p>
                                    <p class="text-[11px] text-gray-400 flex items-center gap-1">
                                        <i class="fas fa-calendar-alt text-[10px]"></i>
                                        {{ $enrolment->$dob }}
                                    </p>
                                </div>
                            @elseif($i == 1)
                                <div class="col-span-full py-8 text-center bg-gray-50 rounded-xl border-2 border-dashed">
                                    <p class="text-gray-400 italic font-medium">No dependants registered for this principal.</p>
                                </div>
                            @endif
                        @endfor
                    </div>
                </div>

                <div class="mt-8 p-4 bg-indigo-50 border-l-4 border-indigo-400 text-indigo-700 flex items-center gap-3">
                    <i class="fas fa-info-circle text-lg"></i>
                    <p class="text-xs font-bold">This enrolment record is active. Ensure all dependant details are verified for claim processing.</p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
