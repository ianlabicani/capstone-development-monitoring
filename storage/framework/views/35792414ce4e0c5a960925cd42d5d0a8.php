<?php if (isset($component)) { $__componentOriginal69dc84650370d1d4dc1b42d016d7226b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b = $attributes; } ?>
<?php $component = App\View\Components\GuestLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('guest-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\GuestLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    
    <section class="relative overflow-hidden bg-slate-900">
        <div class="absolute inset-0 bg-gradient-to-br from-orange-600/20 to-slate-900/80"></div>
        <div class="relative z-10 mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 py-20 sm:py-28">
            <div class="text-center">
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold tracking-tight text-white">Monitor Your Capstone Team's Development Progress</h1>
                <p class="mt-4 text-base sm:text-lg text-slate-300 max-w-2xl mx-auto">Track commits, branches, pull requests, and contributor activity — all in one place. Stay accountable, stay visible, stay on track.</p>
                <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-center">
                    <?php if(auth()->guard()->check()): ?>
                        <a href="<?php echo e(route('dashboard')); ?>" class="inline-flex items-center justify-center rounded-lg bg-orange-600 px-6 py-3 text-sm font-semibold text-white hover:bg-orange-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-300">Go to Dashboard</a>
                    <?php else: ?>
                        <a href="<?php echo e(route('register')); ?>" class="inline-flex items-center justify-center rounded-lg bg-orange-600 px-6 py-3 text-sm font-semibold text-white hover:bg-orange-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-300">Get Started</a>
                        <a href="<?php echo e(route('login')); ?>" class="inline-flex items-center justify-center rounded-lg bg-white/10 px-6 py-3 text-sm font-semibold text-white hover:bg-white/20 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white backdrop-blur">Log In</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    
    <section class="py-12 sm:py-16 bg-white">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900 text-center mb-12">What We Track</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 p-6 text-center hover:shadow-md transition">
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-code text-xl text-orange-600"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900">Commits</h3>
                    <p class="text-sm text-slate-500 mt-1">Total & weekly commit activity</p>
                </div>
                <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 p-6 text-center hover:shadow-md transition">
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-code-branch text-xl text-orange-600"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900">Branches</h3>
                    <p class="text-sm text-slate-500 mt-1">Branch creation & management</p>
                </div>
                <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 p-6 text-center hover:shadow-md transition">
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-code-pull-request text-xl text-orange-600"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900">Pull Requests</h3>
                    <p class="text-sm text-slate-500 mt-1">PRs opened & merged</p>
                </div>
                <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 p-6 text-center hover:shadow-md transition">
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-users text-xl text-orange-600"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900">Contributors</h3>
                    <p class="text-sm text-slate-500 mt-1">Individual participation tracking</p>
                </div>
            </div>
        </div>
    </section>

    
    <section class="py-12 sm:py-16 bg-slate-50">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900 text-center mb-4">Dashboards for Every Role</h2>
            <p class="text-slate-600 text-center max-w-2xl mx-auto mb-12">Whether you're a student, adviser, or instructor — see the data that matters most to you.</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                <div class="bg-orange-50 rounded-2xl p-8">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 bg-orange-600 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-people-group text-lg text-white"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900">Capstone Teams</h3>
                    </div>
                    <p class="text-slate-600 mb-6">Register your GitHub repository and let your development activity speak for itself. Commits, branches, and PRs are tracked automatically.</p>
                    <div class="space-y-3">
                        <div class="flex items-start gap-3">
                            <i class="fas fa-check text-orange-600 mt-0.5 flex-shrink-0"></i>
                            <span class="text-sm text-slate-700">Connect your GitHub repository</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <i class="fas fa-check text-orange-600 mt-0.5 flex-shrink-0"></i>
                            <span class="text-sm text-slate-700">Automatic commit & PR tracking</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <i class="fas fa-check text-orange-600 mt-0.5 flex-shrink-0"></i>
                            <span class="text-sm text-slate-700">View your team's progress dashboard</span>
                        </div>
                    </div>
                </div>

                
                <div class="bg-emerald-50 rounded-2xl p-8">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 bg-emerald-600 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-chalkboard-user text-lg text-white"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900">Advisers & Teachers</h3>
                    </div>
                    <p class="text-slate-600 mb-6">Monitor multiple capstone teams at a glance. Identify inactive teams early and track development frequency across all your students.</p>
                    <div class="space-y-3">
                        <div class="flex items-start gap-3">
                            <i class="fas fa-check text-emerald-600 mt-0.5 flex-shrink-0"></i>
                            <span class="text-sm text-slate-700">Multi-team overview dashboard</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <i class="fas fa-check text-emerald-600 mt-0.5 flex-shrink-0"></i>
                            <span class="text-sm text-slate-700">Commits per week & contributor stats</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <i class="fas fa-check text-emerald-600 mt-0.5 flex-shrink-0"></i>
                            <span class="text-sm text-slate-700">Detect struggling or inactive teams</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
    <section class="py-12 sm:py-16 bg-white">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900 text-center mb-12">Why Use Capstone Monitor</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-14 h-14 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-chart-bar text-2xl text-orange-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-slate-900">Automated Tracking</h3>
                    <p class="text-slate-600">No more manual progress reports. GitHub activity is synced automatically.</p>
                </div>
                <div class="text-center">
                    <div class="w-14 h-14 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-eye text-2xl text-orange-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-slate-900">Full Transparency</h3>
                    <p class="text-slate-600">Every contribution is visible. Encourages accountability across the team.</p>
                </div>
                <div class="text-center">
                    <div class="w-14 h-14 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-hourglass-end text-2xl text-orange-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-slate-900">Early Warning</h3>
                    <p class="text-slate-600">Spot inactive teams before deadlines hit. Advisers get alerts on stalled progress.</p>
                </div>
                <div class="text-center">
                    <div class="w-14 h-14 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-fire text-2xl text-orange-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-slate-900">Commit Streaks</h3>
                    <p class="text-slate-600">Gamify development. Track streaks and motivate consistent coding habits.</p>
                </div>
                <div class="text-center">
                    <div class="w-14 h-14 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-trophy text-2xl text-orange-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-slate-900">Public Leaderboard</h3>
                    <p class="text-slate-600">Encourage healthy competition with public activity rankings and showcases.</p>
                </div>
                <div class="text-center">
                    <div class="w-14 h-14 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-circle-check text-2xl text-orange-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-slate-900">Git Best Practices</h3>
                    <p class="text-slate-600">Encourages proper branching, pull requests, and collaborative workflows.</p>
                </div>
            </div>
        </div>
    </section>

    
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

    
    <section class="py-12 sm:py-16 bg-orange-600 text-white">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-2xl sm:text-3xl font-bold mb-4">Public Activity & Recognition</h2>
                <p class="text-lg text-orange-100 max-w-3xl mx-auto">Showcase your team's hard work. Public dashboards encourage engagement, competition, and community inspiration.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white/10 backdrop-blur rounded-2xl p-8 text-center">
                    <i class="fas fa-ranking-star text-3xl text-white mx-auto mb-4"></i>
                    <h3 class="text-xl font-semibold mb-2">Team Leaderboard</h3>
                    <p class="text-orange-100">See which teams are most active with ranked commit and PR activity.</p>
                </div>
                <div class="bg-white/10 backdrop-blur rounded-2xl p-8 text-center">
                    <i class="fas fa-fire text-3xl text-white mx-auto mb-4"></i>
                    <h3 class="text-xl font-semibold mb-2">Streak Tracking</h3>
                    <p class="text-orange-100">Track consecutive days of commits. Build momentum and coding habits.</p>
                </div>
                <div class="bg-white/10 backdrop-blur rounded-2xl p-8 text-center">
                    <i class="fas fa-star text-3xl text-white mx-auto mb-4"></i>
                    <h3 class="text-xl font-semibold mb-2">Top Contributors</h3>
                    <p class="text-orange-100">Recognize the most active developers across all capstone teams.</p>
                </div>
            </div>
        </div>
    </section>

    
    <section class="py-16 bg-slate-900 text-white">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-2xl sm:text-3xl font-bold tracking-tight mb-4">Ready to Monitor Your Capstone Progress?</h2>
            <p class="text-lg text-slate-300 mb-8 max-w-2xl mx-auto">Join the platform that keeps capstone teams accountable, advisers informed, and development visible.</p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('dashboard')); ?>" class="inline-flex items-center justify-center rounded-lg bg-orange-600 px-6 py-3 text-sm font-semibold text-white hover:bg-orange-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-300">Go to Dashboard</a>
                <?php else: ?>
                    <a href="<?php echo e(route('register')); ?>" class="inline-flex items-center justify-center rounded-lg bg-orange-600 px-6 py-3 text-sm font-semibold text-white hover:bg-orange-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-300">Register Your Team</a>
                    <a href="<?php echo e(route('login')); ?>" class="inline-flex items-center justify-center rounded-lg bg-white/10 px-6 py-3 text-sm font-semibold text-white hover:bg-white/20 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white backdrop-blur">Log In</a>
                <?php endif; ?>
            </div>
        </div>
    </section>

    
    <footer class="bg-slate-900 border-t border-slate-800 py-8">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <i class="fas fa-code text-xl text-orange-600"></i>
                    <span class="text-sm font-bold text-white">Capstone<span class="text-orange-600">Monitor</span></span>
                </div>
                <p class="text-sm text-slate-500">&copy; <?php echo e(date('Y')); ?> Capstone Development Monitoring System. All rights reserved.</p>
            </div>
        </div>
    </footer>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $attributes = $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $component = $__componentOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?><?php /**PATH C:\Users\Ian\Desktop\PROJECTS\SCHOOL\TECH\capstone-development-monitoring\resources\views/welcome.blade.php ENDPATH**/ ?>