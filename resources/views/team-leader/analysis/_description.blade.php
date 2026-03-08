{{-- Project Description (Plain Text) --}}
@php $textDoc = $team->documents->firstWhere('type', 'text'); @endphp
<div class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200">
    <div class="border-b border-slate-200 p-6">
        <h2 class="text-lg font-semibold text-slate-900">Project Description</h2>
        <p class="mt-1 text-sm text-slate-500">Describe your project goals, features, and scope in plain text as an alternative to file uploads</p>
    </div>
    <div class="p-6">
        <form action="{{ route('team-leader.analysis.save-text') }}" method="POST" x-data="{ changed: false, loading: false }" @submit="loading = true">
            @csrf
            <textarea
                name="content"
                rows="8"
                maxlength="50000"
                placeholder="Describe your project here — objectives, key features, target users, tech stack, scope..."
                class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm text-slate-900 placeholder-slate-400 focus:border-orange-500 focus:ring-1 focus:ring-orange-500"
                @input="changed = true"
            >{{ old('content', $textDoc?->content) }}</textarea>
            @error('content')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
            <div class="mt-3 flex items-center justify-between">
                <p class="text-xs text-slate-400">Max 50,000 characters</p>
                <div class="flex items-center gap-2">
                    @if ($textDoc)
                        <form action="{{ route('team-leader.analysis.delete-text') }}" method="POST" class="inline" x-data="{ loading: false }" @submit.prevent="if (confirm('Clear the project description?')) { loading = true; $el.submit(); }">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center rounded-lg border border-red-300 px-4 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-50" :disabled="loading">
                                <template x-if="loading">
                                    <i class='fas fa-spinner fa-spin mr-1'></i>
                                </template>
                                <template x-if="!loading">
                                    <i class="fas fa-trash mr-1"></i>
                                </template>
                                <span x-text="loading ? 'Clearing...' : 'Clear'"></span>
                            </button>
                        </form>
                    @endif
                    <button type="submit" class="inline-flex items-center rounded-lg bg-orange-600 px-4 py-1.5 text-xs font-semibold text-white hover:bg-orange-700" x-bind:class="{ 'ring-2 ring-orange-300': changed }" :disabled="loading">
                        <template x-if="loading">
                            <i class='fas fa-spinner fa-spin mr-1'></i>
                        </template>
                        <template x-if="!loading">
                            <i class="fas fa-save mr-1"></i>
                        </template>
                        <span x-text="loading ? 'Saving...' : 'Save Description'"></span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
