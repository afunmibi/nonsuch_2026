<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold leading-tight text-gray-800">
            {{ __('Feedback & Complaints Management') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50/50">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white p-8 shadow-sm rounded-3xl border border-gray-100">
                <div class="mb-8 text-center">
                    <div class="inline-flex p-4 bg-indigo-50 rounded-2xl text-indigo-600 mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" /></svg>
                    </div>
                    <h3 class="text-2xl font-black text-gray-900">Your Opinion Matters</h3>
                    <p class="text-gray-500">We value your feedback and treat complaints with utmost priority.</p>
                </div>

                <form method="POST" action="{{ route('feedback.store') }}" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="block text-xs font-black uppercase text-gray-400 tracking-widest">Policy No</label>
                            <input type="text" name="policy_no" value="{{ $policy_no }}" class="w-full rounded-2xl border-gray-100 bg-gray-50 focus:ring-indigo-500 font-bold" required>
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-black uppercase text-gray-400 tracking-widest">PA Code (Optional)</label>
                            <input type="text" name="pa_code" value="{{ $pa_code }}" class="w-full rounded-2xl border-gray-100 bg-gray-50 focus:ring-indigo-500 font-mono font-bold">
                        </div>
                    </div>

                    <div class="space-y-4">
                        <label class="block text-xs font-black uppercase text-gray-400 tracking-widest text-center">Select Type</label>
                        <div class="flex flex-wrap justify-center gap-4">
                            <label class="relative cursor-pointer group">
                                <input type="radio" name="type" value="feedback" class="sr-only peer" checked>
                                <div class="px-6 py-3 rounded-2xl border-2 border-gray-100 text-gray-400 font-bold peer-checked:border-indigo-600 peer-checked:text-indigo-600 peer-checked:bg-indigo-50 transition-all">
                                    Feedback
                                </div>
                            </label>
                            <label class="relative cursor-pointer group">
                                <input type="radio" name="type" value="complaint" class="sr-only peer">
                                <div class="px-6 py-3 rounded-2xl border-2 border-gray-100 text-gray-400 font-bold peer-checked:border-rose-600 peer-checked:text-rose-600 peer-checked:bg-rose-50 transition-all">
                                    Complaint
                                </div>
                            </label>
                            <label class="relative cursor-pointer group">
                                <input type="radio" name="type" value="review" class="sr-only peer">
                                <div class="px-6 py-3 rounded-2xl border-2 border-gray-100 text-gray-400 font-bold peer-checked:border-amber-600 peer-checked:text-amber-600 peer-checked:bg-amber-50 transition-all">
                                    Review
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-xs font-black uppercase text-gray-400 tracking-widest">Rating</label>
                        <div class="flex justify-center gap-2" x-data="{ rating: 0 }">
                            <template x-for="i in 5">
                                <button type="button" @click="rating = i" class="transition-transform active:scale-90">
                                    <svg class="w-10 h-10" :class="rating >= i ? 'text-amber-400 fill-current' : 'text-gray-200'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.382-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" /></svg>
                                </button>
                            </template>
                            <input type="hidden" name="rating" x-model="rating">
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="block text-xs font-black uppercase text-gray-400 tracking-widest">Your Message</label>
                        <textarea name="comment" rows="5" class="w-full rounded-2xl border-gray-100 bg-gray-50 focus:ring-indigo-500 font-semibold" placeholder="Share your experience or describe your complaint in detail..." required></textarea>
                    </div>

                    <button type="submit" class="w-full py-4 bg-gray-900 hover:bg-black text-white rounded-2xl font-black shadow-2xl transition-all hover:scale-[1.02] active:scale-95">
                        Submit Interaction
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
