<x-guest-layout>
    <div class="py-12">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl sm:text-4xl font-bold text-slate-900">Top Contributors</h1>
                <p class="mt-2 text-slate-600">Meet the most active developers across all capstone teams. Ranked by {{ $period === 'week' ? 'weekly' : ($period === 'month' ? 'monthly' : 'all-time') }} commits.</p>
            </div>

            <!-- Period Tabs -->
            <div class="mb-8 flex gap-2">
                <a href="{{ route('leaderboard.contributors', ['period' => 'week']) }}"
                   class="px-4 py-2 rounded-lg text-sm font-medium transition {{ $period === 'week' ? 'bg-orange-600 text-white' : 'bg-slate-200 text-slate-700 hover:bg-slate-300' }}">
                    This Week
                </a>
                <a href="{{ route('leaderboard.contributors', ['period' => 'month']) }}"
                   class="px-4 py-2 rounded-lg text-sm font-medium transition {{ $period === 'month' ? 'bg-orange-600 text-white' : 'bg-slate-200 text-slate-700 hover:bg-slate-300' }}">
                    This Month
                </a>
                <a href="{{ route('leaderboard.contributors', ['period' => 'all']) }}"
                   class="px-4 py-2 rounded-lg text-sm font-medium transition {{ $period === 'all' ? 'bg-orange-600 text-white' : 'bg-slate-200 text-slate-700 hover:bg-slate-300' }}">
                    All Time
                </a>
            </div>

            <!-- Contributors Grid -->
            @if ($contributors->count())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($contributors as $rank => $contributor)
                        <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 p-6 hover:shadow-md transition text-center">
                            <!-- Rank & Avatar -->
                            <div class="flex justify-center mb-4">
                                <div class="relative">
                                    <img src="https://github.com/{{ $contributor->author_login }}.png?size=80"
                                         alt="{{ $contributor->author_name }}"
                                         class="w-16 h-16 rounded-full border-4 border-orange-100">
                                    <div class="absolute -top-2 -right-2 w-8 h-8 bg-orange-600 text-white rounded-full flex items-center justify-center text-sm font-bold">
                                        #{{ $rank + 1 }}
                                    </div>
                                </div>
                            </div>

                            <!-- Info -->
                            <h3 class="text-lg font-semibold text-slate-900">{{ $contributor->author_name }}</h3>
                            <p class="text-sm text-slate-500 mb-4">@{{ $contributor->author_login }}</p>

                            <!-- Stats -->
                            <div class="space-y-2 mb-6">
                                <div class="flex items-center justify-center gap-2">
                                    <i class="fas fa-code text-orange-600"></i>
                                    <span class="text-2xl font-bold text-slate-900">{{ $contributor->commit_count }}</span>
                                    <span class="text-sm text-slate-500">commits</span>
                                </div>

                                @if ($contributor->streak > 0)
                                    <div class="flex items-center justify-center gap-2">
                                        <i class="fas fa-fire text-orange-500"></i>
                                        <span class="font-semibold text-slate-900">{{ $contributor->streak }}-day streak</span>
                                    </div>
                                @endif
                            </div>

                            <!-- GitHub Link -->
                            <a href="https://github.com/{{ $contributor->author_login }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 text-slate-700 rounded-lg text-sm font-medium hover:bg-slate-200 transition">
                                <i class="fab fa-github"></i>
                                View Profile
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 bg-slate-50 rounded-2xl ring-1 ring-slate-200">
                    <i class="fas fa-inbox text-4xl text-slate-300 mb-4"></i>
                    <p class="text-slate-600">No contributors found for the selected period.</p>
                </div>
            @endif
        </div>
    </div>
</x-guest-layout>
