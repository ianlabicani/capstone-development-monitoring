<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-6xl sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight text-slate-900">{{ $repository->full_name }}</h1>
                    <p class="mt-2 text-sm text-slate-600">{{ $repository->description ?? 'No description' }}</p>
                </div>
                <div class="flex gap-2">
                    <form action="{{ route('team-leader.repositories.sync', $repository) }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-orange-600 px-6 py-3 text-sm font-semibold text-white hover:bg-orange-700">
                            <i class="fas fa-sync mr-2"></i> Sync Commits
                        </button>
                    </form>
                    <a href="{{ route('team-leader.repositories.index') }}" class="inline-flex items-center justify-center rounded-lg border border-slate-300 px-6 py-3 text-sm font-semibold text-slate-900 hover:bg-slate-50">
                        <i class="fas fa-arrow-left mr-2"></i> Back
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

            @if ($errors->has('sync'))
                <div class="mb-6 rounded-2xl bg-red-50 p-4 ring-1 ring-red-200">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-exclamation-circle text-lg text-red-600"></i>
                        <div>
                            <h3 class="font-semibold text-red-900">Sync Error</h3>
                            <p class="mt-1 text-sm text-red-700">{{ $errors->first('sync') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="space-y-6">
                {{-- Repository Info --}}
                <div class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200">
                    <div class="border-b border-slate-200 p-6">
                        <h2 class="text-lg font-semibold text-slate-900">Repository Details</h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                            <div>
                                <p class="text-sm font-semibold text-slate-600">Owner</p>
                                <p class="mt-1 text-slate-900">{{ $repository->github_owner }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-600">Repository</p>
                                <p class="mt-1 text-slate-900">{{ $repository->github_repo }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-600">Default Branch</p>
                                <p class="mt-1 text-slate-900"><i class="fas fa-code-branch mr-1 text-slate-400"></i> {{ $repository->default_branch }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-600">Last Synced</p>
                                <p class="mt-1 text-slate-900">{{ $repository->last_synced_at ? $repository->last_synced_at->diffForHumans() : 'Never' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Stats --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-white rounded-2xl ring-1 ring-slate-200 p-6 text-center">
                        <p class="text-3xl font-bold text-orange-600">{{ $repository->commits->count() }}</p>
                        <p class="mt-1 text-sm text-slate-600">Total Commits</p>
                    </div>
                    <div class="bg-white rounded-2xl ring-1 ring-slate-200 p-6 text-center">
                        <p class="text-3xl font-bold text-orange-600">{{ $repository->commits->where('committed_at', '>=', now()->subWeek())->count() }}</p>
                        <p class="mt-1 text-sm text-slate-600">This Week</p>
                    </div>
                    <div class="bg-white rounded-2xl ring-1 ring-slate-200 p-6 text-center">
                        <p class="text-3xl font-bold text-orange-600">{{ $repository->commits->unique('author_email')->count() }}</p>
                        <p class="mt-1 text-sm text-slate-600">Contributors</p>
                    </div>
                    <div class="bg-white rounded-2xl ring-1 ring-slate-200 p-6 text-center">
                        <p class="text-3xl font-bold text-orange-600">{{ $repository->commits->max('committed_at')?->diffForHumans() ?? 'N/A' }}</p>
                        <p class="mt-1 text-sm text-slate-600">Last Commit</p>
                    </div>
                </div>

                {{-- Commits Table --}}
                <div class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200">
                    <div class="border-b border-slate-200 p-6 flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-slate-900">Commits</h2>
                        <span class="text-sm text-slate-500">{{ $repository->commits->count() }} total</span>
                    </div>
                    @if ($repository->commits->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="border-b border-slate-200 bg-slate-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900">Message</th>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900">Author</th>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900">Date</th>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900">SHA</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200">
                                    @foreach ($repository->commits as $commit)
                                        <tr class="hover:bg-slate-50 transition">
                                            <td class="px-6 py-4 text-sm text-slate-900 max-w-md truncate">{{ Str::limit($commit->message, 80) }}</td>
                                            <td class="px-6 py-4 text-sm text-slate-600">
                                                @if ($commit->author_login)
                                                    <span class="text-slate-900">{{ $commit->author_login }}</span>
                                                @else
                                                    {{ $commit->author_name }}
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-sm text-slate-500">{{ $commit->committed_at->format('M d, Y H:i') }}</td>
                                            <td class="px-6 py-4 text-sm">
                                                <a href="{{ $commit->url }}" target="_blank" rel="noopener noreferrer" class="font-mono text-orange-600 hover:text-orange-700">
                                                    {{ substr($commit->sha, 0, 7) }}
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="p-6 text-center">
                            <i class="fas fa-code-commit text-4xl text-slate-300 mb-4 block"></i>
                            <p class="text-slate-600">No commits synced yet.</p>
                            <p class="mt-1 text-sm text-slate-500">Click "Sync Commits" to fetch commit data from GitHub.</p>
                        </div>
                    @endif
                </div>

                {{-- Danger Zone --}}
                <div class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-red-200">
                    <div class="border-b border-red-200 p-6">
                        <h2 class="text-lg font-semibold text-red-900">Danger Zone</h2>
                    </div>
                    <div class="p-6 flex items-center justify-between">
                        <div>
                            <p class="font-semibold text-slate-900">Remove this repository</p>
                            <p class="text-sm text-slate-600">This will permanently delete all synced commits for this repository.</p>
                        </div>
                        <button
                            type="button"
                            @click="$dispatch('open-modal', 'delete-repo')"
                            class="inline-flex items-center rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700"
                        >
                            <i class="fas fa-trash-alt mr-2"></i> Remove
                        </button>
                        <form id="delete-repo-form" action="{{ route('team-leader.repositories.destroy', $repository) }}" method="POST" class="hidden"
                              @confirm-action.window="$event.detail === 'delete-repo' && this.submit()"
                        >
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-confirm-modal
        name="delete-repo"
        title="Remove Repository"
        message="Are you sure you want to remove this repository? All synced commits will be permanently deleted. This action cannot be undone."
        confirmText="Remove"
        confirmClass="bg-red-600 hover:bg-red-700"
    />
</x-app-layout>
