{{-- User Stories --}}
@if ($team->userStories->count() > 0)
    <div class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200" x-data="{ deleteModalOpen: false, storyToDelete: null }" @keydown.escape="deleteModalOpen = false">
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

        {{-- Filters and Sort --}}
        <div class="border-t border-slate-200 p-6 space-y-4">
            {{-- Version Filter --}}
            @if ($allVersions->count() > 1)
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-3">Filter by version</p>
                    <div class="flex flex-wrap gap-2">
                        <a
                            href="{{ route('team-leader.analysis.show', ['version' => 'all', 'status' => $selectedStatus]) }}"
                            class="inline-flex items-center rounded-lg px-3 py-1.5 text-xs font-semibold ring-1 hover:ring-orange-300 transition {{ $selectedVersion === 'all' ? 'bg-orange-600 text-white ring-orange-600' : 'bg-slate-100 text-slate-700 ring-slate-200' }}"
                        >
                            All Versions
                        </a>
                        @foreach ($allVersions as $version)
                            <a
                                href="{{ route('team-leader.analysis.show', ['version' => $version, 'status' => $selectedStatus]) }}"
                                class="inline-flex items-center rounded-lg px-3 py-1.5 text-xs font-semibold ring-1 hover:ring-orange-300 transition {{ $selectedVersion === $version ? 'bg-orange-600 text-white ring-orange-600' : 'bg-slate-100 text-slate-700 ring-slate-200' }}"
                            >
                                {{ $version }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Status Filter --}}
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-3">Filter by status</p>
                <div class="flex flex-wrap gap-2">
                    <a
                        href="{{ route('team-leader.analysis.show', ['version' => $selectedVersion, 'status' => 'gap']) }}"
                        class="inline-flex items-center rounded-lg px-3 py-1.5 text-xs font-semibold ring-1 hover:ring-orange-300 transition {{ $selectedStatus === 'gap' ? 'bg-orange-600 text-white ring-orange-600' : 'bg-slate-100 text-slate-700 ring-slate-200' }}"
                    >
                        <i class="fas fa-exclamation mr-1.5"></i> Gaps
                    </a>
                    <a
                        href="{{ route('team-leader.analysis.show', ['version' => $selectedVersion, 'status' => 'approved']) }}"
                        class="inline-flex items-center rounded-lg px-3 py-1.5 text-xs font-semibold ring-1 hover:ring-orange-300 transition {{ $selectedStatus === 'approved' ? 'bg-orange-600 text-white ring-orange-600' : 'bg-slate-100 text-slate-700 ring-slate-200' }}"
                    >
                        <i class="fas fa-check mr-1.5"></i> Approved
                    </a>
                    <a
                        href="{{ route('team-leader.analysis.show', ['version' => $selectedVersion, 'status' => 'draft']) }}"
                        class="inline-flex items-center rounded-lg px-3 py-1.5 text-xs font-semibold ring-1 hover:ring-orange-300 transition {{ $selectedStatus === 'draft' ? 'bg-orange-600 text-white ring-orange-600' : 'bg-slate-100 text-slate-700 ring-slate-200' }}"
                    >
                        <i class="fas fa-pencil mr-1.5"></i> Draft
                    </a>
                </div>
            </div>
        </div>

        {{-- User Stories List --}}
        @if ($stories->count() > 0)
            <div class="divide-y divide-slate-200" x-data="{ editing: false }">
                @foreach ($stories as $story)
                    <div class="p-6" x-data="{ editing: false }">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1">
                                    {{-- Status badges --}}
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
                                    @if ($story->manually_created)
                                        <span class="inline-flex items-center rounded-full bg-blue-100 px-2 py-0.5 text-xs font-medium text-blue-800">
                                            <i class="fas fa-hand mr-1"></i> Manual
                                        </span>
                                    @endif
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
                                    <form action="{{ route('team-leader.analysis.update-story', $story) }}" method="POST" class="space-y-3" x-data="{ loading: false }" @submit="loading = true">
                                        @csrf
                                        @method('PATCH')
                                        <input type="text" name="title" value="{{ $story->title }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 focus:border-orange-500 focus:ring-1 focus:ring-orange-500">
                                        <textarea name="description" rows="2" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 focus:border-orange-500 focus:ring-1 focus:ring-orange-500">{{ $story->description }}</textarea>
                                        <div class="flex gap-2">
                                            <button type="submit" class="inline-flex items-center rounded-lg bg-orange-600 px-4 py-1.5 text-xs font-semibold text-white hover:bg-orange-700" :disabled="loading">
                                                <template x-if="loading">
                                                    <i class='fas fa-spinner fa-spin mr-1'></i>
                                                </template>
                                                <span x-text="loading ? 'Saving...' : 'Save'"></span>
                                            </button>
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
                                <form action="{{ route('team-leader.analysis.approve-story', $story) }}" method="POST" x-data="{ loading: false }" @submit="loading = true">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center rounded-lg border px-2 py-1.5 text-xs hover:bg-slate-50 {{ $story->status === \App\Enums\UserStoryStatus::Approved ? 'border-emerald-300 text-emerald-600' : 'border-slate-300 text-slate-600' }}" title="{{ $story->status === \App\Enums\UserStoryStatus::Approved ? 'Unapprove' : 'Approve' }}" :disabled="loading">
                                        <template x-if="loading">
                                            <i class='fas fa-spinner fa-spin'></i>
                                        </template>
                                        <template x-if="!loading">
                                            <i class="fas fa-{{ $story->status === \App\Enums\UserStoryStatus::Approved ? 'check-circle' : 'circle' }}"></i>
                                        </template>
                                    </button>
                                </form>
                                @if ($story->status === \App\Enums\UserStoryStatus::Approved)
                                    <form action="{{ route('team-leader.analysis.toggle-achievement', $story) }}" method="POST" x-data="{ loading: false }" @submit="loading = true">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="inline-flex items-center rounded-lg border px-2 py-1.5 text-xs hover:bg-slate-50 {{ $story->is_achieved ? 'border-amber-300 text-amber-600' : 'border-slate-300 text-slate-600' }}" :disabled="loading" title="{{ $story->is_achieved ? 'Mark as not achieved' : 'Mark as achieved' }}">
                                            <template x-if="loading">
                                                <i class='fas fa-spinner fa-spin'></i>
                                            </template>
                                            <template x-if="!loading">
                                                <i class="{{ $story->is_achieved ? 'fas' : 'far' }} fa-star"></i>
                                            </template>
                                        </button>
                                    </form>
                                @endif
                                <button type="button" @click="deleteModalOpen = true; storyToDelete = { id: {{ $story->id }}, title: '{{ addslashes($story->title) }}', route: '{{ route('team-leader.analysis.delete-story', $story) }}' }" class="inline-flex items-center rounded-lg border border-red-300 px-2 py-1.5 text-xs text-red-600 hover:bg-red-50" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="border-t border-slate-200 p-6">
                {{ $stories->links() }}
            </div>
        @else
            <div class="p-6 text-center">
                <i class="fas fa-filter text-3xl text-slate-300 mb-3 block"></i>
                <p class="text-slate-600">No stories match your filters.</p>
            </div>
        @endif

        {{-- Delete Confirmation Modal --}}
        <div x-show="deleteModalOpen && storyToDelete" @click.self="deleteModalOpen = false" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" style="display: none;">
            <div class="relative w-full max-w-sm mx-4 rounded-2xl bg-white shadow-xl ring-1 ring-slate-200">
                {{-- Modal Header --}}
                <div class="border-b border-slate-200 px-6 py-4">
                    <h3 class="text-lg font-semibold text-slate-900">Delete Story</h3>
                </div>

                {{-- Modal Body --}}
                <div class="px-6 py-4">
                    <p class="text-sm text-slate-600">Are you sure you want to delete <strong x-text="storyToDelete?.title || ''"></strong>? This action cannot be undone.</p>
                </div>

                {{-- Modal Footer --}}
                <div class="border-t border-slate-200 flex gap-3 px-6 py-4">
                    <button type="button" @click="deleteModalOpen = false" class="flex-1 inline-flex items-center justify-center rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                        Cancel
                    </button>
                    <form :action="storyToDelete?.route" method="POST" class="flex-1" x-data="{ loading: false }" @submit.prevent="loading = true; $el.submit()">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full inline-flex items-center justify-center rounded-lg border border-red-600 bg-red-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-red-700 hover:border-red-700" :disabled="loading">
                            <template x-if="loading">
                                <i class='fas fa-spinner fa-spin mr-2'></i>
                            </template>
                            <template x-if="!loading">
                                <i class="fas fa-trash mr-2"></i>
                            </template>
                            <span x-text="loading ? 'Deleting...' : 'Delete'"></span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif
