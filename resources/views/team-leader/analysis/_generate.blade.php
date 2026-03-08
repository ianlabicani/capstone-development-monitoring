{{-- Generate Button --}}
<div class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200">
    <div class="p-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-semibold text-slate-900">AI Story Generation</h2>
                <p class="mt-1 text-sm text-slate-500">
                    @if ($team->analysis_status === 'processing')
                        <span class="text-orange-600"><i class="fas fa-spinner fa-spin mr-1"></i> Generating stories...</span>
                    @elseif ($team->analysis_status === 'completed')
                        <span class="text-emerald-600"><i class="fas fa-check mr-1"></i> Last generated {{ $team->analysis_completed_at?->diffForHumans() }}</span>
                    @elseif ($team->analysis_status === 'stale')
                        <span class="text-amber-600"><i class="fas fa-exclamation-triangle mr-1"></i> Input changed — regeneration recommended</span>
                    @else
                        Provide input above, then choose a source to generate user stories
                    @endif
                </p>
            </div>
        </div>
        @php
            $hasFiles = $team->documents->where('type', 'file')->isNotEmpty();
            $hasText = $team->documents->firstWhere('type', 'text') !== null;
            $isProcessing = $team->analysis_status === 'processing';
        @endphp
        <div class="mt-4 flex flex-wrap items-center gap-3" x-data="{ isGenerating: false }">
          @if (false)
              <form action="{{ route('team-leader.analysis.generate') }}" method="POST" @submit="isGenerating = true">
                @csrf
                <input type="hidden" name="source" value="files">
                <button
                    type="submit"
                    @if (!$hasFiles || $isProcessing) disabled @endif
                    class="inline-flex items-center rounded-lg bg-orange-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-orange-700 disabled:opacity-50 disabled:cursor-not-allowed"
                    :disabled="isGenerating"
                >
                    <template x-if="isGenerating">
                        <i class='fas fa-spinner fa-spin mr-2'></i>
                    </template>
                    <template x-if="!isGenerating">
                        <i class="fas fa-file-alt mr-2"></i>
                    </template>
                    <span x-text="isGenerating ? 'Generating...' : 'Generate from Files'"></span>
                </button>
            </form>
          @endif
            <form action="{{ route('team-leader.analysis.generate') }}" method="POST" @submit="isGenerating = true">
                @csrf
                <input type="hidden" name="source" value="text">
                <button
                    type="submit"
                    @if (!$hasText || $isProcessing) disabled @endif
                    class="inline-flex items-center rounded-lg border-2 border-orange-600 px-5 py-2.5 text-sm font-semibold text-orange-600 hover:bg-orange-50 disabled:opacity-50 disabled:cursor-not-allowed"
                    :disabled="isGenerating"
                >
                    <template x-if="isGenerating">
                        <i class='fas fa-spinner fa-spin mr-2'></i>
                    </template>
                    <template x-if="!isGenerating">
                        <i class="fas fa-align-left mr-2"></i>
                    </template>
                    <span x-text="isGenerating ? 'Generating...' : 'Generate from Description'"></span>
                </button>
            </form>
        </div>
        <div class="mt-3" x-data="{ show: false }" x-init="$watch('document.title', () => { if(new URLSearchParams(window.location.search).has('justGenerated')) { show = true; setTimeout(() => show = false, 6000); } })">
            <template x-if="show">
                <div class="relative rounded-lg bg-blue-50 p-4 ring-1 ring-blue-200">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-info-circle text-lg text-blue-600 mt-0.5"></i>
                        <div class="text-sm text-blue-700">
                            <p class="font-semibold">Generation started!</p>
                            <p class="mt-1">Analysis is processing in the background. Come back in a few minutes to review the new user stories.</p>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>
