<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-6xl sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight text-slate-900">{{ $team->name }}</h1>
                    <p class="mt-2 text-sm text-slate-600">Team progress and activity</p>
                </div>
                <a href="{{ route('capstone-teacher.dashboard') }}" class="inline-flex items-center justify-center rounded-lg border border-slate-300 px-6 py-3 text-sm font-semibold text-slate-900 hover:bg-slate-50">
                    <i class="fas fa-arrow-left mr-2"></i> Back
                </a>
            </div>

            {{-- Team Info Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200 p-6">
                    <p class="text-sm font-semibold text-slate-600 mb-1">Team Leader</p>
                    <p class="text-lg font-semibold text-slate-900">{{ $team->owner->name }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200 p-6">
                    <p class="text-sm font-semibold text-slate-600 mb-1">Total Commits</p>
                    <p class="text-3xl font-bold text-orange-600">{{ $totalCommits }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200 p-6">
                    <p class="text-sm font-semibold text-slate-600 mb-1">This Week</p>
                    <p class="text-3xl font-bold text-orange-600">{{ $weeklyCommits }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200 p-6">
                    <p class="text-sm font-semibold text-slate-600 mb-1">Contributors</p>
                    <p class="text-3xl font-bold text-orange-600">{{ $contributors }}</p>
                </div>
            </div>

            {{-- AI Analysis (Coming Soon) --}}
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200 mb-6">
                <div class="border-b border-slate-200 p-6">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-slate-900">AI Analysis</h2>
                        <span class="inline-flex items-center rounded-full bg-orange-100 px-3 py-1 text-sm font-medium text-orange-800">
                            Coming Soon
                        </span>
                    </div>
                </div>
                <div class="p-6 text-center">
                    <i class="fas fa-brain text-4xl text-slate-300 mb-4 block"></i>
                    <p class="text-slate-600 mb-4">Intelligent commit analysis against your team's user stories.</p>
                    <p class="text-sm text-slate-500">We're working on AI-powered insights to correlate commits with user stories and track development progress.</p>
                </div>
            </div>

            {{-- Repositories --}}
            @if ($team->repositories->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200 mb-6">
                    <div class="border-b border-slate-200 p-6">
                        <h2 class="text-lg font-semibold text-slate-900">Repositories ({{ $team->repositories->count() }})</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="border-b border-slate-200 bg-slate-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900">Repository</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900">Commits</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200">
                                @foreach ($team->repositories as $repo)
                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                <i class="fab fa-github text-slate-400"></i>
                                                <span class="text-sm text-slate-900">{{ $repo->github_repo }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-slate-900 font-semibold">{{ $repo->commits_count ?? 0 }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            {{-- Recent Commits --}}
            @if ($recentCommits->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200">
                    <div class="border-b border-slate-200 p-6">
                        <h2 class="text-lg font-semibold text-slate-900">Recent Commits (Latest 20)</h2>
                    </div>
                    <div class="divide-y divide-slate-200">
                        @foreach ($recentCommits as $commit)
                            <div class="p-6 hover:bg-slate-50 transition">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-2 py-1 text-xs text-slate-700">
                                                <i class="fab fa-github"></i> {{ $commit->repository->github_repo }}
                                            </span>
                                        </div>
                                        <p class="text-sm font-semibold text-slate-900">{{ $commit->message }}</p>
                                        <p class="mt-1 text-xs text-slate-500">by {{ $commit->author_name }} • {{ $commit->committed_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200">
                    <div class="p-6 text-center">
                        <i class="fas fa-code-branch text-4xl text-slate-300 mb-4 block"></i>
                        <p class="text-slate-600">No commits yet.</p>
                        <p class="mt-1 text-sm text-slate-500">Commits will appear here once repositories are connected and synchronized.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
