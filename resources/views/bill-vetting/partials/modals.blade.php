<div x-show="serviceModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm" x-cloak>
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md p-6" @click.away="serviceModal = false">
        <form action="{{ route('billVettings.addService', $billVetting->id) }}" method="POST" class="space-y-4">
            @csrf
            <h3 class="font-black text-xs uppercase text-gray-800">Vette Service</h3>
            
            <input type="text" name="service_name" placeholder="Service Description" required class="w-full border-gray-200 rounded-xl text-sm">

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-[10px] font-black text-gray-400 uppercase">Tariff</label>
                    <input type="number" step="0.01" name="tariff" id="service_tariff" oninput="calcSrv()" required class="w-full border-gray-200 rounded-xl text-sm">
                </div>
                <div>
                    <label class="text-[10px] font-black text-gray-400 uppercase">Qty</label>
                    <input type="number" name="qty" id="service_qty" value="1" oninput="calcSrv()" required class="w-full border-gray-200 rounded-xl text-sm">
                </div>
            </div>

            <div>
                <label class="text-[10px] font-black text-rose-500 uppercase">Claimed by Hospital (Manual)</label>
                <input type="number" step="0.01" name="amount_claimed" required placeholder="0.00" class="w-full border-rose-200 bg-rose-50/50 rounded-xl font-bold">
            </div>

            <input type="text" name="remarks" placeholder="Remarks (optional)" class="w-full border-gray-200 rounded-xl text-sm">

            <input type="hidden" name="hcp_amount_due_total_services" id="hcp_amount_due_total_services" value="0">

            <div class="bg-indigo-50 p-4 rounded-2xl flex justify-between items-center">
                <span class="text-xs font-black text-indigo-600 uppercase">Vetted Due:</span>
                <span id="srv_due_display" class="text-xl font-black text-indigo-700">₦0.00</span>
            </div>
            <button type="submit" class="w-full bg-indigo-600 text-white font-black py-4 rounded-2xl uppercase text-xs shadow-lg">Save Service</button>
        </form>
    </div>
</div>

<div x-show="drugModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm" x-cloak>
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md p-6" @click.away="drugModal = false">
        <form action="{{ route('billVettings.addDrug', $billVetting->id) }}" method="POST" class="space-y-4">
            @csrf
            <h3 class="font-black text-xs uppercase text-gray-800">Vette Medication</h3>

            <input type="text" name="drug_name" placeholder="Medication Name" required class="w-full border-gray-200 rounded-xl text-sm">

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-[10px] font-black text-gray-400 uppercase">Unit Price</label>
                    <input type="number" step="0.01" name="tariff" id="drug_tariff" oninput="calcDrg()" required class="w-full border-gray-200 rounded-xl text-sm">
                </div>
                <div>
                    <label class="text-[10px] font-black text-gray-400 uppercase">Qty</label>
                    <input type="number" name="qty" id="drug_qty" value="1" oninput="calcDrg()" required class="w-full border-gray-200 rounded-xl text-sm">
                </div>
            </div>

            <div>
                <label class="text-[10px] font-black text-rose-500 uppercase">Claimed by Hospital (Manual)</label>
                <input type="number" step="0.01" name="amount_claimed" required placeholder="0.00" class="w-full border-rose-200 bg-rose-50/50 rounded-xl font-bold">
            </div>

            <input type="text" name="remarks" placeholder="Remarks (optional)" class="w-full border-gray-200 rounded-xl text-sm">

            <input type="hidden" name="copayment_10" id="copayment_10" value="0">
            <input type="hidden" name="hcp_amount_due_total_drugs" id="hcp_amount_due_total_drugs" value="0">

            <div class="bg-emerald-50 p-4 rounded-2xl space-y-1">
                <div class="flex justify-between items-center text-xs font-black text-emerald-800">
                    <span class="uppercase">Vetted Due (-10%):</span>
                    <span id="drg_due_display" class="text-xl font-black text-emerald-700">₦0.00</span>
                </div>
            </div>
            <button type="submit" class="w-full bg-emerald-600 text-white font-black py-4 rounded-2xl uppercase text-xs shadow-lg">Save Drug</button>
        </form>
    </div>
</div>