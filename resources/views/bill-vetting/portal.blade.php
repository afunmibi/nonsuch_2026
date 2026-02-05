<x-app-layout>
    <div class="py-6 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <div class="flex flex-col md:flex-row md:items-end gap-4">
                    <div class="flex-1">
                        <label class="block text-[10px] font-black text-indigo-600 uppercase mb-1 tracking-widest">Billing Vetting Portal</label>
                        <input type="text" id="pa_search_input" 
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 pl-4 py-3 text-sm font-mono" 
                            placeholder="Enter PA Code (e.g. 051/PHIS/2026/...)" value="{{ $paCode ?? '' }}">
                    </div>
                    <button type="button" onclick="fetchPaDetails()" id="btn_fetch"
                        class="bg-indigo-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-indigo-700 transition-all flex items-center justify-center gap-2 shadow-md">
                        <span id="btn_text">Fetch Record</span>
                    </button>
                </div>

                <div id="master_details" class="hidden mt-8 space-y-6 animate-fade-in">
                    <div class="border-t border-dashed border-gray-200 pt-6"></div>
                    <input type="hidden" id="log_request_id">
                    <input type="hidden" id="sec_hcp_code">

                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 bg-slate-50 p-5 rounded-xl border border-slate-200 shadow-inner">
                        <div>
                            <label class="text-[10px] text-slate-500 uppercase font-black">Full Name</label>
                            <input type="text" id="disp_name" class="w-full bg-transparent border-none p-0 text-sm font-bold text-slate-900 focus:ring-0" readonly>
                        </div>
                        <div>
                            <label class="text-[10px] text-slate-500 uppercase font-black">Policy Number</label>
                            <input type="text" id="disp_policy" class="w-full bg-transparent border-none p-0 text-sm font-bold text-slate-900 focus:ring-0" readonly>
                        </div>
                        <div class="bg-white p-2 rounded border border-indigo-100">
                            <label class="text-[10px] text-indigo-600 uppercase font-black">Billing Month</label>
                            <input type="month" id="billing_month" class="w-full border-none p-0 text-xs font-bold focus:ring-0">
                        </div>
                        <div class="bg-white p-2 rounded border border-orange-200">
                            <label class="text-[10px] text-orange-600 uppercase font-black">Days in Hospital</label>
                            <input type="number" id="admission_days" min="0" value="0" class="w-full border-none p-0 text-xs font-bold focus:ring-0 text-center">
                        </div>
                        <div>
                            <label class="text-[10px] text-slate-500 uppercase font-black tracking-tighter">Provider</label>
                            <p id="sec_hcp_display" class="text-[11px] font-bold text-indigo-700 truncate leading-tight">-</p>
                            <p id="sec_hcp_code_display" class="text-[9px] font-mono text-slate-400 uppercase tracking-tighter">-</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="p-3 bg-white border rounded-lg shadow-sm border-l-4 border-l-red-500">
                            <label class="text-[10px] text-red-600 uppercase font-black">Diagnosis</label>
                            <p id="diagnosis" class="text-xs text-slate-600 mt-1 leading-relaxed italic">-</p>
                        </div>
                        <div class="p-3 bg-white border rounded-lg shadow-sm border-l-4 border-l-orange-500">
                            <label class="text-[10px] text-orange-600 uppercase font-black">Treatment Plan</label>
                            <p id="treatment_plan" class="text-xs text-slate-600 mt-1 leading-relaxed italic">-</p>
                        </div>
                        <div class="p-3 bg-white border rounded-lg shadow-sm border-l-4 border-l-purple-500">
                            <label class="text-[10px] text-purple-600 uppercase font-black">Investigations</label>
                            <p id="further_investigation" class="text-xs text-slate-600 mt-1 leading-relaxed italic">-</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
                        <div class="bg-blue-600 px-4 py-3 flex justify-between items-center">
                            <h3 class="text-white text-[11px] font-black uppercase tracking-widest">Medical Services & Procedures</h3>
                            <button type="button" onclick="addRow('service')" class="text-[10px] bg-white text-blue-700 px-4 py-1.5 rounded-full font-bold hover:bg-blue-50 transition shadow-sm">+ Add Service</button>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-slate-50 text-[10px] uppercase text-slate-500 font-bold border-b">
                                        <th class="p-4">Service Name</th>
                                        <th class="p-4 w-28">Tariff</th>
                                        <th class="p-4 w-20 text-center">Qty</th>
                                        <th class="p-4 w-32 bg-blue-50 text-blue-700">HCP Due</th>
                                        <th class="p-4 w-32">Claimed</th>
                                        <th class="p-4">Remarks</th>
                                        <th class="p-4 w-10"></th>
                                    </tr>
                                </thead>
                                <tbody id="services_body" class="divide-y divide-gray-100"></tbody>
                            </table>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
                        <div class="bg-emerald-600 px-4 py-3 flex justify-between items-center">
                            <h3 class="text-white text-[11px] font-black uppercase tracking-widest">Drugs & Medication</h3>
                            <button type="button" onclick="addRow('drug')" class="text-[10px] bg-white text-emerald-700 px-4 py-1.5 rounded-full font-bold hover:bg-emerald-50 transition shadow-sm">+ Add Drug</button>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-slate-50 text-[10px] uppercase text-slate-500 font-bold border-b">
                                        <th class="p-4">Drug Name</th>
                                        <th class="p-4 w-28">Tariff</th>
                                        <th class="p-4 w-20 text-center">Qty</th>
                                        <th class="p-4 w-24 bg-red-50 text-red-700">Copay (10%)</th>
                                        <th class="p-4 w-32 bg-emerald-50 text-emerald-700 font-bold">HCP Due</th>
                                        <th class="p-4 w-32">Claimed</th>
                                        <th class="p-4">Remarks</th>
                                        <th class="p-4 w-10"></th>
                                    </tr>
                                </thead>
                                <tbody id="drugs_body" class="divide-y divide-gray-100"></tbody>
                            </table>
                        </div>
                    </div>

                    <div class="flex flex-col md:flex-row gap-6 items-center bg-slate-900 p-6 rounded-2xl shadow-xl">
                        <div class="flex-1 grid grid-cols-2 gap-4 w-full">
                            <div>
                                <label class="text-[9px] font-bold uppercase tracking-widest text-slate-400">Vetted Due Grand Total</label>
                                <p id="grand_total_due" class="text-3xl font-black text-emerald-400">₦0.00</p>
                            </div>
                            <div>
                                <label class="text-[9px] font-bold uppercase tracking-widest text-slate-400">Claimed Grand Total</label>
                                <p id="grand_total_claimed" class="text-3xl font-black text-rose-400">₦0.00</p>
                            </div>
                        </div>
                        <button type="button" onclick="submitVetting()" class="w-full md:w-72 bg-indigo-500 text-white font-black py-5 rounded-xl hover:bg-indigo-400 shadow-lg transition-all active:scale-95 text-lg">
                            COMPLETE VETTING
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const setVal = (id, val, isText = false) => {
            const el = document.getElementById(id);
            if (!el) return;
            isText ? el.innerText = val || '-' : el.value = val || '';
        };

        const formatCurr = (n) => Number(n || 0).toLocaleString(undefined, { minimumFractionDigits: 2 });

        async function fetchPaDetails() {
            const paCode = document.getElementById('pa_search_input').value.trim();
            if (!paCode) return alert("Please enter a PA Code");

            const btnText = document.getElementById('btn_text');
            btnText.innerText = 'Searching...';

            try {
                const response = await fetch(`/bill-vetting/fetch/${btoa(paCode)}`);
                const data = await response.json();

                if (!response.ok) throw new Error(data.error || "Record not found");

                document.getElementById('master_details').classList.remove('hidden');

                // Mapping Header Data
                setVal('log_request_id', data.id);
                setVal('disp_name', data.full_name);
                setVal('disp_policy', data.policy_no);
                setVal('diagnosis', data.diagnosis, true);
                setVal('treatment_plan', data.treatment_plan, true);
                setVal('further_investigation', data.further_investigation, true);
                
                // Mapping Provider Data
                setVal('sec_hcp_display', data.secondary_hcp, true);
                setVal('sec_hcp_code_display', data.secondary_hcp_code, true);
                setVal('sec_hcp_code', data.secondary_hcp_code);

            } catch (e) {
                alert(e.message);
                document.getElementById('master_details').classList.add('hidden');
            } finally {
                btnText.innerText = 'Fetch Record';
            }
        }

        function addRow(type) {
            const tbody = document.getElementById(type === 'service' ? 'services_body' : 'drugs_body');
            const id = Date.now();
            const tr = document.createElement('tr');
            tr.id = `row_${id}`;
            tr.className = "text-xs hover:bg-slate-50 transition-colors group";

            if (type === 'service') {
                tr.innerHTML = `
                    <td class="p-3"><input type="text" class="name w-full border-none p-1 focus:ring-0 bg-transparent font-medium" placeholder="Procedure..."></td>
                    <td class="p-3"><input type="number" oninput="calc(${id},'s')" class="tariff w-full border-gray-200 rounded p-1 text-right" value="0"></td>
                    <td class="p-3"><input type="number" oninput="calc(${id},'s')" class="qty w-full border-gray-200 rounded p-1 text-center" value="1"></td>
                    <td class="p-3 bg-blue-50/50"><input type="number" class="due w-full bg-transparent border-none font-bold text-blue-700 text-right" readonly value="0"></td>
                    <td class="p-3"><input type="number" oninput="calcTotals()" class="claimed w-full border-gray-200 rounded p-1 text-right" value="0"></td>
                    <td class="p-3"><input type="text" class="remarks w-full border-none p-1 focus:ring-0 bg-transparent opacity-60 group-hover:opacity-100" placeholder="Notes..."></td>
                    <td class="p-3 text-center"><button onclick="removeRow(${id})" class="text-red-300 hover:text-red-600 transition">×</button></td>`;
            } else {
                tr.innerHTML = `
                    <td class="p-3"><input type="text" class="name w-full border-none p-1 focus:ring-0 bg-transparent font-medium" placeholder="Drug Name..."></td>
                    <td class="p-3"><input type="number" oninput="calc(${id},'d')" class="tariff w-full border-gray-200 rounded p-1 text-right" value="0"></td>
                    <td class="p-3"><input type="number" oninput="calc(${id},'d')" class="qty w-full border-gray-200 rounded p-1 text-center" value="1"></td>
                    <td class="p-3 bg-red-50/50"><input type="number" class="copay w-full bg-transparent border-none text-red-600 text-right" readonly value="0"></td>
                    <td class="p-3 bg-emerald-50/50"><input type="number" class="due w-full bg-transparent border-none font-bold text-emerald-700 text-right" readonly value="0"></td>
                    <td class="p-3"><input type="number" oninput="calcTotals()" class="claimed w-full border-gray-200 rounded p-1 text-right" value="0"></td>
                    <td class="p-3"><input type="text" class="remarks w-full border-none p-1 focus:ring-0 bg-transparent opacity-60 group-hover:opacity-100" placeholder="Notes..."></td>
                    <td class="p-3 text-center"><button onclick="removeRow(${id})" class="text-red-300 hover:text-red-600 transition">×</button></td>`;
            }
            tbody.appendChild(tr);
        }

        function calc(id, type) {
            const row = document.getElementById(`row_${id}`);
            const t = parseFloat(row.querySelector('.tariff').value) || 0;
            const q = parseFloat(row.querySelector('.qty').value) || 0;
            let due = t * q;

            if (type === 'd') {
                const cp = due * 0.10;
                row.querySelector('.copay').value = cp.toFixed(2);
                due -= cp;
            }
            row.querySelector('.due').value = due.toFixed(2);
            calcTotals();
        }

        function calcTotals() {
            let due = 0, claimed = 0;
            document.querySelectorAll('.due').forEach(i => due += parseFloat(i.value) || 0);
            document.querySelectorAll('.claimed').forEach(i => claimed += parseFloat(i.value) || 0);
            document.getElementById('grand_total_due').innerText = `₦${formatCurr(due)}`;
            document.getElementById('grand_total_claimed').innerText = `₦${formatCurr(claimed)}`;
        }

        function removeRow(id) { document.getElementById(`row_${id}`).remove(); calcTotals(); }

        async function submitVetting() {
            const getGrand = (id) => parseFloat(document.getElementById(id).innerText.replace(/[₦,]/g, '')) || 0;

            const payload = {
                pa_code: document.getElementById('pa_search_input').value,
                log_request_id: document.getElementById('log_request_id').value,
                billing_month: document.getElementById('billing_month').value,
                admission_days: document.getElementById('admission_days').value,
                
                // Provider Identity Data
                sec_hcp: document.getElementById('sec_hcp_display').innerText,
                sec_hcp_code: document.getElementById('sec_hcp_code').value,
                
                // Totals for 'billvettings' table
                hcp_amount_due_grandtotal: getGrand('grand_total_due'),
                hcp_amount_claimed_grandtotal: getGrand('grand_total_claimed'),
                
                services: [],
                drugs: []
            };

            if (!payload.billing_month) return alert("Select Billing Month before saving.");

            document.querySelectorAll('#services_body tr').forEach(tr => {
                const val = tr.querySelector('.name').value;
                if(val) {
                    payload.services.push({
                        service_name: val,
                        tariff: tr.querySelector('.tariff').value,
                        qty: tr.querySelector('.qty').value,
                        hcp_amount_due: tr.querySelector('.due').value,
                        total_hcp_amount_claimed: tr.querySelector('.claimed').value,
                        remarks: tr.querySelector('.remarks').value
                    });
                }
            });

            document.querySelectorAll('#drugs_body tr').forEach(tr => {
                const val = tr.querySelector('.name').value;
                if(val) {
                    payload.drugs.push({
                        drug_name: val,
                        tariff: tr.querySelector('.tariff').value,
                        qty: tr.querySelector('.qty').value,
                        copay: tr.querySelector('.copay').value,
                        hcp_amount_due: tr.querySelector('.due').value,
                        total_hcp_amount_claimed: tr.querySelector('.claimed').value,
                        remarks: tr.querySelector('.remarks').value
                    });
                }
            });

            try {
                const res = await fetch("{{ route('bill-vetting.store') }}", {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify(payload)
                });

                if (res.ok) {
                    alert("✅ Vetting record successfully saved!");
                    window.location.href = "{{ route('bill-vetting.index') }}";
                } else {
                    const err = await res.json();
                    alert("❌ Save Error: " + (err.message || "Request failed"));
                }
            } catch (e) {
                alert("❌ Connection failed. Check server status.");
            }
        }
    </script>
</x-app-layout>