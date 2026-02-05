<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold leading-tight text-gray-800">
            {{ __('Log New Medical Request') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-gray-50/50" x-data="medicalRequestForm()">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Error Alerts --}}
            <div class="space-y-4 mb-6">
                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm">
                        <div class="flex">
                            <svg class="h-5 w-5 text-red-400 mr-3" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                            <div>
                                <p class="text-sm text-red-700 font-bold">Validation Failed</p>
                                <ul class="mt-1 list-disc list-inside text-xs text-red-600">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            {{-- Database/General Error Alerts --}}
@if (session('error'))
    <div class="bg-amber-50 border-l-4 border-amber-500 p-4 rounded-r-lg shadow-sm mb-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-amber-700 font-bold">System Error</p>
                <p class="text-xs text-amber-600">{{ session('error') }}</p>
            </div>
        </div>
    </div>
@endif

            <form method="POST" action="{{ route('logRequests.store') }}" class="space-y-8">
                @csrf
                <input type="hidden" name="staff_id" value="{{ auth()->id() }}">

                {{-- Section 1: Member Search --}}
                <div class="bg-white p-6 shadow-sm rounded-xl border border-gray-200">
                    <div class="flex items-center justify-between gap-3 mb-6 border-b border-gray-100 pb-4">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-indigo-50 rounded-lg text-indigo-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800">Member Verification</h3>
                        </div>

                        {{-- Exception Toggle --}}
                        <label class="flex items-center cursor-pointer group">
                            <div class="relative">
                                <input type="checkbox" x-model="manualEntry" name="is_exception" value="1" class="sr-only">
                                <div class="w-10 h-4 bg-gray-200 rounded-full shadow-inner transition-colors" :class="manualEntry ? 'bg-rose-400' : 'bg-gray-200'"></div>
                                <div class="absolute -left-1 -top-1 w-6 h-6 bg-white rounded-full shadow border border-gray-200 transition-transform flex items-center justify-center" :class="manualEntry ? 'translate-x-6 border-rose-400' : ''">
                                    <div class="w-2 h-2 rounded-full" :class="manualEntry ? 'bg-rose-500' : 'bg-gray-300'"></div>
                                </div>
                            </div>
                            <span class="ml-4 text-xs font-black uppercase tracking-widest transition-colors" :class="manualEntry ? 'text-rose-600' : 'text-gray-400'">Manual Exception</span>
                        </label>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="relative" :class="manualEntry ? 'opacity-50 pointer-events-none' : ''">
                            <label class="block text-xs font-bold uppercase text-gray-400 mb-1 tracking-wider">Policy Number</label>
                            <div class="flex gap-2">
                                <x-text-input 
                                    x-model="policyNo" 
                                    name="policy_no" 
                                    class="flex-1 bg-indigo-50/30 border-indigo-100 focus:ring-indigo-500 font-mono" 
                                    placeholder="e.g. WB-001/..." 
                                    ::required="!manualEntry" 
                                />
                                <button type="button" @click="fetchEnrolmentData(policyNo)" 
                                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition flex items-center">
                                    <span x-show="!loading">Verify</span>
                                    <svg x-show="loading" class="animate-spin h-4 w-4 text-white" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                </button>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-400 mb-1 tracking-wider">Full Patient Name</label>
                            <x-text-input name="full_name" class="w-full bg-gray-50 border-gray-200 font-semibold text-gray-700" 
                                x-model="fullName" 
                                ::class="manualEntry ? 'bg-white border-rose-100' : 'bg-gray-50'"
                                ::readonly="!manualEntry" 
                                required />
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-400 mb-1 tracking-wider">Contact Phone</label>
                            <x-text-input name="phone_no" class="w-full border-gray-200" 
                                x-model="phoneNo"
                                ::class="manualEntry ? 'bg-white border-rose-100' : 'bg-gray-50'"
                                ::readonly="!manualEntry" 
                                required />
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-400 mb-1 tracking-wider">Date of Birth</label>
                            <x-text-input type="date" name="dob" class="w-full border-gray-200" 
                                x-model="dob"
                                ::class="manualEntry ? 'bg-white border-rose-100' : 'bg-gray-50'"
                                ::readonly="!manualEntry" 
                                required />
                        </div>
                    </div>
                </div>

                {{-- Section 2: Health Plan --}}
                <div class="bg-indigo-600 p-6 shadow-lg rounded-xl text-white transform transition-all">
                    <div class="flex items-center gap-3 mb-6 border-b border-indigo-400/50 pb-4">
                        <div class="p-2 bg-indigo-500 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                        </div>
                        <h3 class="text-lg font-bold uppercase tracking-tight">Authorization Details</h3>
                    </div>

                    {{-- Hidden Fields: Using x-model with Alpine data ensures these are never empty --}}
                    <input type="hidden" name="pry_hcp_code" x-model="pryHcp.hcp_code">
                    <input type="hidden" name="sec_hcp_code" x-model="secHcp.hcp_code">
                    <input type="hidden" name="package_description" x-model="pkg.package_name">
                    <input type="hidden" name="package_price" x-model="pkg.package_price">
                    <input type="hidden" name="package_limit" x-model="pkg.package_limit">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-900">
                        <div class="space-y-1">
                            <label class="block text-[10px] font-black uppercase text-indigo-100 tracking-widest">Primary Provider (Referring)</label>
                            <select x-model="selectedPryHcp" name="pry_hcp" class="w-full rounded-lg border-none shadow-inner h-12 focus:ring-2 focus:ring-white transition" required>
                                <option value="">-- Choose Hospital --</option>
                                <template x-for="h in hcps" :key="h.id">
                                    <option :value="h.hcp_name" x-text="h.hcp_name"></option>
                                </template>
                            </select>
                        </div>

                        <div class="space-y-1">
                            <label class="block text-[10px] font-black uppercase text-indigo-100 tracking-widest">Plan Type / Package</label>
                            <select x-model="selectedPackage" name="package_code" class="w-full rounded-lg border-none shadow-inner h-12 focus:ring-2 focus:ring-white transition" required>
                                <option value="">-- Choose Plan --</option>
                                <template x-for="p in packages" :key="p.id">
                                    <option :value="p.package_code" x-text="p.package_code + ' (' + p.package_name + ')'"></option>
                                </template>
                            </select>
                        </div>

                        <div class="md:col-span-2 space-y-1">
                            <label class="block text-[10px] font-black uppercase text-indigo-100 tracking-widest">Secondary Provider (Receiving Services)</label>
                            <select x-model="selectedSecHcp" name="sec_hcp" class="w-full rounded-lg border-none shadow-inner h-12 focus:ring-2 focus:ring-white transition" required>
                                <option value="">-- Choose Referral Point --</option>
                                <template x-for="h in hcps" :key="h.id">
                                    <option :value="h.hcp_name" x-text="h.hcp_name"></option>
                                </template>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Section 3: Medical Case --}}
                <div class="bg-white p-6 shadow-sm rounded-xl border border-gray-200">
                    <div class="flex items-center gap-3 mb-6 border-b border-gray-100 pb-4">
                        <div class="p-2 bg-rose-50 rounded-lg text-rose-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">Clinical Presentation</h3>
                    </div>

                    <div class="space-y-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-bold uppercase text-gray-400 mb-1 tracking-wider">Diagnosis Selection</label>
                                <select x-model="selectedDiagnosisCode" class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">-- Select Diagnosis Code --</option>
                                    <template x-for="d in diagnoses" :key="d.id">
                                        <option :value="d.diag_code" x-text="d.diag_code + ' - ' + d.diagnosis"></option>
                                    </template>
                                </select>
                                <input type="hidden" name="diag_code" x-model="selectedDiagnosisCode">
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-gray-400 mb-1 tracking-wider">Clinical Diagnosis</label>
                                <textarea name="diagnosis" x-model="diagnosisText" class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 min-h-[80px]" placeholder="Primary diagnosis..." required></textarea>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-bold uppercase text-gray-400 mb-1 tracking-wider">Treatment Plan</label>
                                <textarea name="treatment_plan" x-model="treatmentPlanText" class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 min-h-[80px]" placeholder="Drugs, surgeries, or procedures..." required></textarea>
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-gray-400 mb-1 tracking-wider">Further Investigations</label>
                                <textarea name="further_investigation" class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 min-h-[80px]" placeholder="Lab tests, scans etc..." required>{{ old('further_investigation') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex flex-col sm:flex-row justify-between items-center gap-6 pt-4">
                    <a href="{{ route('logRequests.index') }}" class="text-gray-400 font-bold hover:text-gray-600 transition flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                        Back to List
                    </a>
                    <button type="submit" class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white px-16 py-4 rounded-2xl font-black shadow-xl shadow-indigo-200 transition-all hover:-translate-y-1 active:scale-95">
                        Submit for Authorization
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function medicalRequestForm() {
            return {
                policyNo: @js(old("policy_no", "")),
                fullName: @js(old("full_name", "")),
                phoneNo: @js(old("phone_no", "")),
                dob: @js(old("dob", "")),
                manualEntry: @js(old("is_exception", false) == "1"),
                selectedPackage: @js(old("package_code", "")),
                selectedPryHcp: @js(old("pry_hcp", "")),
                selectedSecHcp: @js(old("sec_hcp", "")),
                selectedDiagnosisCode: @js(old("diag_code", "")),
                diagnosisText: @js(old("diagnosis", "")),
                treatmentPlanText: @js(old("treatment_plan", "")),
                packages: @js($packages),
                hcps: @js($hcps),
                diagnoses: @js($diagnoses),
                enrolment: null,
                loading: false,

                // Initialize with old values or defaults
                pkg: { 
                    package_name: @js(old('package_description', '')), 
                    package_price: @js(old('package_price', 0)), 
                    package_limit: @js(old('package_limit', 0)) 
                    },
                pryHcp: { hcp_code: @js(old('pry_hcp_code', '')) },
                secHcp: { hcp_code: @js(old('sec_hcp_code', '')) },

                init() {
                    // Fetch enrolment if policy number exists and not in manual entry mode
                    if (this.policyNo.length >= 5 && !this.manualEntry) {
                        this.fetchEnrolmentData(this.policyNo);
                    }

                    // If a package was already selected, make sure the description object is filled
                    this.updatePackageData(this.selectedPackage);
                    this.updatePryHcpData(this.selectedPryHcp);
                    this.updateSecHcpData(this.selectedSecHcp);

                    // Watchers for changes
                    this.$watch('selectedPackage', v => this.updatePackageData(v));
                    this.$watch('selectedPryHcp', v => this.updatePryHcpData(v));
                    this.$watch('selectedSecHcp', v => this.updateSecHcpData(v));
                    this.$watch('selectedDiagnosisCode', v => this.updateDiagnosisData(v));
                    this.$watch('manualEntry', v => {
                        if(v) {
                            this.enrolment = null;
                            // Optionally clear policyNo if manual is toggled on? 
                            // Usually better to leave it in case of accidental click
                        }
                    });
                },

                updateDiagnosisData(code) {
                    const found = this.diagnoses.find(d => d.diag_code === code);
                    if (found) {
                        this.diagnosisText = found.diagnosis;
                        this.treatmentPlanText = found.treatment_plan;
                    }
                },

                updatePackageData(code) {
                    const found = this.packages.find(p => p.package_code === code);
                    this.pkg = found ? { 
                        package_name: found.package_name, 
                        package_price: found.package_price, 
                        package_limit: found.package_limit 
                    } : { package_name: '', package_price: 0, package_limit: 0 };
                },

                updatePryHcpData(name) {
                    const found = this.hcps.find(h => h.hcp_name === name);
                    this.pryHcp = found ? { hcp_code: found.hcp_code || found.hcp_pry_code } : { hcp_code: '' };
                },

                updateSecHcpData(name) {
                    const found = this.hcps.find(h => h.hcp_name === name);
                    this.secHcp = found ? { hcp_code: found.hcp_code || found.hcp_pry_code } : { hcp_code: '' };
                },

                async fetchEnrolmentData(policyNumber) {
                    if (!policyNumber || this.manualEntry) return;
                    this.loading = true;
                    
                    try {
                        const url = `/api/enrolments/policy/${encodeURIComponent(policyNumber)}`;
                        const response = await fetch(url, {
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });
                        
                        if (response.ok) {
                            const data = await response.json();
                            this.enrolment = data;
                            
                            // Map fetched data to our model values
                            this.fullName = data.full_name;
                            this.phoneNo = data.phone_no;
                            this.dob = data.dob;

                            // Pre-fill fields from enrolment if they aren't already set by 'old' data
                            if(!this.selectedPackage) this.selectedPackage = data.package_code;
                            if(!this.selectedPryHcp) this.selectedPryHcp = data.pry_hcp;
                        } else {
                            this.enrolment = null;
                            this.fullName = '';
                            this.phoneNo = '';
                            this.dob = '';
                        }
                    } catch (error) { 
                        console.error('Fetch error:', error); 
                    } finally { 
                        this.loading = false; 
                    }
                }
            }
        }
    </script>
</x-app-layout>