<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            {{ __('Case Manager - Financial Settlement Terminal') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto p-6 pb-24" x-data="cmEditApp({
        pa_code: '{{ $log->pa_code }}',
        encoded_pa: '{{ base64_encode($log->pa_code) }}',
        hcps: @js($hcps)
    })" x-cloak>

        <!-- TOP HEADER PANEL (COMPACT) -->
        <div class="bg-gradient-to-br from-indigo-900 via-slate-900 to-black p-5 rounded-2xl shadow-xl text-white mb-6 relative overflow-hidden border border-white/10">
            <div class="absolute top-0 right-0 p-4 opacity-5">
                <i class="fas fa-file-invoice-dollar fa-8x"></i>
            </div>
            
            <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="bg-amber-500 text-black text-[9px] font-black uppercase px-2 py-0.5 rounded shadow-sm tracking-wider">Authorized</span>
                        <span class="bg-white/10 text-white/70 text-[9px] font-bold uppercase px-2 py-0.5 rounded border border-white/10 tracking-wider">MD Approved</span>
                    </div>
                    <h1 class="text-2xl font-black font-mono uppercase tracking-tighter mb-1">{{ $log->pa_code }}</h1>
                    <div class="flex items-center gap-4 text-slate-300 text-xs font-medium">
                        <p class="flex items-center gap-1"><i class="fas fa-user-circle opacity-50"></i> {{ $log->full_name }}</p>
                        <span class="opacity-20">|</span>
                        <p class="flex items-center gap-1 font-mono"><i class="fas fa-id-card opacity-50"></i> {{ $log->policy_no }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-6">
                    <div class="text-right mr-4">
                        <p class="text-[9px] text-slate-400 uppercase font-black tracking-widest">Total Payable</p>
                        <p class="text-2xl font-black tabular-nums text-emerald-400 leading-none">₦{{ number_format($log->hcp_amount_due_grandtotal, 2) }}</p>
                        <p class="text-[9px] text-slate-500 mt-0.5">Claim: ₦{{ number_format($log->hcp_amount_claimed_grandtotal, 2) }}</p>
                    </div>
                    
                    <div class="flex gap-2">
                        <a href="{{ route('bill-management.cm.pdf', base64_encode($log->pa_code)) }}" target="_blank"
                           class="bg-white/10 hover:bg-white/20 text-white px-3 py-2 rounded-lg font-bold transition text-xs flex items-center gap-2 border border-white/10" title="Download PDF">
                            <i class="fas fa-file-pdf text-red-400"></i> PDF
                        </a>
                        <button @click="scrollToPayment" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg font-bold shadow-lg transition text-xs flex items-center gap-2">
                            <i class="fas fa-money-check-alt"></i> Pay
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- LEFT COLUMN: MEDICAL DATA -->
            <div class="lg:col-span-2 space-y-8">
                <!-- DIAGNOSIS & TREATMENT -->
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 bg-slate-50 border-b border-slate-200 flex items-center gap-3">
                        <i class="fas fa-stethoscope text-indigo-600"></i>
                        <h3 class="text-xs font-black text-slate-700 uppercase tracking-widest">Medical Assessment Summary</h3>
                    </div>
                    <div class="p-8 space-y-6">
                        <div>
                            <label class="text-[10px] uppercase font-black text-slate-400 tracking-widest mb-2 block">Diagnosis</label>
                            <p class="text-slate-800 font-bold leading-relaxed">{{ $log->diagnosis }}</p>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label class="text-[10px] uppercase font-black text-slate-400 tracking-widest mb-2 block">Treatment Plan</label>
                                <p class="text-slate-700 text-sm leading-relaxed">{{ $log->treatment_plan }}</p>
                            </div>
                            <div>
                                <label class="text-[10px] uppercase font-black text-slate-400 tracking-widest mb-2 block">Further Investigation</label>
                                <p class="text-slate-700 text-sm leading-relaxed italic">{{ $log->further_investigation ?? 'None specified' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECONDARY HCP SUMMARY -->
                <div class="bg-indigo-50/50 rounded-3xl border-2 border-dashed border-indigo-200 p-8">
                    <div class="flex items-center gap-4">
                        <div class="bg-indigo-600 text-white p-3 rounded-2xl shadow-lg shadow-indigo-100">
                            <i class="fas fa-hospital-alt"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-black text-indigo-900 uppercase tracking-widest">Secondary HCP Summary</h4>
                            <p class="text-sm text-indigo-700 font-bold mt-1">
                                {{ $log->sec_hcp ?? 'N/A' }} 
                                <span class="mx-2 opacity-30">|</span> 
                                <span class="font-mono text-xs">{{ $log->sec_hcp_code ?? 'NO CODE' }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN: PAYMENT SCHEDULING -->
            <div id="payment-section" class="space-y-8">
                <div class="bg-white rounded-3xl shadow-2xl border border-emerald-100 p-8 sticky top-8">
                    <div class="flex items-center gap-3 mb-6">
                        <i class="fas fa-wallet text-emerald-600 text-xl"></i>
                        <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Schedule HCP Payment</h3>
                    </div>

                    <div class="space-y-6">
                        <!-- HCP SELECTION -->
                        <div>
                            <label class="text-[10px] uppercase font-black text-slate-400 tracking-widest mb-2 block">Select Registered HCP</label>
                            <select x-model="selectedHcpId" @change="fetchHcpDetails"
                                    class="w-full rounded-2xl border-slate-200 bg-slate-50 text-sm font-bold p-4 focus:ring-emerald-500 focus:border-emerald-500 transition-all cursor-pointer">
                                <option value="">-- Choose Hospital to Fetch Details --</option>
                                <template x-for="h in hcps" :key="h.id">
                                    <option :value="h.id" x-text="h.hcp_name"></option>
                                </template>
                            </select>
                        </div>

                        <!-- AUTO-FETCHED BANK DETAILS -->
                        <template x-if="selectedHcp">
                            <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100 space-y-4">
                                <div>
                                    <p class="text-[9px] uppercase font-black text-slate-400 mb-1">Bank Account Name</p>
                                    <p class="text-sm font-bold text-slate-800" x-text="selectedHcp.hcp_account_name"></p>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-[9px] uppercase font-black text-slate-400 mb-1">Account Number</p>
                                        <p class="text-sm font-mono font-bold text-indigo-600" x-text="selectedHcp.hcp_account_number"></p>
                                    </div>
                                    <div>
                                        <p class="text-[9px] uppercase font-black text-slate-400 mb-1">Bank Name</p>
                                        <p class="text-sm font-bold text-slate-800" x-text="selectedHcp.hcp_bank_name"></p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-[9px] uppercase font-black text-slate-400 mb-1">HCP Phone</p>
                                        <p class="text-sm font-bold text-slate-800" x-text="selectedHcp.hcp_phone || 'N/A'"></p>
                                    </div>
                                    <div>
                                        <p class="text-[9px] uppercase font-black text-slate-400 mb-1">HCP Email</p>
                                        <p class="text-sm font-bold text-slate-800" x-text="selectedHcp.hcp_email || 'N/A'"></p>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <hr class="border-slate-100">

                        <div class="bg-emerald-50 rounded-2xl p-6">
                            <p class="text-[9px] uppercase font-black text-emerald-600 mb-1">Final Total Due</p>
                            <p class="text-3xl font-black text-emerald-700">₦{{ number_format($log->hcp_amount_due_grandtotal, 2) }}</p>
                        </div>

                        <button @click="submitPayment" :disabled="isBusy || !selectedHcpId"
                            class="w-full bg-slate-900 hover:bg-black text-white py-5 rounded-2xl font-black shadow-xl transition-all active:scale-95 disabled:opacity-30 disabled:grayscale uppercase tracking-widest text-sm flex items-center justify-center gap-3">
                            <i class="fas fa-lock" x-show="!isBusy"></i>
                            <span x-text="isBusy ? 'Processing...' : 'Verify & Close Transaction'"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function cmEditApp(data) {
            return {
                isBusy: false,
                hcps: data.hcps,
                selectedHcpId: '',
                selectedHcp: null,

                scrollToPayment() {
                    document.getElementById('payment-section').scrollIntoView({ behavior: 'smooth' });
                },

                fetchHcpDetails() {
                    if (!this.selectedHcpId) {
                        this.selectedHcp = null;
                        return;
                    }
                    axios.get(`/api/hcps/${this.selectedHcpId}`)
                        .then(res => {
                            this.selectedHcp = res.data;
                        })
                        .catch(err => {
                            console.error('Error fetching HCP details');
                        });
                },

                submitPayment() {
                    if(!confirm('Final verification check: Are all details correct for this settlement?')) return;
                    this.isBusy = true;
                    let url = "{{ route('bill-management.cm.update', 'ID_HERE') }}".replace('ID_HERE', data.encoded_pa);

                    // We could also pass the selected HCP details to the backend here
                    axios.put(url, {
                        hcp_id: this.selectedHcpId,
                        hcp_bank: this.selectedHcp ? this.selectedHcp.hcp_bank_name : '',
                        hcp_account: this.selectedHcp ? this.selectedHcp.hcp_account_number : '',
                        hcp_account_name: this.selectedHcp ? this.selectedHcp.hcp_account_name : '',
                        hcp_phone: this.selectedHcp ? this.selectedHcp.hcp_phone : '',
                        hcp_email: this.selectedHcp ? this.selectedHcp.hcp_email : ''
                    })
                    .then(res => {
                        // 1. Trigger PDF Download (Directly)
                        let pdfUrl = "{{ route('bill-management.cm.pdf', 'ID_HERE') }}".replace('ID_HERE', data.encoded_pa);
                        
                        // Create a hidden link to force download
                        const link = document.createElement('a');
                        link.href = pdfUrl;
                        link.setAttribute('download', 'Bill_Settlement_' + data.pa_code + '.pdf'); // Optional: suggest filename
                        link.style.display = 'none';
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);

                        // 2. Redirect to Index after brief delay
                        setTimeout(() => {
                            window.location.href = "{{ route('bill-management.cm.index') }}?message=Bill Settled and PDF Payment Advice Generated";
                        }, 2000);
                    })
                    .catch(err => {
                        this.isBusy = false;
                        alert('Error processing settlement. Please try again.');
                    });
                }
            }
        }
    </script>
</x-app-layout>
