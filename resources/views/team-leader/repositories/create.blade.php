<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-2xl sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="mb-6">
                <h1 class="text-3xl font-bold tracking-tight text-slate-900">Connect Repository</h1>
                <p class="mt-2 text-sm text-slate-600">Link a GitHub repository to {{ $team->name }}</p>
            </div>

            {{-- Form --}}
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200">
                <div class="p-6">
                    <form action="{{ route('team-leader.repositories.store') }}" method="POST" class="space-y-6">
                        @csrf

                        {{-- Owner Field --}}
                        <div>
                            <label for="github_owner" class="block text-sm font-semibold text-slate-900 mb-2">Repository Owner</label>
                            <input
                                type="text"
                                id="github_owner"
                                name="github_owner"
                                value="{{ old('github_owner') }}"
                                class="w-full rounded-lg border border-slate-300 px-4 py-2 text-slate-900 placeholder-slate-400 focus:border-orange-500 focus:outline-none focus:ring-1 focus:ring-orange-500"
                                placeholder="e.g. octocat"
                                required
                            />
                            @error('github_owner')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Repo Field --}}
                        <div>
                            <label for="github_repo" class="block text-sm font-semibold text-slate-900 mb-2">Repository Name</label>
                            <input
                                type="text"
                                id="github_repo"
                                name="github_repo"
                                value="{{ old('github_repo') }}"
                                class="w-full rounded-lg border border-slate-300 px-4 py-2 text-slate-900 placeholder-slate-400 focus:border-orange-500 focus:outline-none focus:ring-1 focus:ring-orange-500"
                                placeholder="e.g. hello-world"
                                required
                            />
                            @error('github_repo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Preview --}}
                        <div class="rounded-lg bg-slate-50 p-4 ring-1 ring-slate-200">
                            <div class="flex items-center gap-3">
                                <i class="fab fa-github text-xl text-slate-700"></i>
                                <div>
                                    <p class="text-sm font-semibold text-slate-900">Repository URL</p>
                                    <p class="mt-1 text-sm text-slate-600">github.com/<span id="preview-owner" class="text-orange-600">owner</span>/<span id="preview-repo" class="text-orange-600">repo</span></p>
                                </div>
                            </div>
                        </div>

                        {{-- Info Box --}}
                        <div class="rounded-lg bg-blue-50 p-4 ring-1 ring-blue-200">
                            <div class="flex gap-3">
                                <i class="fas fa-info-circle text-lg text-blue-600 mt-0.5"></i>
                                <div>
                                    <p class="text-sm font-semibold text-blue-900">How it works</p>
                                    <p class="mt-1 text-sm text-blue-700">We'll validate the repository exists on GitHub and fetch its metadata. After connecting, you can sync commits manually.</p>
                                </div>
                            </div>
                        </div>

                        {{-- Buttons --}}
                        <div class="flex gap-3 pt-4">
                            <button
                                type="submit"
                                class="flex-1 rounded-lg bg-orange-600 px-6 py-2 text-sm font-semibold text-white hover:bg-orange-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-300"
                            >
                                Connect Repository
                            </button>
                            <a
                                href="{{ route('team-leader.repositories.index') }}"
                                class="flex-1 rounded-lg border border-slate-300 px-6 py-2 text-sm font-semibold text-slate-900 hover:bg-slate-50 text-center"
                            >
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('github_owner').addEventListener('input', function() {
            document.getElementById('preview-owner').textContent = this.value || 'owner';
        });
        document.getElementById('github_repo').addEventListener('input', function() {
            document.getElementById('preview-repo').textContent = this.value || 'repo';
        });
    </script>
</x-app-layout>
