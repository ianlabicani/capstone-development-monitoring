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
                    <h1 class="text-3xl font-bold tracking-tight text-slate-900">Team Leaders</h1>
                    <p class="mt-2 text-sm text-slate-600">Manage team leader accounts</p>
                </div>
                <a href="<?php echo e(route('technical-adviser.team-leaders.create')); ?>" class="inline-flex items-center justify-center rounded-lg bg-orange-600 px-6 py-3 text-sm font-semibold text-white hover:bg-orange-700">
                    <i class="fas fa-plus mr-2"></i> Add Team Leader
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
                <?php if($teamLeaders->count() > 0): ?>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="border-b border-slate-200 bg-slate-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900">Name</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900">Email</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900">Status</th>
                                    <th class="px-6 py-3 text-right text-sm font-semibold text-slate-900">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200">
                                <?php $__currentLoopData = $teamLeaders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $leader): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="px-6 py-4 text-sm text-slate-900"><?php echo e($leader->name); ?></td>
                                        <td class="px-6 py-4 text-sm text-slate-600"><?php echo e($leader->email); ?></td>
                                        <td class="px-6 py-4 text-sm">
                                            <?php if($leader->deleted_at): ?>
                                                <span class="inline-flex items-center gap-1 rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                                    <i class="fas fa-trash-alt"></i> Deleted
                                                </span>
                                            <?php else: ?>
                                                <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                                    <i class="fas fa-check-circle"></i> Active
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="<?php echo e(route('technical-adviser.team-leaders.edit', $leader)); ?>" class="text-orange-600 hover:text-orange-700 font-semibold">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <button
                                                    onclick="if (confirm('Are you sure you want to delete this team leader?')) {
                                                        document.getElementById('delete-form-<?php echo e($leader->id); ?>').submit();
                                                    }"
                                                    class="text-red-600 hover:text-red-700 font-semibold"
                                                >
                                                    <i class="fas fa-trash-alt"></i> Delete
                                                </button>
                                                <form id="delete-form-<?php echo e($leader->id); ?>" action="<?php echo e(route('technical-adviser.team-leaders.destroy', $leader)); ?>" method="POST" class="hidden">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="p-6 text-center">
                        <i class="fas fa-inbox text-4xl text-slate-300 mb-4 block"></i>
                        <p class="text-slate-600">No team leaders yet.</p>
                        <a href="<?php echo e(route('technical-adviser.team-leaders.create')); ?>" class="mt-4 inline-flex items-center justify-center rounded-lg bg-orange-600 px-6 py-3 text-sm font-semibold text-white hover:bg-orange-700">
                            <i class="fas fa-plus mr-2"></i> Create One
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
<?php /**PATH C:\Users\Ian\Desktop\PROJECTS\SCHOOL\TECH\capstone-development-monitoring\resources\views/technical-adviser/team-leaders/index.blade.php ENDPATH**/ ?>