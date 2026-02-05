<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-bold leading-tight text-gray-800">
                {{ __('Feedback & Complaints Registry') }}
            </h2>
            <a href="{{ route('feedback.create') }}" class="px-4 py-2 bg-gray-900 text-white rounded-lg text-sm font-bold hover:bg-black transition">
                Log Feedback
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($feedbacks as $item)
                <div class="bg-white p-6 shadow-sm rounded-3xl border border-gray-100 flex flex-col hover:shadow-xl hover:shadow-indigo-50 transition-all">
                    <div class="flex justify-between items-start mb-4">
                        <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest
                            {{ $item->type == 'complaint' ? 'bg-rose-50 text-rose-600' : ($item->type == 'review' ? 'bg-amber-50 text-amber-600' : 'bg-indigo-50 text-indigo-600') }}">
                            {{ $item->type }}
                        </span>
                        <div class="flex text-amber-400">
                            @for($i=0; $i<$item->rating; $i++)
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                            @endfor
                        </div>
                    </div>

                    <div class="flex-1">
                        <p class="text-gray-700 font-medium leading-relaxed mb-4">"{{ $item->comment }}"</p>
                    </div>

                    <div class="mt-4 pt-4 border-t border-gray-50 flex items-center justify-between">
                        <div>
                            <div class="text-[10px] font-black uppercase text-gray-400 tracking-widest">Target Policy</div>
                            <div class="text-sm font-bold text-gray-900 font-mono">{{ $item->policy_no }}</div>
                        </div>
                        <div class="text-right">
                            <div class="text-[10px] font-black uppercase text-gray-400 tracking-widest">Logged By</div>
                            <div class="text-xs font-bold text-gray-600">{{ $item->user->name ?? 'System' }}</div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-20 text-center">
                    <div class="text-gray-400 italic">No feedback entries yet.</div>
                </div>
                @endforelse
            </div>
            
            <div class="mt-8">
                {{ $feedbacks->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
