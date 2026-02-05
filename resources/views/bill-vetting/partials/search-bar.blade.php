<div class="bg-white p-4 rounded-lg shadow-sm border border-slate-200 mb-6">
    <form action="{{ route('bill-vetting.index') }}" method="GET" class="flex items-center gap-2">
        <div class="relative flex-1">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </span>
            <input type="text" name="search_pa" placeholder="Enter PA Code (e.g., PA-12345)..." 
                   class="block w-full pl-10 pr-3 py-2 border border-slate-300 rounded-md leading-5 bg-white text-sm placeholder-slate-500 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                   value="{{ $pa_code ?? '' }}">
        </div>
        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-bold rounded-md shadow-sm text-white bg-slate-800 hover:bg-slate-900 focus:outline-none">
            Search
        </button>
    </form>
</div>