<div class="space-y-6 relative">
    <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-200 dark:bg-gray-700"></div>

    @forelse($audits as $audit)
        <div class="relative pl-10 group">
            <div class="absolute left-2 top-2 w-4 h-4 rounded-full border-2 border-white dark:border-gray-900 
                {{ $audit->event === 'created' ? 'bg-green-500' : ($audit->event === 'deleted' ? 'bg-red-500' : 'bg-blue-500') }}">
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
                <div class="px-4 py-3 bg-gray-50 dark:bg-gray-900/50 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        @if($audit->user)
                            <div class="w-6 h-6 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold">
                                {{ substr($audit->user->name, 0, 1) }}
                            </div>
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $audit->user->name }}</span>
                        @else
                            <span class="text-sm font-medium text-gray-500">System / Unknown</span>
                        @endif
                        
                        <span class="text-xs text-gray-400">•</span>
                        <span class="px-2 py-0.5 rounded text-xs font-bold uppercase
                            {{ $audit->event === 'created' ? 'bg-green-100 text-green-700' : ($audit->event === 'deleted' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700') }}">
                            {{ $audit->event }}
                        </span>
                    </div>
                    <div class="text-xs text-gray-500">
                        {{ $audit->created_at->format('d M Y, H:i:s') }}
                    </div>
                </div>

                <div class="p-4 grid grid-cols-2 gap-4 text-sm font-mono">
                    <div>
                        <h4 class="text-xs font-bold text-gray-500 uppercase mb-2">Before</h4>
                        @if($audit->old_values)
                            <div class="space-y-1">
                                @foreach($audit->old_values as $key => $val)
                                    <div class="flex flex-col bg-red-50 dark:bg-red-900/20 p-2 rounded">
                                        <span class="text-xs text-red-600 dark:text-red-400 font-semibold">{{ $key }}</span>
                                        <span class="text-red-800 dark:text-red-200 break-all">
                                            {{ is_array($val) ? json_encode($val) : $val }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <span class="text-gray-400 italic text-xs">- Empty -</span>
                        @endif
                    </div>

                    <div>
                        <h4 class="text-xs font-bold text-gray-500 uppercase mb-2">After</h4>
                        @if($audit->new_values)
                            <div class="space-y-1">
                                @foreach($audit->new_values as $key => $val)
                                    <div class="flex flex-col bg-green-50 dark:bg-green-900/20 p-2 rounded">
                                        <span class="text-xs text-green-600 dark:text-green-400 font-semibold">{{ $key }}</span>
                                        <span class="text-green-800 dark:text-green-200 break-all">
                                            {{ is_array($val) ? json_encode($val) : $val }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <span class="text-gray-400 italic text-xs">- Empty -</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-10 text-gray-500">
            No history recorded yet by Chronos.
        </div>
    @endforelse
</div>