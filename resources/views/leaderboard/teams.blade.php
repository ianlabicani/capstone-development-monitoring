<x-guest-layout>
    <div class="py-12">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl sm:text-4xl font-bold text-slate-900">Team Leaderboard</h1>
                <p class="mt-2 text-slate-600">See which capstone teams are most active. Ranked by {{ $period === 'week' ? 'weekly' : ($period === 'month' ? 'monthly' : 'all-time') }} commits.</p>
            </div>

            <!-- Filters -->
            <div class="mb-8 flex flex-col sm:flex-row gap-4">
                <!-- Period Tabs -->
                <div class="flex gap-2">
                    <a href="{{ route('leaderboard.teams', ['period' => 'week', 'adviser' => $adviserId]) }}"
                       class="px-4 py-2 rounded-lg text-sm font-medium transition {{ $period === 'week' ? 'bg-orange-600 text-white' : 'bg-slate-200 text-slate-700 hover:bg-slate-300' }}">
                        This Week
                    </a>
                    <a href="{{ route('leaderboard.teams', ['period' => 'month', 'adviser' => $adviserId]) }}"
                       class="px-4 py-2 rounded-lg text-sm font-medium transition {{ $period === 'month' ? 'bg-orange-600 text-white' : 'bg-slate-200 text-slate-700 hover:bg-slate-300' }}">
                        This Month
                    </a>
                    <a href="{{ route('leaderboard.teams', ['period' => 'all', 'adviser' => $adviserId]) }}"
                       class="px-4 py-2 rounded-lg text-sm font-medium transition {{ $period === 'all' ? 'bg-orange-600 text-white' : 'bg-slate-200 text-slate-700 hover:bg-slate-300' }}">
                        All Time
                    </a>
                </div>

                <!-- Adviser Filter -->
                <div class="flex-1">
                    <select onchange="window.location.href = '{{ route('leaderboard.teams') }}?period={{ $period }}&adviser=' + this.value"
                            class="w-full px-4 py-2 rounded-lg border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                        <option value="">All Advisers</option>
                        @forelse ($advisers as $adviser)
                            <option value="{{ $adviser->id }}" {{ $adviserId == $adviser->id ? 'selected' : '' }}>
                                {{ $adviser->name ?? 'Unknown Adviser' }}
                            </option>
                        @empty
                        @endforelse
                    </select>
                </div>
            </div>

            <!-- Teams Grid -->
            @if ($teams->count())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($teams as $rank => $team)
                        <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 p-6 hover:shadow-md transition">
                            <!-- Rank Badge -->
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center flex-shrink-0">
                                        <span class="text-lg font-bold text-orange-600">#{{ $rank + 1 }}</span>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-slate-900">{{ $team->name }}</h3>
                                        <p class="text-xs text-slate-500">By {{ $team->owner ? $team->owner->name : 'Unknown' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Stats -->
                            <div class="space-y-3 mb-6">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-slate-600">
                                        <i class="fas fa-code text-orange-600 mr-2"></i>
                                        {{ $period === 'week' ? 'This Week' : ($period === 'month' ? 'This Month' : 'All Time') }}
                                    </span>
                                    <span class="text-xl font-bold text-orange-600">{{ match ($period) {
                                        'month' => $team->this_month_commits,
                                        'week' => $team->this_week_commits,
                                        default => $team->all_time_commits,
                                    } }}</span>
                                </div>

                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-slate-600">
                                        <i class="fas fa-code text-slate-400 mr-2"></i>
                                        Total Commits
                                    </span>
                                    <span class="font-semibold text-slate-900">{{ $team->all_time_commits }}</span>
                                </div>

                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-slate-600">
                                        <i class="fas fa-users text-slate-400 mr-2"></i>
                                        Contributors
                                    </span>
                                    <span class="font-semibold text-slate-900">{{ $team->contributors_count }}</span>
                                </div>

                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-slate-600">
                                        <i class="fas fa-folder text-slate-400 mr-2"></i>
                                        Repositories
                                    </span>
                                    <span class="font-semibold text-slate-900">{{ $team->repositories_count }}</span>
                                </div>
                            </div>

                            <!-- CTA -->
                            <a href="{{ route('projects.show', $team->slug) }}"
                               class="block w-full text-center px-4 py-2 bg-orange-600 text-white rounded-lg font-medium hover:bg-orange-700 transition">
                                View Project
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 bg-slate-50 rounded-2xl ring-1 ring-slate-200">
                    <i class="fas fa-inbox text-4xl text-slate-300 mb-4"></i>
                    <p class="text-slate-600">No teams found for the selected filters.</p>
                </div>
            @endif
        </div>
    </div>
</x-guest-layout>
