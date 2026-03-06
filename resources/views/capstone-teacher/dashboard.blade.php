<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-6xl sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="mb-6">
                <h1 class="text-3xl font-bold tracking-tight text-slate-900">Dashboard</h1>
                <p class="mt-2 text-sm text-slate-600">Overview of capstone development activity.</p>
            </div>

            {{-- Summary Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200 p-6">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-orange-100">
                            <i class="fas fa-users text-xl text-orange-600"></i>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-slate-900">{{ $teamCount }}</p>
                            <p class="text-sm text-slate-500">Teams</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200 p-6">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-orange-100">
                            <i class="fab fa-github text-xl text-orange-600"></i>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-slate-900">{{ $repositoryCount }}</p>
                            <p class="text-sm text-slate-500">Repositories</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200 p-6">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-orange-100">
                            <i class="fas fa-code-commit text-xl text-orange-600"></i>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-slate-900">{{ $totalCommits }}</p>
                            <p class="text-sm text-slate-500">Total Commits</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200 p-6">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-emerald-100">
                            <i class="fas fa-chart-line text-xl text-emerald-600"></i>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-slate-900">{{ $weeklyCommits }}</p>
                            <p class="text-sm text-slate-500">This Week</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Links --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <a href="{{ route('capstone-teacher.teams.index') }}" class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200 p-6 hover:shadow-md transition block">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-orange-100">
                                <i class="fas fa-users text-xl text-orange-600"></i>
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-slate-900">Teams</h2>
                                <p class="text-sm text-slate-500">View all teams and their progress</p>
                            </div>
                        </div>
                        <i class="fas fa-chevron-right text-slate-400"></i>
                    </div>
                </a>
                <a href="{{ route('capstone-teacher.technical-advisers.index') }}" class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200 p-6 hover:shadow-md transition block">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-orange-100">
                                <i class="fas fa-chalkboard-user text-xl text-orange-600"></i>
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-slate-900">Technical Advisers</h2>
                                <p class="text-sm text-slate-500">Manage technical advisers</p>
                            </div>
                        </div>
                        <i class="fas fa-chevron-right text-slate-400"></i>
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
