<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            {{ __('Underwriter Review & Authorization') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto p-6 pb-24" x-data="udEditApp({
        pa_code: '{{ $log->pa_code }}',
        encoded_pa: '{{ base64_encode($log->pa_code) }}',
        billing_month: '{{ $log->billing_month }}',
        admission_days: {{ $log->admission_days ?? 0 }},
        initialServices: {{ $log->services->toJson() }},
        initialDrugs: {{ $log->drugs->toJson() }}
    })" x-cloak>

        <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-sm">
                <div>
                    <label class="block text-[10px] uppercase font-bold text-slate-400">PA Code</label>
                    <p class="font-mono font-bold text-blue-600">{{ $log->pa_code }}</p>
                </div>
                <div>
                    <label class="block text-[10px] uppercase font-bold text-slate-400">Billing Month</label>
                    <p class="font-semibold text-slate-700">{{ $log->billing_month }}</p>
                </div>
                <div>
                    <label class="block text-[10px] uppercase font-bold text-slate-400">Admission Days</label>
                    <p class="font-semibold text-slate-700">{{ $log->admission_days }}</p>
                </div>
                <div class="text-right">
                    <label class="block text-[10px] uppercase font-bold text-slate-400">Patient</label>
                    <p class="font-bold text-slate-800">{{ $log->full_name }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 mb-6 overflow-hidden">
            <div class="p-4 bg-slate-50 border-b flex justify-between items-center">
                <h3 class="text-sm font-bold text-blue-700 uppercase">Medical Services</h3>
                <button @click="addService" class="text-xs bg-blue-600 text-white px-3 py-1 rounded-lg hover:bg-blue-700">+ Add Service</button>
            </div>
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-[10px] uppercase text-slate-500 font-bold border-b bg-slate-50/50">
                        <th class="p-4">Service Description</th>
                        <th class="p-4 text-center">Tariff</th>
                        <th class="p-4 text-center">Qty</th>
                        <th class="p-4 text-right">Claimed (HCP)</th>
                        <th class="p-4 text-right">Due (Auth)</th>
                        <th class="p-4">Remarks</th>
                        <th class="p-4 text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="(s, i) in services" :key="i">
                        <tr class="border-b hover:bg-blue-50/20">
                            <td class="p-2"><input x-model="s.service_name" class="w-full text-xs rounded border-slate-300"></td>
                            <td class="p-2"><input type="number" x-model.number="s.tariff" class="w-24 text-xs text-center mx-auto block rounded border-slate-300"></td>
                            <td class="p-2"><input type="number" x-model.number="s.qty" class="w-16 text-xs text-center mx-auto block rounded border-slate-300"></td>
                            <td class="p-2">
                                <input type="number" x-model.number="s.claimed" class="w-28 text-xs text-right rounded border-blue-200 bg-blue-50 font-bold">
                            </td>
                            <td class="p-2 text-right text-xs font-bold text-blue-700">
                                ₦<span x-text="formatMoney(s.tariff * s.qty)"></span>
                            </td>
                            <td class="p-2"><input x-model="s.remarks" placeholder="Notes" class="w-full text-[10px] rounded border-slate-300"></td>
                            <td class="p-2 text-center">
                                <button @click="removeService(i)" class="text-red-400 hover:text-red-600 font-bold text-lg">×</button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 mb-6 overflow-hidden">
            <div class="p-4 bg-emerald-50 border-b flex justify-between items-center">
                <h3 class="text-sm font-bold text-emerald-700 uppercase">Drugs & Consumables</h3>
                <button @click="addDrug" class="text-xs bg-emerald-600 text-white px-3 py-1 rounded-lg hover:bg-emerald-700">+ Add Drug</button>
            </div>
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-[10px] uppercase text-slate-500 font-bold border-b bg-emerald-50/20">
                        <th class="p-4">Drug Item</th>
                        <th class="p-4 text-center">Price</th>
                        <th class="p-4 text-center">Qty</th>
                        <th class="p-4 text-right">Claimed (HCP)</th>
                        <th class="p-4 text-right">Due (90%)</th>
                        <th class="p-4 text-center text-red-500">10% Copay</th>
                        <th class="p-4">Remarks</th>
                        <th class="p-4 text-center"></th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="(d, i) in drugs" :key="i">
                        <tr class="border-b hover:bg-emerald-50/20">
                            <td class="p-2"><input x-model="d.drug_name" class="w-full text-xs rounded border-slate-300"></td>
                            <td class="p-2"><input type="number" x-model.number="d.tariff" class="w-20 text-xs text-center mx-auto block rounded border-slate-300"></td>
                            <td class="p-2"><input type="number" x-model.number="d.qty" class="w-16 text-xs text-center mx-auto block rounded border-slate-300"></td>
                             
                           <td class="p-2">
                                <input type="number" x-model.number="d.claimed" class="w-28 text-xs text-right rounded border-emerald-200 bg-emerald-50 font-bold">
                            </td>

                            <td class="p-2 text-right text-xs font-bold text-emerald-700">
                                ₦<span x-text="formatMoney(d.tariff * d.qty * 0.9)"></span>
                            </td>
                           
                             <td class="p-2 text-center text-[10px] font-bold text-red-500 bg-red-50/30">
                                ₦<span x-text="formatMoney(d.tariff * d.qty * 0.1)"></span>
                            </td>

                            <td class="p-2"><input x-model="d.remarks" placeholder="Notes" class="w-full text-[10px] rounded border-slate-300"></td>
                            
                            <td class="p-2 text-center">
                                <button @click="removeDrug(i)" class="text-red-400 hover:text-red-600 font-bold text-lg">×</button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-slate-200 p-4 shadow-lg z-50">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <div class="flex space-x-12">
                    <div>
                        <p class="text-[10px] text-slate-400 uppercase font-black">Total Claimed</p>
                        <p class="text-xl font-bold text-slate-700">₦<span x-text="formatMoney(totalClaimed)"></span></p>
                    </div>
                    <div>
                        <p class="text-[10px] text-indigo-500 uppercase font-black">Authorized Due</p>
                        <p class="text-2xl font-black text-indigo-700">₦<span x-text="formatMoney(totalDue)"></span></p>
                    </div>
                </div>
                <button @click="submitUpdate" :disabled="isSaving"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-12 py-3 rounded-xl font-bold shadow-lg transition-all active:scale-95 disabled:opacity-50">
                    <span x-text="isSaving ? 'Saving...' : 'Authorize & Save'"></span>
                </button>
            </div>
        </div>
    </div>

    <script>
        function udEditApp(data) {
            return {
                isSaving: false,
                billing_month: data.billing_month,
                admission_days: data.admission_days,

                // CORRECT MAPPING FOR SERVICES
                services: (data.initialServices || []).map(s => ({
                    service_name: s.service_name || '',
                    tariff: parseFloat(s.tariff) || 0,
                    qty: parseInt(s.qty) || 1,
                    claimed: parseFloat(s.hcp_amount_claimed_total_services) || 0, 
                    remarks: s.remarks || '' 
                })),
                
                // CORRECT MAPPING FOR DRUGS
                drugs: (data.initialDrugs || []).map(d => ({
                    drug_name: d.drug_name || '',
                    tariff: parseFloat(d.tariff) || 0,
                    qty: parseInt(d.qty) || 1,
                    claimed: parseFloat(d.hcp_amount_claimed_total_drugs) || 0,
                    remarks: d.remarks || '' 
                })),

                formatMoney(val) {
                    return parseFloat(val || 0).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                },

                get totalClaimed() {
                    return this.services.reduce((a, b) => a + (parseFloat(b.claimed) || 0), 0) + 
                           this.drugs.reduce((a, b) => a + (parseFloat(b.claimed) || 0), 0);
                },

                get totalDue() {
                    return this.services.reduce((a, b) => a + (b.tariff * b.qty), 0) + 
                           this.drugs.reduce((a, b) => a + (b.tariff * b.qty * 0.9), 0);
                },

                addService() { this.services.push({ service_name: '', tariff: 0, qty: 1, claimed: 0, remarks: '' }); },
                removeService(i) { this.services.splice(i, 1); },
                addDrug() { this.drugs.push({ drug_name: '', tariff: 0, qty: 1, claimed: 0, remarks: '' }); },
                removeDrug(i) { this.drugs.splice(i, 1); },

                submitUpdate() {
                    if(!confirm('Re-Check these changes?')) return;
                    this.isSaving = true;
                    let url = "{{ route('bill-management.gm.update', 'ID_HERE') }}".replace('ID_HERE', data.encoded_pa);

                    axios.put(url, {
                        billing_month: this.billing_month,
                        admission_days: this.admission_days,
                        services: this.services,
                        drugs: this.drugs,
                        hcp_amount_due_grandtotal: this.totalDue,
                        hcp_amount_claimed_grandtotal: this.totalClaimed
                    })
                    .then(res => {
                        window.location.href = "{{ route('bill-management.gm.index') }}?message=Re-Checked Successfully";
                    })
                    .catch(err => {
                        this.isSaving = false;
                        alert('Error saving. Check console for details.');
                    });
                }
            }
        }
    </script>
</x-app-layout>