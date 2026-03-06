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
                    <h1 class="text-3xl font-bold tracking-tight text-slate-900"><?php echo e($team->name); ?></h1>
                    <p class="mt-2 text-sm text-slate-600"><?php echo e($team->description ?? 'No description yet'); ?></p>
                </div>
                <div class="flex gap-2">
                    <a href="<?php echo e(route('projects.show', $team->slug)); ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center rounded-lg border border-slate-300 px-6 py-3 text-sm font-semibold text-slate-900 hover:bg-slate-50">
                        <i class="fas fa-external-link-alt mr-2"></i> Public Page
                    </a>
                    <a href="<?php echo e(route('team-leader.team.edit')); ?>" class="inline-flex items-center justify-center rounded-lg bg-orange-600 px-6 py-3 text-sm font-semibold text-white hover:bg-orange-700">
                        <i class="fas fa-edit mr-2"></i> Edit Team
                    </a>
                </div>
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

            
            <div class="space-y-6">
                <div class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200">
                    <div class="border-b border-slate-200 p-6">
                        <h2 class="text-lg font-semibold text-slate-900">Team Information</h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <p class="text-sm font-semibold text-slate-600">Team Name</p>
                                <p class="mt-1 text-slate-900"><?php echo e($team->name); ?></p>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-600">Slug</p>
                                <p class="mt-1 text-slate-900"><?php echo e($team->slug); ?></p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-sm font-semibold text-slate-600">Description</p>
                                <p class="mt-1 text-slate-900"><?php echo e($team->description ?? 'No description'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200">
                    <div class="border-b border-slate-200 p-6 flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-slate-900">Repositories</h2>
                        <a href="<?php echo e(route('team-leader.repositories.create')); ?>" class="inline-flex items-center rounded-lg bg-orange-600 px-4 py-2 text-sm font-semibold text-white hover:bg-orange-700">
                            <i class="fas fa-plus mr-2"></i> Connect Repository
                        </a>
                    </div>
                    <div class="p-6">
                        <?php if($team->repositories->count() > 0): ?>
                            <div class="space-y-3">
                                <?php $__currentLoopData = $team->repositories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $repository): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a href="<?php echo e(route('team-leader.repositories.show', $repository)); ?>" class="flex items-center justify-between rounded-lg border border-slate-200 p-4 hover:bg-slate-50 transition">
                                        <div class="flex items-center gap-3">
                                            <i class="fab fa-github text-xl text-slate-700"></i>
                                            <div>
                                                <p class="font-semibold text-slate-900"><?php echo e($repository->full_name); ?></p>
                                                <p class="text-sm text-slate-500"><?php echo e($repository->description ?? 'No description'); ?></p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-4 text-sm text-slate-500">
                                            <span><i class="fas fa-code-branch mr-1"></i> <?php echo e($repository->default_branch); ?></span>
                                            <?php if($repository->last_synced_at): ?>
                                                <span><i class="fas fa-sync mr-1"></i> <?php echo e($repository->last_synced_at->diffForHumans()); ?></span>
                                            <?php else: ?>
                                                <span class="text-amber-600"><i class="fas fa-exclamation-circle mr-1"></i> Not synced</span>
                                            <?php endif; ?>
                                        </div>
                                    </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-6">
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
<?php /**PATH C:\Users\Ian\Desktop\PROJECTS\SCHOOL\TECH\capstone-development-monitoring\resources\views/team-leader/team/show.blade.php ENDPATH**/ ?>