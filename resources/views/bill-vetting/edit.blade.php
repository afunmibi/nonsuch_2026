<x-app-layout>
<style>
    [x-cloak]{display:none}
    .glass-panel { @apply bg-white/90 backdrop-blur-sm border border-slate-200 shadow-sm rounded-2xl; }
    .input-field { @apply w-full text-xs px-3 py-2 rounded-lg border border-slate-300 bg-white focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all font-medium text-slate-700; }
    .table-header { @apply text-[10px] uppercase text-slate-400 font-bold py-2 px-3 border-b-2 border-slate-200 bg-gradient-to-b from-slate-50 to-slate-100; }
    .table-cell { @apply py-1.5 px-1 border-b border-slate-100 align-middle; }
    .num-input { @apply text-right font-mono text-slate-700; }
    .readonly-field { @apply bg-transparent border-transparent text-slate-500 font-mono text-right cursor-default focus:ring-0; }
    .claimed-input { @apply bg-emerald-50/50 border-emerald-200 text-emerald-700 focus:ring-emerald-500/20 focus:border-emerald-500; }
    .compact-input { @apply w-full text-[11px] px-1.5 py-1 rounded border border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-indigo-500 transition-all font-medium text-slate-700; }
    .card-label { @apply text-[9px] uppercase font-bold text-slate-400 tracking-wider mb-1 block; }
    .info-card { @apply bg-gradient-to-br from-white to-slate-50 rounded-xl border-2 border-slate-200 p-4 shadow-lg hover:shadow-xl transition-all; }
    .info-card-icon { @apply h-12 w-12 rounded-xl flex items-center justify-center text-xl mb-3; }
</style>

