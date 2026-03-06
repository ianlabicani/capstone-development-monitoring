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
    <div class="bg-slate-50 min-h-screen">
        
        <header class="bg-slate-900">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 py-12">
                <div class="flex items-center gap-2 mb-6">
                    <a href="/" class="flex items-center gap-2">
                        <i class="fas fa-code text-xl text-orange-600"></i>
                        <span class="text-xl font-bold text-white">Capstone<span class="text-orange-600">Monitor</span></span>
                    </a>
                </div>
                <h1 class="text-3xl sm:text-4xl font-bold tracking-tight text-white"><?php echo e($team->name); ?></h1>
                <?php if($team->description): ?>
                    <p class="mt-3 text-lg text-slate-300 max-w-3xl"><?php echo e($team->description); ?></p>
                <?php endif; ?>
            </div>
        </header>

        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 py-8">
            
            <div class="mb-8 grid grid-cols-3 gap-4">
                <div class="bg-white rounded-2xl ring-1 ring-slate-200 p-6 text-center">
                    <p class="text-3xl font-bold text-orange-600"><?php echo e($totalCommits); ?></p>
                    <p class="mt-1 text-sm text-slate-600">Total Commits</p>
                </div>
                <div class="bg-white rounded-2xl ring-1 ring-slate-200 p-6 text-center">
                    <p class="text-3xl font-bold text-orange-600"><?php echo e($contributors); ?></p>
                    <p class="mt-1 text-sm text-slate-600">Contributors</p>
                </div>
                <div class="bg-white rounded-2xl ring-1 ring-slate-200 p-6 text-center">
                    <p class="text-3xl font-bold text-orange-600"><?php echo e($team->repositories->count()); ?></p>
                    <p class="mt-1 text-sm text-slate-600">Repositories</p>
                </div>
            </div>

            <div class="space-y-6">
                
                <div class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200">
                    <div class="border-b border-slate-200 p-6">
                        <h2 class="text-lg font-semibold text-slate-900">Repositories</h2>
                    </div>
                    <?php if($team->repositories->count() > 0): ?>
                        <div class="divide-y divide-slate-200">
                            <?php $__currentLoopData = $team->repositories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $repository): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex items-center justify-between p-6">
                                    <div class="flex items-center gap-3">
                                        <i class="fab fa-github text-xl text-slate-700"></i>
                                        <div>
                                            <p class="font-semibold text-slate-900"><?php echo e($repository->full_name); ?></p>
                                            <p class="text-sm text-slate-500"><?php echo e($repository->description ?? 'No description'); ?></p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-4 text-sm text-slate-500">
                                        <span><i class="fas fa-code mr-1"></i> <?php echo e($repository->commits_count); ?> commits</span>
                                        <span><i class="fas fa-code-branch mr-1"></i> <?php echo e($repository->default_branch); ?></span>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="p-6 text-center">
                            <p class="text-slate-600">No repositories connected yet.</p>
                        </div>
                    <?php endif; ?>
                </div>

                
                <div class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200">
                    <div class="border-b border-slate-200 p-6">
                        <h2 class="text-lg font-semibold text-slate-900">Recent Commits</h2>
                    </div>
                    <?php if($recentCommits->count() > 0): ?>
                        <div class="divide-y divide-slate-200">
                            <?php $__currentLoopData = $recentCommits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $commit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex items-start gap-4 p-6">
                                    <div class="flex-shrink-0 mt-1">
                                        <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-code-commit text-sm text-orange-600"></i>
                                        </div>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-sm font-medium text-slate-900 truncate"><?php echo e(Str::limit($commit->message, 100)); ?></p>
                                        <div class="mt-1 flex items-center gap-3 text-xs text-slate-500">
                                            <span>
                                                <?php if($commit->author_login): ?>
                                                    <i class="fas fa-user mr-1"></i> <?php echo e($commit->author_login); ?>

                                                <?php else: ?>
                                                    <i class="fas fa-user mr-1"></i> <?php echo e($commit->author_name); ?>

                                                <?php endif; ?>
                                            </span>
                                            <span><i class="fas fa-clock mr-1"></i> <?php echo e($commit->committed_at->diffForHumans()); ?></span>
                                            <span class="text-slate-400"><?php echo e($commit->repository->full_name); ?></span>
                                        </div>
                                    </div>
                                    <a href="<?php echo e($commit->url); ?>" target="_blank" rel="noopener noreferrer" class="flex-shrink-0 font-mono text-xs text-orange-600 hover:text-orange-700">
                                        <?php echo e(substr($commit->sha, 0, 7)); ?>

                                    </a>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="p-6 text-center">
                            <i class="fas fa-code-commit text-4xl text-slate-300 mb-4 block"></i>
                            <p class="text-slate-600">No commits yet.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        
        <footer class="bg-slate-900 border-t border-slate-800 py-8 mt-12">
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
<?php /**PATH C:\Users\Ian\Desktop\PROJECTS\SCHOOL\TECH\capstone-development-monitoring\resources\views/projects/show.blade.php ENDPATH**/ ?>