<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-2xl sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="mb-6">
                <h1 class="text-3xl font-bold tracking-tight text-slate-900">Create Your Team</h1>
                <p class="mt-2 text-sm text-slate-600">Set up your capstone team to start tracking development progress</p>
            </div>

            {{-- Form --}}
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200">
                <div class="p-6">
                    <form action="{{ route('team-leader.team.store') }}" method="POST" class="space-y-6" x-data="{ loading: false }" @submit="loading = true">
                        @csrf

                        {{-- Name Field --}}
                        <div>
                            <label for="name" class="block text-sm font-semibold text-slate-900 mb-2">Team Name</label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                class="w-full rounded-lg border border-slate-300 px-4 py-2 text-slate-900 placeholder-slate-400 focus:border-orange-500 focus:outline-none focus:ring-1 focus:ring-orange-500"
                                placeholder="Team Alpha"
                                required
                            />
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Description Field --}}
                        <div>
                            <label for="description" class="block text-sm font-semibold text-slate-900 mb-2">Description <span class="text-slate-400 font-normal">(optional)</span></label>
                            <textarea
                                id="description"
                                name="description"
                                rows="3"
                                class="w-full rounded-lg border border-slate-300 px-4 py-2 text-slate-900 placeholder-slate-400 focus:border-orange-500 focus:outline-none focus:ring-1 focus:ring-orange-500"
                                placeholder="Briefly describe your capstone project"
                            >{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Info Box --}}
                        <div class="rounded-lg bg-blue-50 p-4 ring-1 ring-blue-200">
                            <div class="flex gap-3">
                                <i class="fas fa-info-circle text-lg text-blue-600 mt-0.5"></i>
                                <div>
                                    <p class="text-sm font-semibold text-blue-900">What happens next?</p>
                                    <p class="mt-1 text-sm text-blue-700">After creating your team, you can connect GitHub repositories to start tracking commits and development activity.</p>
                                </div>
                            </div>
                        </div>

                        {{-- Button --}}
                        <div class="pt-4">
                            <button
                                type="submit"
                                :disabled="loading"
                                class="w-full inline-flex items-center justify-center rounded-lg bg-orange-600 px-6 py-2 text-sm font-semibold text-white hover:bg-orange-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-300 disabled:opacity-75 disabled:cursor-not-allowed"
                            >
                                <svg x-show="loading" class="animate-spin -ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 5 2.686 5 12h4z"></path>
                                </svg>
                                <span x-text="loading ? 'Creating...' : 'Create Team'"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
