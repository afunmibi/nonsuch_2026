<div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
    <h3 class="text-lg font-bold text-indigo-800 mb-4">HCP Account Details Assignment</h3>

    <div class="mb-6 relative">
        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Search Hospital (Type 3+ characters)</label>
        <input type="text" id="hcp_search" autocomplete="off" 
               class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500" 
               placeholder="Type hospital name or code...">
        <div id="search_results" class="absolute z-10 w-full bg-white border border-slate-200 rounded-b-lg shadow-xl hidden"></div>
    </div>

    <form action="{{ route('bill-management.cm.complete', $bill->pa_code) }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="text-[10px] font-bold text-slate-400 uppercase">HCP Name</label>
                <input type="text" name="hcp_name" id="field_name" class="w-full bg-slate-50 border-slate-200 rounded text-sm" readonly>
            </div>
            <div>
                <label class="text-[10px] font-bold text-slate-400 uppercase">HCP Code</label>
                <input type="text" name="hcp_code" id="field_code" class="w-full bg-slate-50 border-slate-200 rounded text-sm" readonly>
            </div>
            <div>
                <label class="text-[10px] font-bold text-slate-400 uppercase">Bank Name</label>
                <input type="text" name="hcp_bank_name" id="field_bank" class="w-full border-slate-300 rounded text-sm" required>
            </div>
            <div>
                <label class="text-[10px] font-bold text-slate-400 uppercase">Account Number</label>
                <input type="text" name="hcp_account_number" id="field_acc_no" class="w-full border-slate-300 rounded text-sm" required>
            </div>
            <div class="col-span-2">
                <label class="text-[10px] font-bold text-slate-400 uppercase">Account Name</label>
                <input type="text" name="hcp_account_name" id="field_acc_name" class="w-full border-slate-300 rounded text-sm" required>
            </div>
            <input type="hidden" name="hcp_contact" id="field_contact">
            <input type="hidden" name="hcp_email" id="field_email">
        </div>

        <button type="submit" class="w-full mt-6 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-lg shadow-lg transition">
            Finalize & Send to Accounts
        </button>
    </form>
</div>

<script>
document.getElementById('hcp_search').addEventListener('input', function() {
    let term = this.value;
    let resultsDiv = document.getElementById('search_results');
    
    if (term.length >= 3) {
        fetch(`/hcp-search?term=${term}`)
            .then(res => res.json())
            .then(data => {
                resultsDiv.innerHTML = '';
                if (data.length > 0) {
                    resultsDiv.classList.remove('hidden');
                    data.forEach(hcp => {
                        let div = document.createElement('div');
                        div.className = 'p-3 hover:bg-indigo-50 cursor-pointer border-b border-slate-100 text-sm';
                        div.innerHTML = `<strong>${hcp.hcp_name}</strong> <span class="text-xs text-slate-400">(${hcp.hcp_code})</span>`;
                        div.onclick = function() {
                            // AUTOFILL LOGIC
                            document.getElementById('field_name').value = hcp.hcp_name;
                            document.getElementById('field_code').value = hcp.hcp_code;
                            document.getElementById('field_bank').value = hcp.hcp_bank_name;
                            document.getElementById('field_acc_no').value = hcp.hcp_account_number;
                            document.getElementById('field_acc_name').value = hcp.hcp_account_name;
                            document.getElementById('field_contact').value = hcp.hcp_contact;
                            document.getElementById('field_email').value = hcp.hcp_email;
                            
                            resultsDiv.classList.add('hidden');
                            document.getElementById('hcp_search').value = hcp.hcp_name;
                        };
                        resultsDiv.appendChild(div);
                    });
                }
            });
    } else {
        resultsDiv.classList.add('hidden');
    }
});
</script>