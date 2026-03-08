@props(['totalApproved', 'coveredCount', 'gapCount', 'progressPercent', 'approvedStories', 'showDocuments' => false, 'team' => null])

<div class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200">
    <div class="border-b border-slate-200 p-6">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-slate-900">AI Analysis</h2>
            @if ($totalApproved > 0)
                <span class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-sm font-medium text-emerald-800">
                    {{ $progressPercent }}% Progress
                </span>
            @else
                <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-sm font-medium text-slate-600">
                    Not Ready
                </span>
            @endif
        </div>
    </div>
    <div class="p-6">
        @if ($totalApproved > 0)
            {{-- Progress Bar --}}
            <div class="mb-6">
                <div class="flex items-center justify-between text-sm mb-2">
                    <span class="text-slate-600">Development Coverage</span>
                    <span class="font-semibold text-slate-900">{{ $coveredCount }}/{{ $totalApproved }} stories covered</span>
                </div>
                <div class="w-full bg-slate-200 rounded-full h-3">
                    <div class="bg-emerald-500 h-3 rounded-full transition-all" style="width: {{ $progressPercent }}%"></div>
                </div>
            </div>

            {{-- Stats Grid --}}
            <div class="grid grid-cols-3 gap-4 mb-6">
                <div class="text-center rounded-lg bg-slate-50 p-3">
                    <p class="text-2xl font-bold text-slate-900">{{ $totalApproved }}</p>
                    <p class="text-xs text-slate-600">Total Stories</p>
                </div>
                <div class="text-center rounded-lg bg-emerald-50 p-3">
                    <p class="text-2xl font-bold text-emerald-600">{{ $coveredCount }}</p>
                    <p class="text-xs text-emerald-700">Covered</p>
                </div>
                <div class="text-center rounded-lg bg-red-50 p-3">
                    <p class="text-2xl font-bold text-red-600">{{ $gapCount }}</p>
                    <p class="text-xs text-red-700">Gaps</p>
                </div>
            </div>

            {{-- Story List --}}
            <div class="space-y-2">
                @foreach ($approvedStories->sortBy('sort_order') as $story)
                    <div class="flex items-center gap-3 rounded-lg border border-slate-200 px-4 py-3">
                        @if ($story->is_covered)
                            <i class="fas fa-check-circle text-emerald-500"></i>
                        @else
                            <i class="fas fa-times-circle text-red-400"></i>
                        @endif
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-slate-900 truncate">{{ $story->title }}</p>
                        </div>
                        <span class="flex-shrink-0 inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium {{ $story->is_covered ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">
                            {{ $story->is_covered ? 'Covered' : 'Gap' }}
                        </span>
                    </div>
                @endforeach
            </div>

            @if ($showDocuments && $team && $team->documents->count() > 0)
                <div class="mt-4 pt-4 border-t border-slate-200">
                    <p class="text-sm font-semibold text-slate-600 mb-2">Documents</p>
                    @foreach ($team->documents as $doc)
                        <p class="text-sm text-slate-500"><i class="fas fa-file-pdf text-orange-500 mr-1"></i> {{ $doc->original_name }}</p>
                    @endforeach
                </div>
            @endif
        @else
            <div class="text-center">
                <i class="fas fa-brain text-4xl text-slate-300 mb-4 block"></i>
                <p class="text-slate-600 mb-2">No analysis available yet.</p>
                <p class="text-sm text-slate-500">The team leader needs to upload project documents and generate user stories.</p>
            </div>
        @endif
    </div>
</div>
