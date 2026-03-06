<x-guest-layout>
    {{-- Hero Section --}}
    <section class="relative overflow-hidden bg-slate-900">
        <div class="absolute inset-0 bg-gradient-to-br from-orange-600/20 to-slate-900/80"></div>
        <div class="relative z-10 mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 py-20 sm:py-28">
            <div class="text-center">
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold tracking-tight text-white">Monitor Your Capstone Team's Development Progress</h1>
                <p class="mt-4 text-base sm:text-lg text-slate-300 max-w-2xl mx-auto">Track commits, branches, pull requests, and contributor activity — all in one place. Stay accountable, stay visible, stay on track.</p>
                <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-center">
                    @auth
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center rounded-lg bg-orange-600 px-6 py-3 text-sm font-semibold text-white hover:bg-orange-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-300">Go to Dashboard</a>
                    @else
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-lg bg-orange-600 px-6 py-3 text-sm font-semibold text-white hover:bg-orange-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-300">Get Started</a>
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-lg bg-white/10 px-6 py-3 text-sm font-semibold text-white hover:bg-white/20 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white backdrop-blur">Log In</a>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    {{-- Metrics Tracked --}}
    <section class="py-12 sm:py-16 bg-white">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900 text-center mb-12">What We Track</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 p-6 text-center hover:shadow-md transition">
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-orange-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75 22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3-4.5 16.5" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900">Commits</h3>
                    <p class="text-sm text-slate-500 mt-1">Total & weekly commit activity</p>
                </div>
                <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 p-6 text-center hover:shadow-md transition">
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-orange-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186 9.566-5.314m-9.566 7.5 9.566 5.314m0 0a2.25 2.25 0 1 0 3.935 2.186 2.25 2.25 0 0 0-3.935-2.186Zm0-12.814a2.25 2.25 0 1 0 3.933-2.185 2.25 2.25 0 0 0-3.933 2.185Z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900">Branches</h3>
                    <p class="text-sm text-slate-500 mt-1">Branch creation & management</p>
                </div>
                <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 p-6 text-center hover:shadow-md transition">
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-orange-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21 3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900">Pull Requests</h3>
                    <p class="text-sm text-slate-500 mt-1">PRs opened & merged</p>
                </div>
                <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 p-6 text-center hover:shadow-md transition">
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-orange-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900">Contributors</h3>
                    <p class="text-sm text-slate-500 mt-1">Individual participation tracking</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Role-Based Dashboards --}}
    <section class="py-12 sm:py-16 bg-slate-50">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900 text-center mb-4">Dashboards for Every Role</h2>
            <p class="text-slate-600 text-center max-w-2xl mx-auto mb-12">Whether you're a student, adviser, or instructor — see the data that matters most to you.</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Capstone Team --}}
                <div class="bg-orange-50 rounded-2xl p-8">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 bg-orange-600 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900">Capstone Teams</h3>
                    </div>
                    <p class="text-slate-600 mb-6">Register your GitHub repository and let your development activity speak for itself. Commits, branches, and PRs are tracked automatically.</p>
                    <div class="space-y-3">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-orange-600 mt-0.5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                            <span class="text-sm text-slate-700">Connect your GitHub repository</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-orange-600 mt-0.5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                            <span class="text-sm text-slate-700">Automatic commit & PR tracking</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-orange-600 mt-0.5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                            <span class="text-sm text-slate-700">View your team's progress dashboard</span>
                        </div>
                    </div>
                </div>

                {{-- Advisers & Teachers --}}
                <div class="bg-emerald-50 rounded-2xl p-8">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 bg-emerald-600 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900">Advisers & Teachers</h3>
                    </div>
                    <p class="text-slate-600 mb-6">Monitor multiple capstone teams at a glance. Identify inactive teams early and track development frequency across all your students.</p>
                    <div class="space-y-3">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-emerald-600 mt-0.5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                            <span class="text-sm text-slate-700">Multi-team overview dashboard</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-emerald-600 mt-0.5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                            <span class="text-sm text-slate-700">Commits per week & contributor stats</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-emerald-600 mt-0.5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                            <span class="text-sm text-slate-700">Detect struggling or inactive teams</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Why Use This Platform --}}
    <section class="py-12 sm:py-16 bg-white">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900 text-center mb-12">Why Use Capstone Monitor</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-14 h-14 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-orange-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-slate-900">Automated Tracking</h3>
                    <p class="text-slate-600">No more manual progress reports. GitHub activity is synced automatically.</p>
                </div>
                <div class="text-center">
                    <div class="w-14 h-14 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-orange-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-slate-900">Full Transparency</h3>
                    <p class="text-slate-600">Every contribution is visible. Encourages accountability across the team.</p>
                </div>
                <div class="text-center">
                    <div class="w-14 h-14 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-orange-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-slate-900">Early Warning</h3>
                    <p class="text-slate-600">Spot inactive teams before deadlines hit. Advisers get alerts on stalled progress.</p>
                </div>
                <div class="text-center">
                    <div class="w-14 h-14 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-orange-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0 1 12 21 8.25 8.25 0 0 1 6.038 7.047 8.287 8.287 0 0 0 9 9.601a8.983 8.983 0 0 1 3.361-6.867 8.21 8.21 0 0 0 3 2.48Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 18a3.75 3.75 0 0 0 .495-7.468 5.99 5.99 0 0 0-1.925 3.547 5.975 5.975 0 0 1-2.133-1.001A3.75 3.75 0 0 0 12 18Z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-slate-900">Commit Streaks</h3>
                    <p class="text-slate-600">Gamify development. Track streaks and motivate consistent coding habits.</p>
                </div>
                <div class="text-center">
                    <div class="w-14 h-14 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-orange-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 0 1-.982-3.172M9.497 14.25a7.454 7.454 0 0 0 .981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 0 0 7.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M18.75 4.236c.982.143 1.954.317 2.916.52A6.003 6.003 0 0 0 16.27 9.728M18.75 4.236V4.5c0 2.108-.966 3.99-2.48 5.228m0 0a6.04 6.04 0 0 1-2.021 1.604 6.018 6.018 0 0 1-5.539 0 6.04 6.04 0 0 1-2.021-1.604" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-slate-900">Public Leaderboard</h3>
                    <p class="text-slate-600">Encourage healthy competition with public activity rankings and showcases.</p>
                </div>
                <div class="text-center">
                    <div class="w-14 h-14 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-orange-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-slate-900">Git Best Practices</h3>
                    <p class="text-slate-600">Encourages proper branching, pull requests, and collaborative workflows.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- How It Works --}}
    <section class="py-12 sm:py-16 bg-slate-50">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900 text-center mb-12">How It Works</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="w-14 h-14 bg-orange-600 text-white rounded-full flex items-center justify-center mx-auto mb-4 text-xl font-bold">1</div>
                    <h3 class="text-lg font-semibold text-slate-900 mb-2">Register Your Team</h3>
                    <p class="text-sm text-slate-600">Sign up and create your capstone team on the platform.</p>
                </div>
                <div class="text-center">
                    <div class="w-14 h-14 bg-orange-600 text-white rounded-full flex items-center justify-center mx-auto mb-4 text-xl font-bold">2</div>
                    <h3 class="text-lg font-semibold text-slate-900 mb-2">Connect GitHub</h3>
                    <p class="text-sm text-slate-600">Link your GitHub repository via OAuth for automatic syncing.</p>
                </div>
                <div class="text-center">
                    <div class="w-14 h-14 bg-orange-600 text-white rounded-full flex items-center justify-center mx-auto mb-4 text-xl font-bold">3</div>
                    <h3 class="text-lg font-semibold text-slate-900 mb-2">Auto-Sync Activity</h3>
                    <p class="text-sm text-slate-600">Commits, branches, PRs, and contributors are fetched periodically.</p>
                </div>
                <div class="text-center">
                    <div class="w-14 h-14 bg-orange-600 text-white rounded-full flex items-center justify-center mx-auto mb-4 text-xl font-bold">4</div>
                    <h3 class="text-lg font-semibold text-slate-900 mb-2">View Dashboards</h3>
                    <p class="text-sm text-slate-600">Advisers, teachers, and teams see tailored progress dashboards.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Public Engagement Features --}}
    <section class="py-12 sm:py-16 bg-orange-600 text-white">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-2xl sm:text-3xl font-bold mb-4">Public Activity & Recognition</h2>
                <p class="text-lg text-orange-100 max-w-3xl mx-auto">Showcase your team's hard work. Public dashboards encourage engagement, competition, and community inspiration.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white/10 backdrop-blur rounded-2xl p-8 text-center">
                    <svg class="w-10 h-10 text-white mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 0 1-.982-3.172M9.497 14.25a7.454 7.454 0 0 0 .981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 0 0 7.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M18.75 4.236c.982.143 1.954.317 2.916.52A6.003 6.003 0 0 0 16.27 9.728M18.75 4.236V4.5c0 2.108-.966 3.99-2.48 5.228m0 0a6.04 6.04 0 0 1-2.021 1.604 6.018 6.018 0 0 1-5.539 0 6.04 6.04 0 0 1-2.021-1.604" />
                    </svg>
                    <h3 class="text-xl font-semibold mb-2">Team Leaderboard</h3>
                    <p class="text-orange-100">See which teams are most active with ranked commit and PR activity.</p>
                </div>
                <div class="bg-white/10 backdrop-blur rounded-2xl p-8 text-center">
                    <svg class="w-10 h-10 text-white mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0 1 12 21 8.25 8.25 0 0 1 6.038 7.047 8.287 8.287 0 0 0 9 9.601a8.983 8.983 0 0 1 3.361-6.867 8.21 8.21 0 0 0 3 2.48Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 18a3.75 3.75 0 0 0 .495-7.468 5.99 5.99 0 0 0-1.925 3.547 5.975 5.975 0 0 1-2.133-1.001A3.75 3.75 0 0 0 12 18Z" />
                    </svg>
                    <h3 class="text-xl font-semibold mb-2">Streak Tracking</h3>
                    <p class="text-orange-100">Track consecutive days of commits. Build momentum and coding habits.</p>
                </div>
                <div class="bg-white/10 backdrop-blur rounded-2xl p-8 text-center">
                    <svg class="w-10 h-10 text-white mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                    </svg>
                    <h3 class="text-xl font-semibold mb-2">Top Contributors</h3>
                    <p class="text-orange-100">Recognize the most active developers across all capstone teams.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="py-16 bg-slate-900 text-white">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-2xl sm:text-3xl font-bold tracking-tight mb-4">Ready to Monitor Your Capstone Progress?</h2>
            <p class="text-lg text-slate-300 mb-8 max-w-2xl mx-auto">Join the platform that keeps capstone teams accountable, advisers informed, and development visible.</p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                @auth
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center rounded-lg bg-orange-600 px-6 py-3 text-sm font-semibold text-white hover:bg-orange-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-300">Go to Dashboard</a>
                @else
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-lg bg-orange-600 px-6 py-3 text-sm font-semibold text-white hover:bg-orange-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-300">Register Your Team</a>
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-lg bg-white/10 px-6 py-3 text-sm font-semibold text-white hover:bg-white/20 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white backdrop-blur">Log In</a>
                @endauth
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-slate-900 border-t border-slate-800 py-8">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <svg class="h-6 w-6 text-orange-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75 22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3-4.5 16.5" />
                    </svg>
                    <span class="text-sm font-bold text-white">Capstone<span class="text-orange-600">Monitor</span></span>
                </div>
                <p class="text-sm text-slate-500">&copy; {{ date('Y') }} Capstone Development Monitoring System. All rights reserved.</p>
            </div>
        </div>
    </footer>
</x-guest-layout>