<script>
    // 1. Prepare data in a safe way (PHP -> Global JS Variable)
    window.__BILL_VETTING_DATA__ = {
        isNewEntry: {{ (isset($billVetting) && $billVetting->pa_code) ? 'false' : 'true' }},
        billData: {!! json_encode($billVetting ?? new \stdClass()) !!},
        initialServices: {!! json_encode($vettedServices ?? []) !!}.map(s => ({...s, total_hcp_amount_claimed: s.hcp_amount_claimed_total_services || s.total_hcp_amount_claimed || 0})),
        initialDrugs: {!! json_encode($vettedDrugs ?? []) !!}.map(d => ({...d, total_hcp_amount_claimed: d.hcp_amount_claimed_total_drugs || d.total_hcp_amount_claimed || 0})),
        routes: {
            search: "{{ url('bill-vetting/search-pa') }}",
            store: "{{ route('bill-vetting.store') }}",
            index: "{{ route('bill-vetting.index') }}"
        }
    };

    /**
     * 2. Define the component function
     */
    function billVettingApp(initialState) {
        return {
            isNewEntry: initialState.isNewEntry,
            searchPaCode: '',
            fetchMessage: '',
            form: {
                pa_code: initialState.billData.pa_code || '',
                full_name: initialState.billData.full_name || '',
                policy_no: initialState.billData.policy_no || '',
                dob: initialState.billData.dob || '',
                phone_no: initialState.billData.phone_no || '',
                package_code: initialState.billData.package_code || '',
                package_description: initialState.billData.package_description || '',
                package_price: initialState.billData.package_price || 0,
                package_limit: initialState.billData.package_limit || 0,
                pry_hcp: initialState.billData.pry_hcp || '',
                pry_hcp_code: initialState.billData.pry_hcp_code || '',
                sec_hcp: initialState.billData.sec_hcp || '',
                sec_hcp_code: initialState.billData.sec_hcp_code || '',
                diagnosis: initialState.billData.diagnosis || '',
                treatment_plan: initialState.billData.treatment_plan || '',
                further_investigation: initialState.billData.further_investigation || '',
                billing_month: initialState.billData.billing_month || new Date().toISOString().slice(0, 7),
                admission_date: initialState.billData.admission_date || '',
                discharge_date: initialState.billData.discharge_date || '',
                admission_days: initialState.billData.admission_days || 0,
                monitoring: initialState.billData.monitoring || null
            },
            services: initialState.initialServices || [],
            drugs: initialState.initialDrugs || [],

            prefetchPatientData() {
                if (!this.searchPaCode) {
                    alert('Please enter a PA Code');
                    return;
                }
                this.fetchMessage = 'Searching...';
                axios.get(`${initialState.routes.search}/${this.searchPaCode}`)
                    .then(res => {
                        if (res.data.success) {
                            const p = res.data.data;
                            this.form.pa_code = p.pa_code || '';
                            this.form.full_name = p.full_name || '';
                            this.form.policy_no = p.policy_no || '';
                            this.form.dob = p.dob || '';
                            this.form.phone_no = p.phone_no || '';
                            this.form.package_code = p.package_code || '';
                            this.form.package_description = p.package_description || '';
                            this.form.package_price = p.package_price || 0;
                            this.form.package_limit = p.package_limit || 0;
                            this.form.pry_hcp = p.pry_hcp || '';
                            this.form.pry_hcp_code = p.pry_hcp_code || '';
                            this.form.sec_hcp = p.sec_hcp || '';
                            this.form.sec_hcp_code = p.sec_hcp_code || '';
                            this.form.diagnosis = p.diagnosis || '';
                            this.form.treatment_plan = p.treatment_plan || '';
                            this.form.further_investigation = p.further_investigation || '';
                            this.form.monitoring = p.monitoring || null;
                            this.fetchMessage = '✓ Loaded Successfully';
                            this.isNewEntry = false;
                        } else {
                            this.fetchMessage = '✗ Not found';
                        }
                        setTimeout(() => this.fetchMessage = '', 3000);
                    })
                    .catch(e => {
                        this.fetchMessage = '✗ Error loading';
                        setTimeout(() => this.fetchMessage = '', 3000);
                    });
            },

            addService() { this.services.push({ service_name: '', tariff: 0, qty: 1, total_hcp_amount_claimed: 0, remarks: '' }); },
            removeService(i) { if(confirm('Remove row?')) this.services.splice(i, 1); },
            addDrug() { this.drugs.push({ drug_name: '', tariff: 0, qty: 1, total_hcp_amount_claimed: 0, remarks: '' }); },
            removeDrug(i) { if(confirm('Remove row?')) this.drugs.splice(i, 1); },

            calculateServiceApproved() { return this.services.reduce((s, row) => s + (parseFloat(row.tariff || 0) * parseInt(row.qty || 1)), 0); },
            calculateServiceClaimed() { return this.services.reduce((s, row) => s + (parseFloat(row.total_hcp_amount_claimed || 0)), 0); },
            calculateDrugNet() { return this.drugs.reduce((s, row) => s + (parseFloat(row.tariff || 0) * parseInt(row.qty || 1) * 0.9), 0); },
            calculateDrugCopay() { return this.drugs.reduce((s, row) => s + (parseFloat(row.tariff || 0) * parseInt(row.qty || 1) * 0.1), 0); },
            calculateDrugClaimed() { return this.drugs.reduce((s, row) => s + (parseFloat(row.total_hcp_amount_claimed || 0)), 0); },
            calculateGrandTotal() { return this.calculateServiceApproved() + this.calculateDrugNet(); },

            formatMoney(v) { return new Intl.NumberFormat('en-NG', { minimumFractionDigits: 2 }).format(v || 0); },

            submitBill() {
                if(!this.form.pa_code || !this.form.full_name || !this.form.diagnosis) {
                    alert('Please fill mandatory fields: PA Code, Name, and Diagnosis');
                    return;
                }
                if(!confirm('Save this bill?')) return;
                const payload = { ...this.form, services: this.services, drugs: this.drugs };
                axios.post(initialState.routes.store, payload)
                    .then(() => { alert('Saved!'); window.location.href = initialState.routes.index; })
                    .catch(e => alert('Error saving. Check console.'));
            }
        };
    }
</script>

