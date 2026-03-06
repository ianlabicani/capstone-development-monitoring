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
        <div class="mx-auto max-w-2xl sm:px-6 lg:px-8">
            
            <div class="mb-6">
                <h1 class="text-3xl font-bold tracking-tight text-slate-900">Connect Repository</h1>
                <p class="mt-2 text-sm text-slate-600">Link a GitHub repository to <?php echo e($team->name); ?></p>
            </div>

            
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200">
                <div class="p-6">
                    <form action="<?php echo e(route('team-leader.repositories.store')); ?>" method="POST" class="space-y-6">
                        <?php echo csrf_field(); ?>

                        
                        <div>
                            <label for="github_owner" class="block text-sm font-semibold text-slate-900 mb-2">Repository Owner</label>
                            <input
                                type="text"
                                id="github_owner"
                                name="github_owner"
                                value="<?php echo e(old('github_owner')); ?>"
                                class="w-full rounded-lg border border-slate-300 px-4 py-2 text-slate-900 placeholder-slate-400 focus:border-orange-500 focus:outline-none focus:ring-1 focus:ring-orange-500"
                                placeholder="e.g. octocat"
                                required
                            />
                            <?php $__errorArgs = ['github_owner'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div>
                            <label for="github_repo" class="block text-sm font-semibold text-slate-900 mb-2">Repository Name</label>
                            <input
                                type="text"
                                id="github_repo"
                                name="github_repo"
                                value="<?php echo e(old('github_repo')); ?>"
                                class="w-full rounded-lg border border-slate-300 px-4 py-2 text-slate-900 placeholder-slate-400 focus:border-orange-500 focus:outline-none focus:ring-1 focus:ring-orange-500"
                                placeholder="e.g. hello-world"
                                required
                            />
                            <?php $__errorArgs = ['github_repo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="rounded-lg bg-slate-50 p-4 ring-1 ring-slate-200">
                            <div class="flex items-center gap-3">
                                <i class="fab fa-github text-xl text-slate-700"></i>
                                <div>
                                    <p class="text-sm font-semibold text-slate-900">Repository URL</p>
                                    <p class="mt-1 text-sm text-slate-600">github.com/<span id="preview-owner" class="text-orange-600">owner</span>/<span id="preview-repo" class="text-orange-600">repo</span></p>
                                </div>
                            </div>
                        </div>

                        
                        <div class="rounded-lg bg-blue-50 p-4 ring-1 ring-blue-200">
                            <div class="flex gap-3">
                                <i class="fas fa-info-circle text-lg text-blue-600 mt-0.5"></i>
                                <div>
                                    <p class="text-sm font-semibold text-blue-900">How it works</p>
                                    <p class="mt-1 text-sm text-blue-700">We'll validate the repository exists on GitHub and fetch its metadata. After connecting, you can sync commits manually.</p>
                                </div>
                            </div>
                        </div>

                        
                        <div class="flex gap-3 pt-4">
                            <button
                                type="submit"
                                class="flex-1 rounded-lg bg-orange-600 px-6 py-2 text-sm font-semibold text-white hover:bg-orange-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-300"
                            >
                                Connect Repository
                            </button>
                            <a
                                href="<?php echo e(route('team-leader.repositories.index')); ?>"
                                class="flex-1 rounded-lg border border-slate-300 px-6 py-2 text-sm font-semibold text-slate-900 hover:bg-slate-50 text-center"
                            >
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('github_owner').addEventListener('input', function() {
            document.getElementById('preview-owner').textContent = this.value || 'owner';
        });
        document.getElementById('github_repo').addEventListener('input', function() {
            document.getElementById('preview-repo').textContent = this.value || 'repo';
        });
    </script>
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
<?php /**PATH C:\Users\Ian\Desktop\PROJECTS\SCHOOL\TECH\capstone-development-monitoring\resources\views/team-leader/repositories/create.blade.php ENDPATH**/ ?>