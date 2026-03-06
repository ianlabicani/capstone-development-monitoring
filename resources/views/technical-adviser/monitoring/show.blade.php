<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-6xl sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight text-slate-900">{{ $team->name }}</h1>
                    <p class="mt-2 text-sm text-slate-600">Led by {{ $team->owner->name }} &middot; {{ $team->description ?? 'No description' }}</p>
                </div>
                <a href="{{ route('technical-adviser.monitoring.index') }}" class="inline-flex items-center justify-center rounded-lg border border-slate-300 px-6 py-3 text-sm font-semibold text-slate-900 hover:bg-slate-50">
                    <i class="fas fa-arrow-left mr-2"></i> Back
                </a>
            </div>

            {{-- Stats Grid --}}
            <div class="mb-6 grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white rounded-2xl ring-1 ring-slate-200 p-6 text-center">
                    <p class="text-3xl font-bold text-orange-600">{{ $totalCommits }}</p>
                    <p class="mt-1 text-sm text-slate-600">Total Commits</p>
                </div>
                <div class="bg-white rounded-2xl ring-1 ring-slate-200 p-6 text-center">
                    <p class="text-3xl font-bold text-orange-600">{{ $weeklyCommits }}</p>
                    <p class="mt-1 text-sm text-slate-600">This Week</p>
                </div>
                <div class="bg-white rounded-2xl ring-1 ring-slate-200 p-6 text-center">
                    <p class="text-3xl font-bold text-orange-600">{{ $contributors }}</p>
                    <p class="mt-1 text-sm text-slate-600">Contributors</p>
                </div>
                <div class="bg-white rounded-2xl ring-1 ring-slate-200 p-6 text-center">
                    <p class="text-3xl font-bold text-orange-600">{{ $team->repositories->count() }}</p>
                    <p class="mt-1 text-sm text-slate-600">Repositories</p>
                </div>
            </div>

            <div class="space-y-6">
                {{-- Repositories --}}
                <div class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200">
                    <div class="border-b border-slate-200 p-6">
                        <h2 class="text-lg font-semibold text-slate-900">Repositories</h2>
                    </div>
                    @if ($team->repositories->count() > 0)
                        <div class="divide-y divide-slate-200">
                            @foreach ($team->repositories as $repository)
                                <div class="flex items-center justify-between p-6">
                                    <div class="flex items-center gap-3">
                                        <i class="fab fa-github text-xl text-slate-700"></i>
                                        <div>
                                            <p class="font-semibold text-slate-900">{{ $repository->full_name }}</p>
                                            <p class="text-sm text-slate-500">{{ $repository->description ?? 'No description' }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-4 text-sm text-slate-500">
                                        <span><i class="fas fa-code mr-1"></i> {{ $repository->commits_count }} commits</span>
                                        <span><i class="fas fa-code-branch mr-1"></i> {{ $repository->default_branch }}</span>
                                        @if ($repository->last_synced_at)
                                            <span><i class="fas fa-sync mr-1"></i> {{ $repository->last_synced_at->diffForHumans() }}</span>
                                        @else
                                            <span class="text-amber-600"><i class="fas fa-exclamation-circle mr-1"></i> Not synced</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-6 text-center">
                            <i class="fab fa-github text-4xl text-slate-300 mb-4 block"></i>
                            <p class="text-slate-600">No repositories connected yet.</p>
                        </div>
                    @endif
                </div>

                {{-- Recent Commits --}}
                <div class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200">
                    <div class="border-b border-slate-200 p-6">
                        <h2 class="text-lg font-semibold text-slate-900">Recent Commits</h2>
                    </div>
                    @if ($recentCommits->count() > 0)
                        <div class="divide-y divide-slate-200">
                            @foreach ($recentCommits as $commit)
                                <div class="flex items-start gap-4 p-6">
                                    <div class="flex-shrink-0 mt-1">
                                        <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-code-commit text-sm text-orange-600"></i>
                                        </div>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-sm font-medium text-slate-900 truncate">{{ Str::limit($commit->message, 100) }}</p>
                                        <div class="mt-1 flex items-center gap-3 text-xs text-slate-500">
                                            <span>
                                                @if ($commit->author_login)
                                                    <i class="fas fa-user mr-1"></i> {{ $commit->author_login }}
                                                @else
                                                    <i class="fas fa-user mr-1"></i> {{ $commit->author_name }}
                                                @endif
                                            </span>
                                            <span><i class="fas fa-clock mr-1"></i> {{ $commit->committed_at->diffForHumans() }}</span>
                                            <span class="text-slate-400">{{ $commit->repository->full_name }}</span>
                                        </div>
                                    </div>
                                    <a href="{{ $commit->url }}" target="_blank" rel="noopener noreferrer" class="flex-shrink-0 font-mono text-xs text-orange-600 hover:text-orange-700">
                                        {{ substr($commit->sha, 0, 7) }}
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-6 text-center">
                            <i class="fas fa-code-commit text-4xl text-slate-300 mb-4 block"></i>
                            <p class="text-slate-600">No commits synced yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
