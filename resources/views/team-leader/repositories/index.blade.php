<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-6xl sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight text-slate-900">Repositories</h1>
                    <p class="mt-2 text-sm text-slate-600">Manage GitHub repositories for {{ $team->name }}</p>
                </div>
                <a href="{{ route('team-leader.repositories.create') }}" class="inline-flex items-center justify-center rounded-lg bg-orange-600 px-6 py-3 text-sm font-semibold text-white hover:bg-orange-700">
                    <i class="fas fa-plus mr-2"></i> Connect Repository
                </a>
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

            {{-- Repository List --}}
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200">
                @if ($repositories->count() > 0)
                    <div class="divide-y divide-slate-200">
                        @foreach ($repositories as $repository)
                            <div class="p-6 hover:bg-slate-50 transition">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-4">
                                        <i class="fab fa-github text-2xl text-slate-700"></i>
                                        <div>
                                            <a href="{{ route('team-leader.repositories.show', $repository) }}" class="font-semibold text-slate-900 hover:text-orange-600">
                                                {{ $repository->full_name }}
                                            </a>
                                            <p class="text-sm text-slate-500">{{ $repository->description ?? 'No description' }}</p>
                                            <div class="mt-1 flex items-center gap-4 text-xs text-slate-400">
                                                <span><i class="fas fa-code-branch mr-1"></i> {{ $repository->default_branch }}</span>
                                                <span><i class="fas fa-code-commit mr-1"></i> {{ $repository->commits_count ?? 0 }} commits</span>
                                                @if ($repository->last_synced_at)
                                                    <span><i class="fas fa-sync mr-1"></i> Synced {{ $repository->last_synced_at->diffForHumans() }}</span>
                                                @else
                                                    <span class="text-amber-500"><i class="fas fa-exclamation-circle mr-1"></i> Not synced yet</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <form action="{{ route('team-leader.repositories.sync', $repository) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center rounded-lg border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                                                <i class="fas fa-sync mr-2"></i> Sync
                                            </button>
                                        </form>
                                        <a href="{{ route('team-leader.repositories.show', $repository) }}" class="inline-flex items-center rounded-lg border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                                            <i class="fas fa-eye mr-2"></i> View
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-6 text-center">
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
</x-app-layout>
