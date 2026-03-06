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
            
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight text-slate-900">Repositories</h1>
                    <p class="mt-2 text-sm text-slate-600">Manage GitHub repositories for <?php echo e($team->name); ?></p>
                </div>
                <a href="<?php echo e(route('team-leader.repositories.create')); ?>" class="inline-flex items-center justify-center rounded-lg bg-orange-600 px-6 py-3 text-sm font-semibold text-white hover:bg-orange-700">
                    <i class="fas fa-plus mr-2"></i> Connect Repository
                </a>
            </div>

            
            <?php if($message = session('success')): ?>
                <div class="mb-6 rounded-2xl bg-emerald-50 p-4 ring-1 ring-emerald-200">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-check-circle text-lg text-emerald-600"></i>
                        <div>
                            <h3 class="font-semibold text-emerald-900">Success</h3>
                            <p class="mt-1 text-sm text-emerald-700"><?php echo e($message); ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200">
                <?php if($repositories->count() > 0): ?>
                    <div class="divide-y divide-slate-200">
                        <?php $__currentLoopData = $repositories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $repository): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="p-6 hover:bg-slate-50 transition">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-4">
                                        <i class="fab fa-github text-2xl text-slate-700"></i>
                                        <div>
                                            <a href="<?php echo e(route('team-leader.repositories.show', $repository)); ?>" class="font-semibold text-slate-900 hover:text-orange-600">
                                                <?php echo e($repository->full_name); ?>

                                            </a>
                                            <p class="text-sm text-slate-500"><?php echo e($repository->description ?? 'No description'); ?></p>
                                            <div class="mt-1 flex items-center gap-4 text-xs text-slate-400">
                                                <span><i class="fas fa-code-branch mr-1"></i> <?php echo e($repository->default_branch); ?></span>
                                                <span><i class="fas fa-code-commit mr-1"></i> <?php echo e($repository->commits_count ?? 0); ?> commits</span>
                                                <?php if($repository->last_synced_at): ?>
                                                    <span><i class="fas fa-sync mr-1"></i> Synced <?php echo e($repository->last_synced_at->diffForHumans()); ?></span>
                                                <?php else: ?>
                                                    <span class="text-amber-500"><i class="fas fa-exclamation-circle mr-1"></i> Not synced yet</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <form action="<?php echo e(route('team-leader.repositories.sync', $repository)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="inline-flex items-center rounded-lg border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                                                <i class="fas fa-sync mr-2"></i> Sync
                                            </button>
                                        </form>
                                        <a href="<?php echo e(route('team-leader.repositories.show', $repository)); ?>" class="inline-flex items-center rounded-lg border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                                            <i class="fas fa-eye mr-2"></i> View
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <div class="p-6 text-center">
                        <i class="fab fa-github text-4xl text-slate-300 mb-4 block"></i>
                        <p class="text-slate-600">No repositories connected yet.</p>
                        <a href="<?php echo e(route('team-leader.repositories.create')); ?>" class="mt-4 inline-flex items-center justify-center rounded-lg bg-orange-600 px-6 py-3 text-sm font-semibold text-white hover:bg-orange-700">
                            <i class="fas fa-plus mr-2"></i> Connect Your First Repository
                        </a>
                    </div>
                <?php endif; ?>
            </div>
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
<?php /**PATH C:\Users\Ian\Desktop\PROJECTS\SCHOOL\TECH\capstone-development-monitoring\resources\views/team-leader/repositories/index.blade.php ENDPATH**/ ?>