<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">{{ __('New Member Enrolment') }}</h2>
    </x-slot>
    <div class="py-12 bg-gray-50" x-data="{
        depCount: 0,
        selectedPackage: '',
        selectedHcp: '',
        packages: {{ $packages->toJson() }},
        hcps: {{ $hcps->toJson() }},
        get pkg() { return this.packages.find(p => p.package_code === this.selectedPackage) || {} },
        get hcp() { return this.hcps.find(h => h.hcp_pry_code === this.selectedHcp) || {} }
    }">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('enrolments.store') }}" enctype="multipart/form-data" class="space-y-8">
                @csrf
                <div class="bg-white p-8 shadow-lg rounded-xl">
                    <h3 class="text-xl font-bold border-b border-gray-200 pb-4 mb-6">Member Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div></div>
                            <label class="block text-sm font-bold mb-1">Full Name</label>
                        <div></div>
                            <x-input-label for="full_name" value="Full Name" />
                            <x-text-input name="full_name" class="w-full mt-1" required /></div>
                        <div></div>
                            <label class="block text-sm font-bold mb-1">Policy Number</label>
                        <div></div>
                            <x-input-label for="policy_no" value="Policy Number" />
                            <x-text-input name="policy_no" class="w-full mt-1" required /></div>
                        <div></div>
                            <label class="block text-sm font-bold mb-1">Date of Birth</label>
                        <div></div>
                            <x-input-label for="dob" value="Date of Birth" />
                            <x-text-input type="date" name="dob" class="w-full mt-1" required /></div>
                        <div></div>
                            <label class="block text-sm font-bold mb-1">Email Address</label>
                        <div></div>
                            <x-input-label for="email" value="Email Address" />
                            <x-text-input type="email" name="email" class="w-full mt-1" required /></div>
                        <div></div>
                            <label class="block text-sm font-bold mb-1">Phone Number</label>
                        <div></div>
                            <x-input-label for="phone" value="Phone Number" />
                            <x-text-input name="phone" class="w-full mt-1 " required /></div>
                    </div>
                </div>
                <div class="bg-white p-8 shadow-lg rounded-xl">
                    <h3 class="text-xl font-bold border-b border-gray-200 pb-4 mb-6">Health Plan & Provider</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold mb-1">Primary Hospital (HCP)</label>
                            <select name="pry_hcp" x-model="selectedH       cp" class="w-full rounded-md border-none text-gray-900" required>
                                <option value="">-- Select Hospital --</option>
                                @foreach($hcps as $hcp)
                                    <option value="{{ $hcp->hcp_name }}">{{ $hcp->hcp_name }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="pry_hcp_code" :value="pkg.hcp_pry_code">
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-1">Select Package Code</label>
                            <select name="package_code" x-model="selectedPackage" class="w-full rounded-md border-none text-gray-900" required>
                                <option value="">-- Select Package --</option>
                                @foreach($packages as $package)
                                    <option value="{{ $package->package_code }}">{{ $package->package_code }} - {{ $package->package_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div></div>
                            <span class="text-xs uppercase text-blue-300">Annual Cost</span>
                            <div class="text-lg font-bold">₦ <span x-text="pkg.package_price || '0.00'"></span></div>
                            <input type="hidden" name="package_price" :value="pkg.package_price">
                        </div>
                    </div>
                </div>
                <div class="bg-white p-8 shadow-lg rounded-xl">
                    <h3 class="text-xl font-bold border-b border-gray-200 pb-4 mb-6">Dependents Information</h3>
                    <div class="space-y-6">
                        <template x-for="i in depCount" :key="i">
                            <div class="border border-gray-300 p-4 rounded-lg"></div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-bold mb-1">Dependent Name</label>
                                        <x-text-input type="text" name="dependent_name[]" class="w-full mt-1" required />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold mb-1">Date of Birth</label>
                                        <x-text-input type="date" name="dependent_dob[]" class="w-full mt-1" required />
                                    </div>
                                </div>
                            </div>
                        </template>
                        <div class="flex space-x-4">
                            <button type="button" @click="depCount++" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">+ Add Dependent</button>
                            <button type="button" @click="if(depCount > 0) depCount--" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">- Remove Dependent</button>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-8 shadow-lg rounded-xl">
                    <h3 class="text-xl font-bold border-b border-gray-200 pb-4 mb-6">Supporting Documents</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold mb-1">Upload ID Document (e.g., Driver's License, Passport)</label>
                            <input type="file" name="id_document" class="w-full mt-1 border-gray-300 rounded-lg shadow-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-1">Upload Proof of Address (e.g., Utility Bill, Bank Statement)</label>
                            <input type="file" name="proof_of_address" class="w-full mt-1 border-gray-300 rounded-lg shadow-sm" required>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('enrolments.index') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Submit Enrolment</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
