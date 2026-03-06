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
    <div class="py-12">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl sm:text-4xl font-bold text-slate-900">Team Leaderboard</h1>
                <p class="mt-2 text-slate-600">See which capstone teams are most active. Ranked by <?php echo e($period === 'week' ? 'weekly' : ($period === 'month' ? 'monthly' : 'all-time')); ?> commits.</p>
            </div>

            <!-- Filters -->
            <div class="mb-8 flex flex-col sm:flex-row gap-4">
                <!-- Period Tabs -->
                <div class="flex gap-2">
                    <a href="<?php echo e(route('leaderboard.teams', ['period' => 'week', 'adviser' => $adviserId])); ?>"
                       class="px-4 py-2 rounded-lg text-sm font-medium transition <?php echo e($period === 'week' ? 'bg-orange-600 text-white' : 'bg-slate-200 text-slate-700 hover:bg-slate-300'); ?>">
                        This Week
                    </a>
                    <a href="<?php echo e(route('leaderboard.teams', ['period' => 'month', 'adviser' => $adviserId])); ?>"
                       class="px-4 py-2 rounded-lg text-sm font-medium transition <?php echo e($period === 'month' ? 'bg-orange-600 text-white' : 'bg-slate-200 text-slate-700 hover:bg-slate-300'); ?>">
                        This Month
                    </a>
                    <a href="<?php echo e(route('leaderboard.teams', ['period' => 'all', 'adviser' => $adviserId])); ?>"
                       class="px-4 py-2 rounded-lg text-sm font-medium transition <?php echo e($period === 'all' ? 'bg-orange-600 text-white' : 'bg-slate-200 text-slate-700 hover:bg-slate-300'); ?>">
                        All Time
                    </a>
                </div>

                <!-- Adviser Filter -->
                <div class="flex-1">
                    <select onchange="window.location.href = '<?php echo e(route('leaderboard.teams')); ?>?period=<?php echo e($period); ?>&adviser=' + this.value"
                            class="w-full px-4 py-2 rounded-lg border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                        <option value="">All Advisers</option>
                        <?php $__empty_1 = true; $__currentLoopData = $advisers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $adviser): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <option value="<?php echo e($adviser->id); ?>" <?php echo e($adviserId == $adviser->id ? 'selected' : ''); ?>>
                                <?php echo e($adviser->name ?? 'Unknown Adviser'); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>

            <!-- Teams Grid -->
            <?php if($teams->count()): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rank => $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 p-6 hover:shadow-md transition">
                            <!-- Rank Badge -->
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center flex-shrink-0">
                                        <span class="text-lg font-bold text-orange-600">#<?php echo e($rank + 1); ?></span>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-slate-900"><?php echo e($team->name); ?></h3>
                                        <p class="text-xs text-slate-500">By <?php echo e($team->owner ? $team->owner->name : 'Unknown'); ?></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Stats -->
                            <div class="space-y-3 mb-6">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-slate-600">
                                        <i class="fas fa-code text-orange-600 mr-2"></i>
                                        <?php echo e($period === 'week' ? 'This Week' : ($period === 'month' ? 'This Month' : 'All Time')); ?>

                                    </span>
                                    <span class="text-xl font-bold text-orange-600"><?php echo e(match ($period) {
                                        'month' => $team->this_month_commits,
                                        'week' => $team->this_week_commits,
                                        default => $team->all_time_commits,
                                    }); ?></span>
                                </div>

                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-slate-600">
                                        <i class="fas fa-code text-slate-400 mr-2"></i>
                                        Total Commits
                                    </span>
                                    <span class="font-semibold text-slate-900"><?php echo e($team->all_time_commits); ?></span>
                                </div>

                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-slate-600">
                                        <i class="fas fa-users text-slate-400 mr-2"></i>
                                        Contributors
                                    </span>
                                    <span class="font-semibold text-slate-900"><?php echo e($team->contributors_count); ?></span>
                                </div>

                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-slate-600">
                                        <i class="fas fa-folder text-slate-400 mr-2"></i>
                                        Repositories
                                    </span>
                                    <span class="font-semibold text-slate-900"><?php echo e($team->repositories_count); ?></span>
                                </div>
                            </div>

                            <!-- CTA -->
                            <a href="<?php echo e(route('projects.show', $team->slug)); ?>"
                               class="block w-full text-center px-4 py-2 bg-orange-600 text-white rounded-lg font-medium hover:bg-orange-700 transition">
                                View Project
                            </a>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="text-center py-12 bg-slate-50 rounded-2xl ring-1 ring-slate-200">
                    <i class="fas fa-inbox text-4xl text-slate-300 mb-4"></i>
                    <p class="text-slate-600">No teams found for the selected filters.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $attributes = $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $component = $__componentOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php /**PATH C:\Users\Ian\Desktop\PROJECTS\SCHOOL\TECH\capstone-development-monitoring\resources\views/leaderboard/teams.blade.php ENDPATH**/ ?>