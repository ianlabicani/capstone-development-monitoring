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
                <h1 class="text-3xl sm:text-4xl font-bold text-slate-900">Top Contributors</h1>
                <p class="mt-2 text-slate-600">Meet the most active developers across all capstone teams. Ranked by <?php echo e($period === 'week' ? 'weekly' : ($period === 'month' ? 'monthly' : 'all-time')); ?> commits.</p>
            </div>

            <!-- Period Tabs -->
            <div class="mb-8 flex gap-2">
                <a href="<?php echo e(route('leaderboard.contributors', ['period' => 'week'])); ?>"
                   class="px-4 py-2 rounded-lg text-sm font-medium transition <?php echo e($period === 'week' ? 'bg-orange-600 text-white' : 'bg-slate-200 text-slate-700 hover:bg-slate-300'); ?>">
                    This Week
                </a>
                <a href="<?php echo e(route('leaderboard.contributors', ['period' => 'month'])); ?>"
                   class="px-4 py-2 rounded-lg text-sm font-medium transition <?php echo e($period === 'month' ? 'bg-orange-600 text-white' : 'bg-slate-200 text-slate-700 hover:bg-slate-300'); ?>">
                    This Month
                </a>
                <a href="<?php echo e(route('leaderboard.contributors', ['period' => 'all'])); ?>"
                   class="px-4 py-2 rounded-lg text-sm font-medium transition <?php echo e($period === 'all' ? 'bg-orange-600 text-white' : 'bg-slate-200 text-slate-700 hover:bg-slate-300'); ?>">
                    All Time
                </a>
            </div>

            <!-- Contributors Grid -->
            <?php if($contributors->count()): ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php $__currentLoopData = $contributors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rank => $contributor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 p-6 hover:shadow-md transition text-center">
                            <!-- Rank & Avatar -->
                            <div class="flex justify-center mb-4">
                                <div class="relative">
                                    <img src="https://github.com/<?php echo e($contributor->author_login); ?>.png?size=80"
                                         alt="<?php echo e($contributor->author_name); ?>"
                                         class="w-16 h-16 rounded-full border-4 border-orange-100">
                                    <div class="absolute -top-2 -right-2 w-8 h-8 bg-orange-600 text-white rounded-full flex items-center justify-center text-sm font-bold">
                                        #<?php echo e($rank + 1); ?>

                                    </div>
                                </div>
                            </div>

                            <!-- Info -->
                            <h3 class="text-lg font-semibold text-slate-900"><?php echo e($contributor->author_name); ?></h3>
                            <p class="text-sm text-slate-500 mb-4">{{ $contributor->author_login }}</p>

                            <!-- Stats -->
                            <div class="space-y-2 mb-6">
                                <div class="flex items-center justify-center gap-2">
                                    <i class="fas fa-code text-orange-600"></i>
                                    <span class="text-2xl font-bold text-slate-900"><?php echo e($contributor->commit_count); ?></span>
                                    <span class="text-sm text-slate-500">commits</span>
                                </div>

                                <?php if($contributor->streak > 0): ?>
                                    <div class="flex items-center justify-center gap-2">
                                        <i class="fas fa-fire text-orange-500"></i>
                                        <span class="font-semibold text-slate-900"><?php echo e($contributor->streak); ?>-day streak</span>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- GitHub Link -->
                            <a href="https://github.com/<?php echo e($contributor->author_login); ?>"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 text-slate-700 rounded-lg text-sm font-medium hover:bg-slate-200 transition">
                                <i class="fab fa-github"></i>
                                View Profile
                            </a>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="text-center py-12 bg-slate-50 rounded-2xl ring-1 ring-slate-200">
                    <i class="fas fa-inbox text-4xl text-slate-300 mb-4"></i>
                    <p class="text-slate-600">No contributors found for the selected period.</p>
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
<?php /**PATH C:\Users\Ian\Desktop\PROJECTS\SCHOOL\TECH\capstone-development-monitoring\resources\views/leaderboard/contributors.blade.php ENDPATH**/ ?>