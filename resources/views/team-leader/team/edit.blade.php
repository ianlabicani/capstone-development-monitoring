<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-2xl sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="mb-6">
                <h1 class="text-3xl font-bold tracking-tight text-slate-900">Edit Team</h1>
                <p class="mt-2 text-sm text-slate-600">Update your team information</p>
            </div>

            {{-- Form --}}
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200">
                <div class="p-6">
                    <form action="{{ route('team-leader.team.update') }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        {{-- Name Field --}}
                        <div>
                            <label for="name" class="block text-sm font-semibold text-slate-900 mb-2">Team Name</label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name', $team->name) }}"
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
                            >{{ old('description', $team->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Buttons --}}
                        <div class="flex gap-3 pt-4">
                            <button
                                type="submit"
                                class="flex-1 rounded-lg bg-orange-600 px-6 py-2 text-sm font-semibold text-white hover:bg-orange-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-300"
                            >
                                Save Changes
                            </button>
                            <a
                                href="{{ route('team-leader.team.show') }}"
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
</x-app-layout>
