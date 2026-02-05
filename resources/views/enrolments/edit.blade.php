<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">{{ __('Edit Member Enrolment') }}</h2>
    </x-slot>

    {{-- update enrolment form --}}
    <div class="py-12 bg-gray-50" x-data="{
        depCount: 0,
        selectedPackage: '{{ $enrolment->package_code ?? '' }}',
        selectedHcp: '{{ $enrolment->pry_hcp ?? '' }}',
        packages: @js($packages),
        hcps: @js($hcps),
        pkg: {
            package_description: '{{ $enrolment->package_description ?? '' }}',
            package_price: '{{ $enrolment->package_price ?? '0.00' }}',
            package_limit: '{{ $enrolment->package_limit ?? '0.00' }}',
            hcp_pry_code: ''
        },

        init() {
            this.$watch('selectedPackage', (value) => {
                if (value) {
                    this.updatePackageDetails(value);
                }
            });

            // Initialize package details on load
            if (this.selectedPackage) {
                this.updatePackageDetails(this.selectedPackage);
            }
        },

        updatePackageDetails(packageCode) {
            const selected = this.packages.find(p => p.package_code === packageCode);
            if (selected) {
                this.pkg = {
                    package_description: selected.package_description || '',
                    package_price: selected.package_price || '0.00',
                    package_limit: selected.package_limit || '0.00',
                    hcp_pry_code: selected.hcp_pry_code || ''
                };
            }
        }
    }">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('enrolments.update', $enrolment->id) }}" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')

                {{-- Member Information Section --}}
                <div class="bg-white p-8 shadow-lg rounded-xl">
                    <h3 class="text-xl font-bold border-b border-gray-200 pb-4 mb-6">Member Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold mb-1">Full Name</label>
                            <x-text-input name="full_name" class="w-full mt-1" :value="old('full_name', $enrolment->full_name)" required />
                            @error('full_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold mb-1">Policy Number</label>
                            <x-text-input name="policy_no" class="w-full mt-1" :value="old('policy_no', $enrolment->policy_no)" required />
                            @error('policy_no')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold mb-1">Date of Birth</label>
                            <x-text-input type="date" name="dob" class="w-full mt-1" :value="old('dob', $enrolment->dob)" required />
                            @error('dob')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold mb-1">Phone Number</label>
                            <x-text-input name="phone_no" class="w-full mt-1" :value="old('phone_no', $enrolment->phone_no)" required />
                            @error('phone_no')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold mb-1">Email Address</label>
                            <x-text-input type="email" name="email" class="w-full mt-1" :value="old('email', $enrolment->email)" required />
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold mb-1">Address</label>
                            <textarea name="address" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" rows="3" required>{{ old('address', $enrolment->address) }}</textarea>
                            @error('address')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Health Plan & Provider Section --}}
                <div class="bg-blue-700 p-8 shadow-lg rounded-xl text-white">
                    <h3 class="text-xl font-bold border-b border-blue-500 pb-4 mb-6">Health Plan & Provider</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold mb-1">Primary Hospital (HCP)</label>
                            <select x-model="selectedHcp" class="w-full rounded-md border-none text-gray-900" required>
                                <option value="">-- Select Hospital --</option>
                                @foreach($hcps as $hcp)
                                    <option value="{{ $hcp->hcp_name }}">{{ $hcp->hcp_name }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="pry_hcp" :value="selectedHcp">
                            @error('pry_hcp')
                                <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold mb-1">Select Package Code</label>
                            <select x-model="selectedPackage" class="w-full rounded-md border-none text-gray-900" required>
                                <option value="">-- Select Package --</option>
                                @foreach($packages as $package)
                                    <option value="{{ $package->package_code }}">
                                        {{ $package->package_code }} - {{ $package->package_name }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="hidden" name="package_code" :value="selectedPackage">
                            @error('package_code')
                                <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Package Details Display --}}
                        <div class="md:col-span-3 grid grid-cols-1 md:grid-cols-3 gap-6 bg-blue-800 p-4 rounded-lg">
                            <div>
                                <span class="text-xs uppercase text-blue-300">Package Description</span>
                                <div class="text-sm font-medium mt-1" x-text="pkg.package_description || '---'"></div>
                                <input type="hidden" name="package_description" :value="pkg.package_description">
                            </div>
                            <div>
                                <span class="text-xs uppercase text-blue-300">Annual Cost</span>
                                <div class="text-lg font-bold mt-1">₦ <span x-text="pkg.package_price || '0.00'"></span></div>
                                <input type="hidden" name="package_price" :value="pkg.package_price">
                            </div>
                            <div>
                                <span class="text-xs uppercase text-blue-300">Medical Limit</span>
                                <div class="text-lg font-bold mt-1">₦ <span x-text="pkg.package_limit || '0.00'"></span></div>
                                <input type="hidden" name="package_limit" :value="pkg.package_limit">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Submit Button --}}
                <div class="flex justify-between items-center">
                    <a href="{{ route('enrolments.index') }}" class="text-gray-600 hover:text-gray-800 font-medium">
                        ← Back to Enrolments
                    </a>
                    <x-primary-button class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg text-sm font-bold shadow-lg">
                        Update Enrolment
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
