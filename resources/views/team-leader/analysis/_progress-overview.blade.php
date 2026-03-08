{{-- Progress Overview --}}
@if ($totalApproved > 0)
    <div class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200">
        <div class="border-b border-slate-200 p-6 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-slate-900">Development Progress</h2>
            <form action="{{ route('team-leader.analysis.sync') }}" method="POST" x-data="{ loading: false }" @submit="loading = true">
                @csrf
                <button
                    type="submit"
                    class="inline-flex items-center rounded-lg bg-orange-600 px-4 py-2 text-sm font-semibold text-white hover:bg-orange-700"
                    :disabled="loading"
                >
                    <template x-if="loading">
                        <i class='fas fa-spinner fa-spin mr-2'></i>
                    </template>
                    <template x-if="!loading">
                        <i class="fas fa-sync mr-2"></i>
                    </template>
                    <span x-text="loading ? 'Syncing...' : 'Sync Now'"></span>
                </button>
            </form>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="text-center">
                    <p class="text-3xl font-bold text-orange-600">{{ $progressPercent }}%</p>
                    <p class="mt-1 text-sm text-slate-600">Progress</p>
                </div>
                <div class="text-center">
                    <p class="text-3xl font-bold text-slate-900">{{ $totalApproved }}</p>
                    <p class="mt-1 text-sm text-slate-600">Approved Stories</p>
                </div>
                <div class="text-center">
                    <p class="text-3xl font-bold text-emerald-600">{{ $coveredCount }}</p>
                    <p class="mt-1 text-sm text-slate-600">Covered</p>
                </div>
                <div class="text-center">
                    <p class="text-3xl font-bold text-red-600">{{ $gapCount }}</p>
                    <p class="mt-1 text-sm text-slate-600">Gaps</p>
                </div>
            </div>
            <div class="mt-6">
                <div class="w-full bg-slate-200 rounded-full h-3">
                    <div class="bg-emerald-500 h-3 rounded-full transition-all" style="width: {{ $progressPercent }}%"></div>
                </div>
            </div>
            @if ($team->progress_summary)
                <div class="mt-6 pt-6 border-t border-slate-200">
                    <p class="text-sm font-medium text-slate-900 mb-2">AI Progress Summary</p>
                    <p class="text-sm text-slate-600 leading-relaxed">{{ $team->progress_summary }}</p>
                </div>
            @endif
        </div>
    </div>
@endif
