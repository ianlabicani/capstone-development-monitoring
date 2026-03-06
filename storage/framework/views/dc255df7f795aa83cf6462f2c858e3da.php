<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="py-12">
        <div class="mx-auto max-w-6xl sm:px-6 lg:px-8">
            
            <div class="mb-6">
                <h1 class="text-3xl font-bold tracking-tight text-slate-900">Team Monitoring</h1>
                <p class="mt-2 text-sm text-slate-600">Overview of all teams under your supervision.</p>
            </div>

            
            <?php if($teams->count() > 0): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <?php $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('technical-adviser.monitoring.show', $team)); ?>" class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200 hover:shadow-md transition block">
                            <div class="border-b border-slate-200 p-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h2 class="text-lg font-semibold text-slate-900"><?php echo e($team->name); ?></h2>
                                        <p class="mt-1 text-sm text-slate-500">Leader: <?php echo e($team->owner->name); ?></p>
                                    </div>
                                    <i class="fas fa-chevron-right text-slate-400"></i>
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="grid grid-cols-3 gap-4 text-center">
                                    <div>
                                        <p class="text-2xl font-bold text-orange-600"><?php echo e($team->total_commits); ?></p>
                                        <p class="text-xs text-slate-500">Total Commits</p>
                                    </div>
                                    <div>
                                        <p class="text-2xl font-bold text-orange-600"><?php echo e($team->weekly_commits); ?></p>
                                        <p class="text-xs text-slate-500">This Week</p>
                                    </div>
                                    <div>
                                        <p class="text-2xl font-bold text-orange-600"><?php echo e($team->contributors_count); ?></p>
                                        <p class="text-xs text-slate-500">Contributors</p>
                                    </div>
                                </div>
                                <?php if($team->repositories->count() > 0): ?>
                                    <div class="mt-4 pt-4 border-t border-slate-100">
                                        <p class="text-xs text-slate-500 mb-2">Repositories (<?php echo e($team->repositories->count()); ?>)</p>
                                        <div class="flex flex-wrap gap-2">
                                            <?php $__currentLoopData = $team->repositories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $repo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-3 py-1 text-xs text-slate-700">
                                                    <i class="fab fa-github"></i> <?php echo e($repo->github_repo); ?>

                                                </span>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="mt-4 pt-4 border-t border-slate-100 text-center">
                                        <p class="text-xs text-slate-400">No repositories connected</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200">
                    <div class="p-6 text-center">
                        <i class="fas fa-users text-4xl text-slate-300 mb-4 block"></i>
                        <p class="text-slate-600">No teams to monitor yet.</p>
                        <p class="mt-1 text-sm text-slate-500">Teams will appear here once your team leaders create them.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\Users\Ian\Desktop\PROJECTS\SCHOOL\TECH\capstone-development-monitoring\resources\views/technical-adviser/monitoring/index.blade.php ENDPATH**/ ?>