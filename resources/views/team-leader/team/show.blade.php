<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-6xl sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight text-slate-900">{{ $team->name }}</h1>
                    <p class="mt-2 text-sm text-slate-600">{{ $team->description ?? 'No description yet' }}</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('projects.show', $team->slug) }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center rounded-lg border border-slate-300 px-6 py-3 text-sm font-semibold text-slate-900 hover:bg-slate-50">
                        <i class="fas fa-external-link-alt mr-2"></i> Public Page
                    </a>
                    <a href="{{ route('team-leader.team.edit') }}" class="inline-flex items-center justify-center rounded-lg bg-orange-600 px-6 py-3 text-sm font-semibold text-white hover:bg-orange-700">
                        <i class="fas fa-edit mr-2"></i> Edit Team
                    </a>
                </div>
            </div>

            {{-- Flash Messages --}}
            @if ($message = session('success'))
                <div class="mb-6 rounded-2xl bg-emerald-50 p-4 ring-1 ring-emerald-200">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-check-circle text-lg text-emerald-600"></i>
                        <div>
                            <h3 class="font-semibold text-emerald-900">Success</h3>
                            <p class="mt-1 text-sm text-emerald-700">{{ $message }}</p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Team Info --}}
            <div class="space-y-6">
                <div class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200">
                    <div class="border-b border-slate-200 p-6">
                        <h2 class="text-lg font-semibold text-slate-900">Team Information</h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <p class="text-sm font-semibold text-slate-600">Team Name</p>
                                <p class="mt-1 text-slate-900">{{ $team->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-600">Slug</p>
                                <p class="mt-1 text-slate-900">{{ $team->slug }}</p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-sm font-semibold text-slate-600">Description</p>
                                <p class="mt-1 text-slate-900">{{ $team->description ?? 'No description' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Project Analysis Card --}}
                <a href="{{ route('team-leader.analysis.show') }}" class="block bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200 hover:shadow-md transition">
                    <div class="p-6 flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-brain text-xl text-orange-600"></i>
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-slate-900">Project Analysis</h2>
                                <p class="text-sm text-slate-500">
                                    @if ($team->analysis_status === 'completed')
                                        {{ $team->userStories()->where('status', 'approved')->count() }} approved stories
                                    @elseif ($team->analysis_status === 'processing')
                                        Generating stories...
                                    @else
                                        Upload documents and generate AI user stories
                                    @endif
                                </p>
                            </div>
                        </div>
                        <i class="fas fa-chevron-right text-slate-400"></i>
                    </div>
                </a>

                {{-- Repositories Section --}}
                <div class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200">
                    <div class="border-b border-slate-200 p-6 flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-slate-900">Repositories</h2>
                        <a href="{{ route('team-leader.repositories.create') }}" class="inline-flex items-center rounded-lg bg-orange-600 px-4 py-2 text-sm font-semibold text-white hover:bg-orange-700">
                            <i class="fas fa-plus mr-2"></i> Connect Repository
                        </a>
                    </div>
                    <div class="p-6">
                        @if ($team->repositories->count() > 0)
                            <div class="space-y-3">
                                @foreach ($team->repositories as $repository)
                                    <a href="{{ route('team-leader.repositories.show', $repository) }}" class="flex items-center justify-between rounded-lg border border-slate-200 p-4 hover:bg-slate-50 transition">
                                        <div class="flex items-center gap-3">
                                            <i class="fab fa-github text-xl text-slate-700"></i>
                                            <div>
                                                <p class="font-semibold text-slate-900">{{ $repository->full_name }}</p>
                                                <p class="text-sm text-slate-500">{{ $repository->description ?? 'No description' }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-4 text-sm text-slate-500">
                                            <span><i class="fas fa-code-branch mr-1"></i> {{ $repository->default_branch }}</span>
                                            @if ($repository->last_synced_at)
                                                <span><i class="fas fa-sync mr-1"></i> {{ $repository->last_synced_at->diffForHumans() }}</span>
                                            @else
                                                <span class="text-amber-600"><i class="fas fa-exclamation-circle mr-1"></i> Not synced</span>
                                            @endif
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-6">
                                <i class="fab fa-github text-4xl text-slate-300 mb-4 block"></i>
                                <p class="text-slate-600">No repositories connected yet.</p>
                                <a href="{{ route('team-leader.repositories.create') }}" class="mt-4 inline-flex items-center justify-center rounded-lg bg-orange-600 px-6 py-3 text-sm font-semibold text-white hover:bg-orange-700">
                                    <i class="fas fa-plus mr-2"></i> Connect Your First Repository
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