<!-- 3. Bind Alpine using the global variable -->
<div class="max-w-[1600px] mx-auto p-4 md:p-6 pb-32 space-y-6"
     x-data="billVettingApp(window.__BILL_VETTING_DATA__)" x-cloak>

    <!-- Header Section -->
    <header class="flex flex-col md:flex-row justify-between items-start md:items-center bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-2xl p-6 shadow-xl gap-4">
        <div class="flex items-center gap-4">
            <div class="h-14 w-14 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center">
                <i class="fas fa-file-medical text-2xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold">
                    <span x-text="isNewEntry ? 'New Bill Entry' : 'Bill Vetting Workstation'"></span>
                </h1>
                <div class="flex items-center gap-2 text-sm mt-1 opacity-90">
                    <span x-text="form.pa_code" class="font-mono bg-white/20 px-2 py-0.5 rounded"></span>
                    <span x-text="form.full_name"></span>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-6">
            <div class="text-right">
                <p class="text-xs font-bold uppercase opacity-75">Vetted Total</p>
                <p class="text-3xl font-black">₦<span x-text="formatMoney(calculateGrandTotal())"></span></p>
            </div>
            <button @click="submitBill" class="px-8 py-3 bg-white text-indigo-600 font-bold rounded-xl shadow-lg hover:scale-105 transition-all">
                <i class="fas fa-save mr-2"></i> Save Bill
            </button>
        </div>
    </header>

    <!-- Top Stats Row -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <!-- Patient Info Card -->
        <div class="glass-panel p-5 col-span-2 relative overflow-hidden group hover:shadow-md transition-all">
            <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                <i class="fas fa-user-circle text-8xl text-indigo-900"></i>
            </div>
            
            <div class="flex justify-between items-start mb-4 relative z-10">
                <div class="flex items-center gap-2">
                    <div class="h-8 w-1 bg-indigo-500 rounded-full"></div>
                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wide">Patient Information</h3>
                </div>
                <div class="flex gap-2">
                    <input type="text" x-model="searchPaCode" 
                           class="text-xs px-3 py-1.5 rounded-lg border-slate-200 bg-slate-50 focus:bg-white transition-all shadow-inner w-32" 
                           placeholder="Enter PA Code...">
                    <button @click="prefetchPatientData" 
                            class="bg-indigo-600 hover:bg-indigo-700 text-white text-[10px] px-3 py-1.5 rounded-lg font-bold shadow-md transition-all flex items-center gap-1">
                        <i class="fas fa-search"></i> FETCH
                    </button>
                </div>
            </div>

            <p x-show="fetchMessage" class="text-xs font-medium text-emerald-600 mb-3 bg-emerald-50 inline-block px-2 py-1 rounded" x-text="fetchMessage"></p>
            
            <div class="grid grid-cols-2 gap-x-6 gap-y-4 relative z-10">
                <div class="space-y-1">
                    <label class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">PA Code</label>
                    <input x-model="form.pa_code" class="w-full font-mono text-sm bg-indigo-50/50 border-0 border-b-2 border-indigo-100 focus:border-indigo-500 focus:ring-0 px-0 py-1 transition-colors text-indigo-900 font-bold" placeholder="PA-...">
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Full Name</label>
                    <input x-model="form.full_name" class="w-full text-sm bg-transparent border-0 border-b border-slate-200 focus:border-indigo-500 focus:ring-0 px-0 py-1 transition-colors font-medium text-slate-700" placeholder="Patient Name">
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Policy Number</label>
                    <input x-model="form.policy_no" class="w-full font-mono text-xs bg-transparent border-0 border-b border-slate-200 focus:border-indigo-500 focus:ring-0 px-0 py-1 transition-colors text-slate-600" placeholder="POLICY-001">
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Date of Birth</label>
                    <input type="date" x-model="form.dob" class="w-full text-xs bg-transparent border-0 border-b border-slate-200 focus:border-indigo-500 focus:ring-0 px-0 py-1 transition-colors text-slate-600">
                </div>
                <template x-if="form.monitoring">
                    <div class="col-span-2 pt-2">
                        <a :href="'/monitoring/' + form.monitoring.id" target="_blank" 
                           class="flex items-center justify-center gap-2 p-2 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-700 hover:bg-emerald-100 transition-all font-bold text-xs ring-4 ring-emerald-50/50">
                            <i class="fas fa-notes-medical animate-pulse"></i>
                            OPEN CLINICAL MONITORING LOG 
                            <span class="bg-emerald-200 px-2 py-0.5 rounded text-[10px]" x-text="form.monitoring.monitoring_status"></span>
                        </a>
                    </div>
                </template>
            </div>
        </div>

        <!-- Package Details -->
        <div class="glass-panel p-5 relative overflow-hidden group hover:shadow-md transition-all">
             <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                <i class="fas fa-box-open text-7xl text-purple-900"></i>
            </div>
            <div class="flex items-center gap-2 mb-4 relative z-10">
                <div class="h-8 w-1 bg-purple-500 rounded-full"></div>
                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wide">Plan Details</h3>
            </div>
            
            <div class="space-y-3 relative z-10">
                <div>
                   <label class="flex justify-between text-[10px] uppercase font-bold text-slate-400 tracking-wider mb-1">
                       <span>Plan Type</span>
                       <span class="text-purple-600" x-text="form.package_code"></span>
                   </label>
                   <input x-model="form.package_description" class="w-full text-sm font-bold text-purple-900 bg-purple-50/50 border-0 rounded-lg px-3 py-2" placeholder="Plan Description">
                </div>
                <div class="grid grid-cols-2 gap-4 pt-2">
                    <div class="bg-slate-50 p-2 rounded-lg border border-slate-100">
                        <label class="text-[9px] uppercase font-bold text-slate-400 block mb-1">Plan Limit</label>
                        <input type="number" x-model.number="form.package_limit" class="w-full bg-transparent border-none p-0 text-sm font-mono font-bold text-slate-700 focus:ring-0" placeholder="0">
                    </div>
                    <div class="bg-slate-50 p-2 rounded-lg border border-slate-100">
                        <label class="text-[9px] uppercase font-bold text-slate-400 block mb-1">Plan Price</label>
                        <input type="number" x-model.number="form.package_price" class="w-full bg-transparent border-none p-0 text-sm font-mono font-bold text-slate-700 focus:ring-0" placeholder="0">
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Billing Period -->
        <div class="glass-panel p-5 relative overflow-hidden group hover:shadow-md transition-all">
            <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                <i class="fas fa-calendar-alt text-7xl text-orange-900"></i>
            </div>
            <div class="flex items-center gap-2 mb-4 relative z-10">
                <div class="h-8 w-1 bg-orange-500 rounded-full"></div>
                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wide">Billing Cycle</h3>
            </div>
             <div class="space-y-4 relative z-10 h-full flex flex-col justify-center pb-4">
                <div class="flex items-center justify-between border-b border-orange-100 pb-2">
                    <label class="text-[10px] uppercase font-bold text-slate-400">Month</label>
                    <input type="month" x-model="form.billing_month" class="text-xs font-bold text-orange-800 bg-transparent border-none p-0 focus:ring-0 text-right">
                </div>
                <div class="flex items-center justify-between border-b border-orange-100 pb-2">
                    <label class="text-[10px] uppercase font-bold text-slate-400">Length of Stay</label>
                    <div class="flex items-center gap-1">
                         <input type="number" x-model.number="form.admission_days" class="w-10 text-xs font-bold text-orange-800 bg-transparent border-none p-0 focus:ring-0 text-right" placeholder="0">
                         <span class="text-[9px] text-orange-400 font-bold">DAYS</span>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-2">
                     <div>
                        <label class="text-[9px] text-slate-400 block">Admit</label>
                        <input type="date" x-model="form.admission_date" class="w-full text-[10px] bg-slate-50 border-none rounded px-1 py-1 text-slate-600">
                     </div>
                     <div>
                        <label class="text-[9px] text-slate-400 block">Disch.</label>
                         <input type="date" x-model="form.discharge_date" class="w-full text-[10px] bg-slate-50 border-none rounded px-1 py-1 text-slate-600">
                     </div>
                </div>
             </div>
        </div>
    </div>

    <!-- Provider & Medical Info Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        
        <!-- Healthcare Providers -->
        <div class="col-span-1 glass-panel p-0 overflow-hidden flex flex-col h-full border-t-4 border-t-emerald-500">
            <div class="p-4 bg-gradient-to-r from-emerald-50 to-white border-b border-emerald-100 flex items-center justify-between">
                 <div class="flex items-center gap-3">
                     <div class="bg-emerald-100 text-emerald-600 p-2 rounded-lg">
                        <i class="fas fa-hospital-alt"></i>
                     </div>
                     <h3 class="text-sm font-bold text-emerald-900 uppercase">Providers</h3>
                 </div>
            </div>
            
            <div class="p-5 flex-1 flex flex-col gap-4">
                <!-- Primary Provider Card -->
                <div class="bg-gradient-to-br from-white to-emerald-50/50 rounded-xl p-4 border border-emerald-100 shadow-sm relative group hover:border-emerald-300 transition-colors">
                    <div class="absolute top-3 right-3 text-emerald-200 group-hover:text-emerald-300 transition-colors">
                        <i class="fas fa-star text-xl"></i>
                    </div>
                    <label class="text-[10px] uppercase font-bold text-emerald-600 tracking-wider mb-2 block">Primary Hospital</label>
                    <input x-model="form.pry_hcp" class="w-full text-sm font-bold text-slate-700 bg-transparent border-none placeholder-emerald-200/50 focus:ring-0 p-0 mb-1" placeholder="Search Hospital...">
                    <div class="flex items-center gap-2 mt-2 pt-2 border-t border-emerald-100/50">
                        <span class="text-[9px] font-bold text-emerald-400 uppercase">Code:</span>
                        <input x-model="form.pry_hcp_code" class="flex-1 text-[10px] font-mono text-slate-500 bg-transparent border-none p-0 focus:ring-0" placeholder="N/A">
                    </div>
                </div>

                <!-- Secondary Provider Card -->
                <div class="bg-gradient-to-br from-white to-slate-50 rounded-xl p-4 border border-slate-100 shadow-sm relative group hover:border-slate-300 transition-colors">
                    <div class="absolute top-3 right-3 text-slate-200 group-hover:text-slate-300 transition-colors">
                        <i class="fas fa-share text-xl"></i>
                    </div>
                    <label class="text-[10px] uppercase font-bold text-slate-400 tracking-wider mb-2 block">Referral (Optional)</label>
                    <input x-model="form.sec_hcp" class="w-full text-sm font-medium text-slate-600 bg-transparent border-none placeholder-slate-200 focus:ring-0 p-0 mb-1" placeholder="Secondary Hospital...">
                    <div class="flex items-center gap-2 mt-2 pt-2 border-t border-slate-100">
                        <span class="text-[9px] font-bold text-slate-300 uppercase">Code:</span>
                        <input x-model="form.sec_hcp_code" class="flex-1 text-[10px] font-mono text-slate-400 bg-transparent border-none p-0 focus:ring-0" placeholder="N/A">
                    </div>
                </div>
            </div>
        </div>

        <!-- Medical Diagnosis & Treatment -->
        <div class="col-span-1 lg:col-span-2 glass-panel p-0 overflow-hidden flex flex-col h-full border-t-4 border-t-cyan-500">
             <div class="p-4 bg-gradient-to-r from-cyan-50 to-white border-b border-cyan-100 flex items-center justify-between">
                 <div class="flex items-center gap-3">
                     <div class="bg-cyan-100 text-cyan-600 p-2 rounded-lg">
                        <i class="fas fa-notes-medical"></i>
                     </div>
                     <h3 class="text-sm font-bold text-cyan-900 uppercase">Clinical Details</h3>
                 </div>
                 <div class="text-[10px] font-bold text-cyan-400 uppercase tracking-wider bg-cyan-50 px-2 py-1 rounded">Medical Review</div>
            </div>
            
            <div class="p-5 grid grid-cols-1 md:grid-cols-12 gap-6 h-full">
                <!-- Main Diagnosis Column -->
                <div class="md:col-span-7 flex flex-col gap-4">
                    <div class="bg-white rounded-xl p-1 border-2 border-cyan-100 flex-1 flex flex-col shadow-sm focus-within:ring-2 focus-within:ring-cyan-100 focus-within:border-cyan-300 transition-all">
                        <div class="bg-cyan-50/50 px-3 py-2 rounded-t-lg border-b border-cyan-50 flex items-center justify-between">
                            <label class="text-[10px] uppercase font-black text-cyan-600 tracking-widest">
                                <i class="fas fa-diagnoses mr-1"></i> Primary Diagnosis
                            </label>
                            <span class="h-1.5 w-1.5 rounded-full bg-red-400 animate-pulse" title="Required"></span>
                        </div>
                        <textarea x-model="form.diagnosis" class="w-full flex-1 bg-transparent border-none focus:ring-0 text-sm leading-relaxed p-3 text-slate-700 placeholder-slate-300" placeholder="Enter the complete clinical diagnosis here..."></textarea>
                    </div>

                    <div class="bg-white rounded-xl p-1 border border-slate-200 flex h-32 shadow-sm focus-within:ring-2 focus-within:ring-slate-100 focus-within:border-slate-300 transition-all">
                        <div class="w-8 flex items-center justify-center bg-slate-50 rounded-l-lg border-r border-slate-100">
                            <i class="fas fa-microscope text-slate-400"></i>
                         </div>
                         <div class="flex-1 flex flex-col">
                             <div class="px-3 py-1.5 border-b border-slate-50">
                                <label class="text-[9px] uppercase font-bold text-slate-400 tracking-wider">Investigations / Labs</label>
                             </div>
                             <textarea x-model="form.further_investigation" class="w-full h-full bg-transparent border-none focus:ring-0 text-xs text-slate-600 p-3 leading-relaxed placeholder-slate-300" placeholder="List any lab results, imaging, or required tests..."></textarea>
                         </div>
                    </div>
                </div>
                
                <!-- Treatment Plan Column -->
                <div class="md:col-span-5 flex flex-col h-full">
                    <div class="bg-gradient-to-b from-slate-50 to-white rounded-xl border border-slate-200 flex-1 flex flex-col shadow-sm focus-within:ring-2 focus-within:ring-slate-100 focus-within:border-slate-300 transition-all">
                        <div class="px-4 py-3 border-b border-slate-100 flex items-center gap-2">
                            <i class="fas fa-procedures text-slate-400"></i>
                            <label class="text-[10px] uppercase font-bold text-slate-500 tracking-wider">Management Plan</label>
                        </div>
                        <div class="flex-1 relative">
                            <textarea x-model="form.treatment_plan" class="absolute inset-0 w-full h-full bg-transparent border-none focus:ring-0 text-xs text-slate-600 p-4 leading-relaxed placeholder-slate-300" placeholder="Outline the treatment plan, surgeries, or medications..."></textarea>
                        </div>
                        <div class="bg-slate-50 px-3 py-2 border-t border-slate-100 text-[9px] text-slate-400 italic">
                            Authorization required for expensive procedures.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Services Table -->
    <div class="glass-panel overflow-hidden border-2 border-blue-100">
        <div class="px-6 py-4 bg-blue-50/50 flex items-center justify-between">
            <h3 class="text-sm font-bold text-blue-900 uppercase">Medical Services</h3>
            <button @click="addService" class="bg-blue-600 text-white text-xs px-4 py-2 rounded-lg font-bold shadow-md hover:bg-blue-700">
                <i class="fas fa-plus mr-2"></i> ADD SERVICE
            </button>
        </div>
        <table class="w-full text-left">
            <thead>
                <tr>
                    <th class="table-header">Service Name</th>
                    <th class="table-header w-24">Rate</th>
                    <th class="table-header w-16 text-center">Qty</th>
                    <th class="table-header w-32 text-center">Approved</th>
                    <th class="table-header w-32 text-center">Claimed</th>
                    <th class="table-header">Remarks</th>
                    <th class="table-header w-12"></th>
                </tr>
            </thead>
            <tbody>
                <template x-for="(s, i) in services" :key="i">
                    <tr class="hover:bg-blue-50/30">
                        <td class="table-cell"><input x-model="s.service_name" class="compact-input"></td>
                        <td class="table-cell"><input type="number" x-model.number="s.tariff" class="compact-input num-input"></td>
                        <td class="table-cell"><input type="number" x-model.number="s.qty" class="compact-input text-center"></td>
                        <td class="table-cell text-center font-bold text-indigo-600 text-xs" x-text="formatMoney(s.tariff * s.qty)"></td>
                        <td class="table-cell"><input type="number" x-model.number="s.total_hcp_amount_claimed" class="compact-input num-input claimed-input"></td>
                        <td class="table-cell"><input x-model="s.remarks" class="compact-input"></td>
                        <td class="table-cell text-center"><button @click="removeService(i)" class="text-red-400 hover:text-red-600"><i class="fas fa-trash"></i></button></td>
                    </tr>
                </template>
            </tbody>
            <tfoot class="bg-slate-50 font-bold border-t">
                <tr>
                    <td colspan="3" class="p-4 text-right text-xs">SERVICES TOTAL:</td>
                    <td class="p-4 text-center text-indigo-600" x-text="'₦' + formatMoney(calculateServiceApproved())"></td>
                    <td class="p-4 text-center text-emerald-600" x-text="'₦' + formatMoney(calculateServiceClaimed())"></td>
                    <td colspan="2"></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Drugs Table -->
    <div class="glass-panel overflow-hidden border-2 border-emerald-100">
        <div class="px-6 py-4 bg-emerald-50/50 flex items-center justify-between">
            <h3 class="text-sm font-bold text-emerald-900 uppercase">Drugs & Consumables</h3>
            <button @click="addDrug" class="bg-emerald-600 text-white text-xs px-4 py-2 rounded-lg font-bold shadow-md hover:bg-emerald-700">
                <i class="fas fa-plus mr-2"></i> ADD DRUG
            </button>
        </div>
        <table class="w-full text-left">
            <thead>
                <tr>
                    <th class="table-header">Drug Name</th>
                    <th class="table-header w-24">Rate</th>
                    <th class="table-header w-16 text-center">Qty</th>
                    <th class="table-header w-32 text-center">Net 90%</th>
                    <th class="table-header w-24 text-center">Copay</th>
                    <th class="table-header w-32 text-center">Claimed</th>
                    <th class="table-header">Remarks</th>
                    <th class="table-header w-12"></th>
                </tr>
            </thead>
            <tbody>
                <template x-for="(d, i) in drugs" :key="i">
                    <tr class="hover:bg-emerald-50/30">
                        <td class="table-cell"><input x-model="d.drug_name" class="compact-input"></td>
                        <td class="table-cell"><input type="number" x-model.number="d.tariff" class="compact-input num-input"></td>
                        <td class="table-cell"><input type="number" x-model.number="d.qty" class="compact-input text-center"></td>
                        <td class="table-cell text-center font-bold text-indigo-600 text-xs" x-text="formatMoney(d.tariff * d.qty * 0.9)"></td>
                        <td class="table-cell text-center font-bold text-orange-500 text-[10px]" x-text="formatMoney(d.tariff * d.qty * 0.1)"></td>
                        <td class="table-cell"><input type="number" x-model.number="d.total_hcp_amount_claimed" class="compact-input num-input claimed-input"></td>
                        <td class="table-cell"><input x-model="d.remarks" class="compact-input"></td>
                        <td class="table-cell text-center"><button @click="removeDrug(i)" class="text-red-400 hover:text-red-600"><i class="fas fa-trash"></i></button></td>
                    </tr>
                </template>
            </tbody>
            <tfoot class="bg-slate-50 font-bold border-t">
                <tr>
                    <td colspan="3" class="p-4 text-right text-xs">DRUGS TOTAL:</td>
                    <td class="p-4 text-center text-indigo-600" x-text="'₦' + formatMoney(calculateDrugNet())"></td>
                    <td class="p-4 text-center text-orange-500" x-text="'₦' + formatMoney(calculateDrugCopay())"></td>
                    <td class="p-4 text-center text-emerald-600" x-text="'₦' + formatMoney(calculateDrugClaimed())"></td>
                    <td colspan="2"></td>
                </tr>
            </tfoot>
        </table>
    </div>

</div>
</x-app-layout>