<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">{{ __('New Member Enrolment') }}</h2>
    </x-slot>

    <div class="py-12 bg-gray-50" x-data="{
        depCount: 0,
        selectedPackage: '',
        selectedHcp: '',
        packages: @js($packages),
        hcps: @js($hcps),
        get pkg() { return this.packages.find(p => p.package_code === this.selectedPackage) || {} },
        get hcp() { return this.hcps.find(h => h.hcp_name === this.selectedHcp) || {} }
    }">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-xl shadow-sm">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <span class="font-bold">Please correct the following errors:</span>
                    </div>
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('enrolments.store') }}" enctype="multipart/form-data" class="space-y-8">
                @csrf

                <div class="bg-white p-8 shadow-sm rounded-xl border border-gray-200">
                    <div class="flex items-center mb-6 border-b pb-4">
                        <div class="bg-blue-600 p-2 rounded-lg mr-4 text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">Registration Details</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <x-input-label for="organization_name" value="Organization / Employer Name" />
                            <x-text-input name="organization_name" class="w-full mt-1" :value="old('organization_name')" required />
                        </div>

                        <div>
                            <x-input-label value="Full Name (Principal)" />
                            <x-text-input name="full_name" class="w-full mt-1" :value="old('full_name')" required />
                        </div>

                        <div>
                            <x-input-label value="Date of Birth" />
                            <x-text-input type="date" name="dob" class="w-full mt-1" :value="old('dob')" required />
                        </div>

                        <div>
                            <x-input-label value="Phone Number" />
                            <x-text-input name="phone_no" class="w-full mt-1" :value="old('phone_no')" required />
                        </div>

                        <div>
                            <x-input-label value="Email Address" />
                            <x-text-input type="email" name="email" class="w-full mt-1" :value="old('email')" required />
                        </div>

                        <div class="md:col-span-2">
                            <x-input-label value="Residential Address" />
                            <textarea name="address" rows="3" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500" required>{{ old('address') }}</textarea>
                        </div>

                        <div>
                            <x-input-label value="Location (State/City)" />
                            <x-text-input name="location" class="w-full mt-1" :value="old('location')" required />
                        </div>

                        <div>
                            <x-input-label value="Principal Photograph" />
                            <input type="file" name="photograph" class="mt-1 block w-full text-sm text-gray-500" required />
                        </div>
                    </div>
                </div>

                <div class="bg-blue-700 p-8 shadow-lg rounded-xl text-white">
                    <h3 class="text-xl font-bold border-b border-blue-500 pb-4 mb-6">Health Plan & Provider</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                         <div class="md:col-span-2">
                            <label class="block text-sm font-bold mb-1">Primary Hospital (HCP)</label>
                            <select name="pry_hcp" x-model="selectedHcp" class="w-full rounded-md border-none text-gray-900" required>
                                <option value="">-- Select Hospital --</option>
                                @foreach($hcps as $hcp)
                                    <option value="{{ $hcp->hcp_name }}">{{ $hcp->hcp_name }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="pry_hcp_code" :value="hcp.hcp_code">
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-1">Select Package Code</label>
                            <select name="package_code" x-model="selectedPackage" class="w-full rounded-md border-none text-gray-900" required>
                                <option value="">-- Select Package --</option>
                                @foreach($packages as $package)
                                    <option value="{{ $package->package_code }}">{{ $package->package_code }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-3 grid grid-cols-1 md:grid-cols-3 gap-6 bg-blue-800 p-4 rounded-lg">
                            <div>
                                <span class="text-xs uppercase text-blue-300">Package Description</span>
                                <div class="text-sm font-medium" x-text="pkg.package_description || '---'"></div>
                                <input type="hidden" name="package_description" :value="pkg.package_description">
                            </div>
                            <div>
                                <span class="text-xs uppercase text-blue-300">Annual Cost</span>
                                <div class="text-lg font-bold">₦ <span x-text="pkg.package_price || '0.00'"></span></div>
                                <input type="hidden" name="package_price" :value="pkg.package_price">
                            </div>
                            <div>
                                <span class="text-xs uppercase text-blue-300">Medical Limit</span>
                                <div class="text-lg font-bold">₦ <span x-text="pkg.package_limit || '0.00'"></span></div>
                                <input type="hidden" name="package_limit" :value="pkg.package_limit">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 shadow-sm rounded-xl border border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold text-gray-800">Family Dependants</h3>
                        <button type="button" @click="if(depCount < 4) depCount++" class="bg-green-600 text-white px-4 py-2 rounded-lg font-bold text-sm hover:bg-green-700 transition">
                            + Add Dependant
                        </button>
                    </div>

                    <template x-if="depCount === 0">
                        <p class="text-center text-gray-400 py-4 italic border-2 border-dashed rounded-lg">No dependants added. Click "Add Dependant" to register family members.</p>
                    </template>

                    @for ($i = 1; $i <= 4; $i++)
                    <div x-show="depCount >= {{ $i }}" x-transition class="mb-8 p-6 border border-gray-100 bg-gray-50 rounded-xl relative">
                        <button type="button" @click="depCount = {{ $i - 1 }}" class="absolute top-4 right-4 text-gray-400 hover:text-red-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>

                        <h4 class="text-blue-600 font-bold mb-4 uppercase text-xs tracking-widest">Dependant #{{ $i }}</h4>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div class="md:col-span-2">
                                <x-input-label value="Full Name" />
                                <input type="text" name="dependants_{{ $i }}_name" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                            </div>
                            <div>
                                <x-input-label value="Date of Birth" />
                                <input type="date" name="dependants_{{ $i }}_dob" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                            </div>
                            <div>
                                <x-input-label value="Status (e.g. Spouse/Child)" />
                                <input type="text" name="dependants_{{ $i }}_status" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                            </div>
                            <div class="md:col-span-4 mt-2">
                                <x-input-label value="Dependant Photo" />
                                <input type="file" name="dependants_{{ $i }}_photograph" class="mt-1 text-sm text-gray-500">
                            </div>
                        </div>
                    </div>
                    @endfor
                </div>

                <div class="flex items-center justify-between p-6 bg-white rounded-xl border border-gray-200">
                    <span class="text-sm text-gray-500 italic">Review all information before submitting. Policy number will be generated automatically.</span>
                    <div class="flex space-x-4">
                        <button type="reset" class="px-6 py-2 bg-gray-100 text-gray-600 rounded-lg font-bold hover:bg-gray-200">Clear</button>
                        <button type="submit" class="px-10 py-2 bg-blue-600 text-white rounded-lg font-bold shadow-lg hover:bg-blue-700 transition transform active:scale-95">
                            Submit Enrolment
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
