<x-guest-layout>
    <div class="bg-slate-50 min-h-screen">
        {{-- Header --}}
        <header class="bg-slate-900">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 py-12">
                <div class="flex items-center gap-2 mb-6">
                    <a href="/" class="flex items-center gap-2">
                        <i class="fas fa-code text-xl text-orange-600"></i>
                        <span class="text-xl font-bold text-white">Capstone<span class="text-orange-600">Monitor</span></span>
                    </a>
                </div>
                <h1 class="text-3xl sm:text-4xl font-bold tracking-tight text-white">{{ $team->name }}</h1>
                @if ($team->description)
                    <p class="mt-3 text-lg text-slate-300 max-w-3xl">{{ $team->description }}</p>
                @endif
            </div>
        </header>

        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 py-8">
            {{-- Stats Grid --}}
            <div class="mb-8 grid grid-cols-3 gap-4">
                <div class="bg-white rounded-2xl ring-1 ring-slate-200 p-6 text-center">
                    <p class="text-3xl font-bold text-orange-600">{{ $totalCommits }}</p>
                    <p class="mt-1 text-sm text-slate-600">Total Commits</p>
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
                {{-- AI Analysis (Coming Soon) --}}
                <div class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200">
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
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-6 text-center">
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
                            <p class="text-slate-600">No commits yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <footer class="bg-slate-900 border-t border-slate-800 py-8 mt-12">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-code text-xl text-orange-600"></i>
                        <span class="text-sm font-bold text-white">Capstone<span class="text-orange-600">Monitor</span></span>
                    </div>
                    <p class="text-sm text-slate-500">&copy; {{ date('Y') }} Capstone Development Monitoring System. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>
</x-guest-layout>
