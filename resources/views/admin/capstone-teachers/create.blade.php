<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-2xl sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="mb-6">
                <h1 class="text-3xl font-bold tracking-tight text-slate-900">Add Capstone Teacher</h1>
                <p class="mt-2 text-sm text-slate-600">Create a new capstone teacher account</p>
            </div>

            {{-- Form --}}
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200">
                <div class="p-6">
                    <form action="{{ route('admin.capstone-teachers.store') }}" method="POST" class="space-y-6" x-data="{ loading: false }" @submit="loading = true">
                        @csrf

                        {{-- Name Field --}}
                        <div>
                            <label for="name" class="block text-sm font-semibold text-slate-900 mb-2">Name</label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                class="w-full rounded-lg border border-slate-300 px-4 py-2 text-slate-900 placeholder-slate-400 focus:border-orange-500 focus:outline-none focus:ring-1 focus:ring-orange-500"
                                placeholder="Jane Doe"
                                required
                            />
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email Field --}}
                        <div>
                            <label for="email" class="block text-sm font-semibold text-slate-900 mb-2">Email</label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="w-full rounded-lg border border-slate-300 px-4 py-2 text-slate-900 placeholder-slate-400 focus:border-orange-500 focus:outline-none focus:ring-1 focus:ring-orange-500"
                                placeholder="jane@example.com"
                                required
                            />
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Info Box --}}
                        <div class="rounded-lg bg-blue-50 p-4 ring-1 ring-blue-200">
                            <div class="flex gap-3">
                                <i class="fas fa-info-circle text-lg text-blue-600 mt-0.5"></i>
                                <div>
                                    <p class="text-sm font-semibold text-blue-900">Automatic Password Generation</p>
                                    <p class="mt-1 text-sm text-blue-700">A 12-character random password will be generated for this account. The password will be shown after creation.</p>
                                </div>
                            </div>
                        </div>

                        {{-- Buttons --}}
                        <div class="flex gap-3 pt-4">
                            <button
                                type="submit"
                                :disabled="loading"
                                class="flex-1 inline-flex items-center justify-center rounded-lg bg-orange-600 px-6 py-2 text-sm font-semibold text-white hover:bg-orange-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-300 disabled:opacity-75 disabled:cursor-not-allowed"
                            >
                                <svg x-show="loading" class="animate-spin -ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 5 2.686 5 12h4z"></path>
                                </svg>
                                <span x-text="loading ? 'Creating...' : 'Create Capstone Teacher'"></span>
                            </button>
                            <a
                                href="{{ route('admin.capstone-teachers.index') }}"
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
