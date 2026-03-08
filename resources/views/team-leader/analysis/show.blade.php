<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-6xl sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight text-slate-900">Project Analysis</h1>
                    <p class="mt-2 text-sm text-slate-600">Upload documents and manage AI-generated user stories for {{ $team->name }}</p>
                </div>
                <a href="{{ route('team-leader.team.show') }}" class="inline-flex items-center justify-center rounded-lg border border-slate-300 px-6 py-3 text-sm font-semibold text-slate-900 hover:bg-slate-50">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Team
                </a>
            </div>

            {{-- Flash Messages --}}
            @if ($message = session('success'))
                <div class="mb-6 rounded-2xl bg-emerald-50 p-4 ring-1 ring-emerald-200">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-check-circle text-lg text-emerald-600"></i>
                        <p class="text-sm text-emerald-700">{{ $message }}</p>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 rounded-2xl bg-red-50 p-4 ring-1 ring-red-200">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-exclamation-circle text-lg text-red-600"></i>
                        <div>
                            @foreach ($errors->all() as $error)
                                <p class="text-sm text-red-700">{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <div class="space-y-6">
                {{-- Progress Overview --}}
                @if ($totalApproved > 0)
                    <div class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200">
                        <div class="border-b border-slate-200 p-6 flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-slate-900">Development Progress</h2>
                            <form action="{{ route('team-leader.analysis.sync') }}" method="POST">
                                @csrf
                                <button
                                    type="submit"
                                    class="inline-flex items-center rounded-lg bg-orange-600 px-4 py-2 text-sm font-semibold text-white hover:bg-orange-700"
                                >
                                    <i class="fas fa-sync mr-2"></i> Sync Now
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

                {{-- Documents Section --}}
                <div class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200">
                    <div class="border-b border-slate-200 p-6">
                        <h2 class="text-lg font-semibold text-slate-900">Project Documents</h2>
                        <p class="mt-1 text-sm text-slate-500">Upload up to 2 files (PDF or TXT, max 10MB each)</p>
                    </div>
                    <div class="p-6 space-y-4">
                        @foreach ([1, 2] as $slot)
                            @php $doc = $team->documents->where('type', 'file')->firstWhere('slot', $slot); @endphp
                            <div class="flex items-center justify-between rounded-lg border border-slate-200 p-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg flex items-center justify-center {{ $doc ? 'bg-orange-100' : 'bg-slate-100' }}">
                                        <i class="fas fa-file{{ $doc ? (str_ends_with($doc->original_name, '.txt') ? '-alt' : '-pdf') : '' }} text-lg {{ $doc ? 'text-orange-600' : 'text-slate-400' }}"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-slate-900">Document {{ $slot }}</p>
                                        @if ($doc)
                                            <p class="text-xs text-slate-500">{{ $doc->original_name }} ({{ number_format($doc->file_size / 1024, 0) }} KB)</p>
                                        @else
                                            <p class="text-xs text-slate-400">No file uploaded</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    @if ($doc)
                                        <form action="{{ route('team-leader.analysis.delete-document', $doc) }}" method="POST" onsubmit="return confirm('Remove this document?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center rounded-lg border border-red-300 px-3 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-50">
                                                <i class="fas fa-trash mr-1"></i> Remove
                                            </button>
                                        </form>
                                    @endif
                                    <form action="{{ route('team-leader.analysis.upload-document') }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-2" x-data="{ fileName: '' }">
                                        @csrf
                                        <input type="hidden" name="slot" value="{{ $slot }}">
                                        <label class="inline-flex items-center rounded-lg border border-slate-300 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50 cursor-pointer">
                                            <i class="fas fa-upload mr-1"></i>
                                            <span x-text="fileName || '{{ $doc ? 'Replace' : 'Upload' }}'"></span>
                                            <input type="file" name="document" accept=".pdf,.txt" class="hidden" @change="fileName = $event.target.files[0]?.name; $el.closest('form').submit()">
                                        </label>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Project Description (Plain Text) --}}
                @php $textDoc = $team->documents->firstWhere('type', 'text'); @endphp
                <div class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200">
                    <div class="border-b border-slate-200 p-6">
                        <h2 class="text-lg font-semibold text-slate-900">Project Description</h2>
                        <p class="mt-1 text-sm text-slate-500">Describe your project goals, features, and scope in plain text as an alternative to file uploads</p>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('team-leader.analysis.save-text') }}" method="POST" x-data="{ changed: false }">
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
                                        <form action="{{ route('team-leader.analysis.delete-text') }}" method="POST" onsubmit="return confirm('Clear the project description?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center rounded-lg border border-red-300 px-4 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-50">
                                                <i class="fas fa-trash mr-1"></i> Clear
                                            </button>
                                        </form>
                                    @endif
                                    <button type="submit" class="inline-flex items-center rounded-lg bg-orange-600 px-4 py-1.5 text-xs font-semibold text-white hover:bg-orange-700" x-bind:class="{ 'ring-2 ring-orange-300': changed }">
                                        <i class="fas fa-save mr-1"></i> Save Description
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

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
                        <div class="mt-4 flex flex-wrap items-center gap-3">
                            <form action="{{ route('team-leader.analysis.generate') }}" method="POST">
                                @csrf
                                <input type="hidden" name="source" value="files">
                                <button
                                    type="submit"
                                    @if (!$hasFiles || $isProcessing) disabled @endif
                                    class="inline-flex items-center rounded-lg bg-orange-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-orange-700 disabled:opacity-50 disabled:cursor-not-allowed"
                                >
                                    <i class="fas fa-file-alt mr-2"></i> Generate from Files
                                </button>
                            </form>
                            <form action="{{ route('team-leader.analysis.generate') }}" method="POST">
                                @csrf
                                <input type="hidden" name="source" value="text">
                                <button
                                    type="submit"
                                    @if (!$hasText || $isProcessing) disabled @endif
                                    class="inline-flex items-center rounded-lg border-2 border-orange-600 px-5 py-2.5 text-sm font-semibold text-orange-600 hover:bg-orange-50 disabled:opacity-50 disabled:cursor-not-allowed"
                                >
                                    <i class="fas fa-align-left mr-2"></i> Generate from Description
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- User Stories --}}
                @if ($team->userStories->count() > 0)
                    <div class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200">
                        <div class="border-b border-slate-200 p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h2 class="text-lg font-semibold text-slate-900">User Stories ({{ $team->userStories->count() }})</h2>
                                    <p class="mt-1 text-sm text-slate-500">Review, edit, and approve stories before they are used for progress tracking</p>
                                </div>
                                @php $draftCount = $team->userStories->where('status', \App\Enums\UserStoryStatus::Draft)->count(); @endphp
                                @if ($draftCount > 0)
                                    <form action="{{ route('team-leader.analysis.approve-all') }}" method="POST">
                                        @csrf
                                        <button
                                            type="submit"
                                            class="inline-flex items-center rounded-lg bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-emerald-700"
                                        >
                                            <i class="fas fa-check mr-2"></i> Approve All ({{ $draftCount }})
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                        <div class="divide-y divide-slate-200">
                            @foreach ($team->userStories->sortBy('sort_order') as $story)
                                <div class="p-6" x-data="{ editing: false }">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-1">
                                                {{-- Status badge --}}
                                                @if ($story->status === \App\Enums\UserStoryStatus::Approved)
                                                    @if ($story->is_covered)
                                                        <span class="inline-flex items-center rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-medium text-emerald-800">
                                                            <i class="fas fa-check mr-1"></i> Covered
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center rounded-full bg-red-100 px-2 py-0.5 text-xs font-medium text-red-800">
                                                            <i class="fas fa-exclamation mr-1"></i> Gap
                                                        </span>
                                                    @endif
                                                @endif
                                                <span class="inline-flex items-center rounded-full bg-{{ $story->status->color() }}-100 px-2 py-0.5 text-xs font-medium text-{{ $story->status->color() }}-800">
                                                    {{ $story->status->label() }}
                                                </span>
                                            </div>

                                            {{-- Display mode --}}
                                            <div x-show="!editing">
                                                <p class="text-sm font-semibold text-slate-900">{{ $story->title }}</p>
                                                @if ($story->description)
                                                    <p class="mt-1 text-sm text-slate-600">{{ $story->description }}</p>
                                                @endif
                                                @if ($story->keywords)
                                                    <div class="mt-2 flex flex-wrap gap-1">
                                                        @foreach ($story->keywords as $keyword)
                                                            <span class="inline-block rounded bg-slate-100 px-2 py-0.5 text-xs text-slate-600">{{ $keyword }}</span>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>

                                            {{-- Edit mode --}}
                                            <div x-show="editing" x-cloak>
                                                <form action="{{ route('team-leader.analysis.update-story', $story) }}" method="POST" class="space-y-3">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="text" name="title" value="{{ $story->title }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 focus:border-orange-500 focus:ring-1 focus:ring-orange-500">
                                                    <textarea name="description" rows="2" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 focus:border-orange-500 focus:ring-1 focus:ring-orange-500">{{ $story->description }}</textarea>
                                                    <div class="flex gap-2">
                                                        <button type="submit" class="inline-flex items-center rounded-lg bg-orange-600 px-4 py-1.5 text-xs font-semibold text-white hover:bg-orange-700">Save</button>
                                                        <button type="button" @click="editing = false" class="inline-flex items-center rounded-lg border border-slate-300 px-4 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50">Cancel</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        {{-- Actions --}}
                                        <div class="flex items-center gap-1" x-show="!editing">
                                            <button @click="editing = true" class="inline-flex items-center rounded-lg border border-slate-300 px-2 py-1.5 text-xs text-slate-600 hover:bg-slate-50" title="Edit">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                            <form action="{{ route('team-leader.analysis.approve-story', $story) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center rounded-lg border px-2 py-1.5 text-xs hover:bg-slate-50 {{ $story->status === \App\Enums\UserStoryStatus::Approved ? 'border-emerald-300 text-emerald-600' : 'border-slate-300 text-slate-600' }}" title="{{ $story->status === \App\Enums\UserStoryStatus::Approved ? 'Unapprove' : 'Approve' }}">
                                                    <i class="fas fa-{{ $story->status === \App\Enums\UserStoryStatus::Approved ? 'check-circle' : 'circle' }}"></i>
                                                </button>
                                            </form>
                                            @if ($story->status === \App\Enums\UserStoryStatus::Approved)
                                                <form action="{{ route('team-leader.analysis.toggle-achievement', $story) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="inline-flex items-center rounded-lg border px-2 py-1.5 text-xs hover:bg-slate-50 {{ $story->is_covered ? 'border-amber-300 text-amber-600' : 'border-slate-300 text-slate-600' }}" title="{{ $story->is_covered ? 'Mark as not achieved' : 'Mark as achieved' }}">
                                                        <i class="fas fa-{{ $story->is_covered ? 'star' : 'star' }} fa-{{ $story->is_covered ? '' : 'regular' }}"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            <form action="{{ route('team-leader.analysis.delete-story', $story) }}" method="POST" onsubmit="return confirm('Delete this story?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center rounded-lg border border-red-300 px-2 py-1.5 text-xs text-red-600 hover:bg-red-50" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Add Manual Story --}}
                    <div class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200">
                        <div class="border-b border-slate-200 p-6">
                            <h2 class="text-lg font-semibold text-slate-900">Add User Story Manually</h2>
                            <p class="mt-1 text-sm text-slate-500">Create user stories directly without AI analysis</p>
                        </div>
                        <div class="p-6">
                            <form action="{{ route('team-leader.analysis.store-story') }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label for="story_title" class="block text-sm font-medium text-slate-900 mb-1">Story Title</label>
                                    <input
                                        type="text"
                                        id="story_title"
                                        name="title"
                                        value="{{ old('title') }}"
                                        placeholder="e.g., User Authentication System"
                                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:border-orange-500 focus:ring-1 focus:ring-orange-500"
                                        required
                                    >
                                    @error('title')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="story_description" class="block text-sm font-medium text-slate-900 mb-1">Description</label>
                                    <textarea
                                        id="story_description"
                                        name="description"
                                        rows="3"
                                        placeholder="Describe what this user story involves..."
                                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:border-orange-500 focus:ring-1 focus:ring-orange-500"
                                        required
                                    >{{ old('description') }}</textarea>
                                    @error('description')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="flex justify-end">
                                    <button
                                        type="submit"
                                        class="inline-flex items-center rounded-lg bg-orange-600 px-6 py-2.5 text-sm font-semibold text-white hover:bg-orange-700"
                                    >
                                        <i class="fas fa-plus mr-2"></i> Add Story
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @elseif ($team->documents->isEmpty())
                    <div class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200">
                        <div class="p-6 text-center">
                            <i class="fas fa-file-upload text-4xl text-slate-300 mb-4 block"></i>
                            <p class="text-slate-600">Provide project input to get started.</p>
                            <p class="mt-1 text-sm text-slate-500">Upload files (PDF or TXT) or write a project description above.</p>
                        </div>
                    </div>
                @else
                    {{-- Add Manual Story (when no AI stories exist but documents do) --}}
                    <div class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200">
                        <div class="border-b border-slate-200 p-6">
                            <h2 class="text-lg font-semibold text-slate-900">Add User Story Manually</h2>
                            <p class="mt-1 text-sm text-slate-500">Create user stories directly without AI analysis</p>
                        </div>
                        <div class="p-6">
                            <form action="{{ route('team-leader.analysis.store-story') }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label for="story_title" class="block text-sm font-medium text-slate-900 mb-1">Story Title</label>
                                    <input
                                        type="text"
                                        id="story_title"
                                        name="title"
                                        value="{{ old('title') }}"
                                        placeholder="e.g., User Authentication System"
                                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:border-orange-500 focus:ring-1 focus:ring-orange-500"
                                        required
                                    >
                                    @error('title')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="story_description" class="block text-sm font-medium text-slate-900 mb-1">Description</label>
                                    <textarea
                                        id="story_description"
                                        name="description"
                                        rows="3"
                                        placeholder="Describe what this user story involves..."
                                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:border-orange-500 focus:ring-1 focus:ring-orange-500"
                                        required
                                    >{{ old('description') }}</textarea>
                                    @error('description')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="flex justify-end">
                                    <button
                                        type="submit"
                                        class="inline-flex items-center rounded-lg bg-orange-600 px-6 py-2.5 text-sm font-semibold text-white hover:bg-orange-700"
                                    >
                                        <i class="fas fa-plus mr-2"></i> Add Story
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
