<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-6xl sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="mb-6">
                <h1 class="text-3xl font-bold tracking-tight text-slate-900">Teams</h1>
                <p class="mt-2 text-sm text-slate-600">All capstone teams and their development progress.</p>
            </div>

            {{-- Teams Grid --}}
            @if ($teams->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach ($teams as $team)
                        <a href="{{ route('capstone-teacher.teams.show', $team) }}" class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200 hover:shadow-md transition block">
                            <div class="border-b border-slate-200 p-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h2 class="text-lg font-semibold text-slate-900">{{ $team->name }}</h2>
                                        <p class="mt-1 text-sm text-slate-500">Leader: {{ $team->owner->name }}</p>
                                    </div>
                                    <i class="fas fa-chevron-right text-slate-400"></i>
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="grid grid-cols-3 gap-4 text-center">
                                    <div>
                                        <p class="text-2xl font-bold text-orange-600">{{ $team->total_commits }}</p>
                                        <p class="text-xs text-slate-500">Total Commits</p>
                                    </div>
                                    <div>
                                        <p class="text-2xl font-bold text-orange-600">{{ $team->weekly_commits }}</p>
                                        <p class="text-xs text-slate-500">This Week</p>
                                    </div>
                                    <div>
                                        <p class="text-2xl font-bold text-orange-600">{{ $team->contributors_count }}</p>
                                        <p class="text-xs text-slate-500">Contributors</p>
                                    </div>
                                </div>
                                @if ($team->repositories->count() > 0)
                                    <div class="mt-4 pt-4 border-t border-slate-100">
                                        <p class="text-xs text-slate-500 mb-2">Repositories ({{ $team->repositories->count() }})</p>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach ($team->repositories as $repo)
                                                <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-3 py-1 text-xs text-slate-700">
                                                    <i class="fab fa-github"></i> {{ $repo->github_repo }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <div class="mt-4 pt-4 border-t border-slate-100 text-center">
                                        <p class="text-xs text-slate-400">No repositories connected</p>
                                    </div>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200">
                    <div class="p-6 text-center">
                        <i class="fas fa-users text-4xl text-slate-300 mb-4 block"></i>
                        <p class="text-slate-600">No teams to monitor yet.</p>
                        <p class="mt-1 text-sm text-slate-500">Teams will appear here once team leaders create them.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
