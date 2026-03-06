<section>
    <header>
        <h2 class="text-lg font-medium text-slate-900">
            <?php echo e(__('Update Password')); ?>

        </h2>

        <p class="mt-1 text-sm text-slate-600">
            <?php echo e(__('Ensure your account is using a long, random password to stay secure.')); ?>

        </p>
    </header>

    
    <?php if(session('status') === 'password-updated'): ?>
        <div class="mt-6 rounded-2xl bg-emerald-50 p-4 ring-1 ring-emerald-200">
            <div class="flex items-center gap-3">
                <i class="fas fa-check-circle text-lg text-emerald-600"></i>
                <div>
                    <h3 class="font-semibold text-emerald-900"><?php echo e(__('Password Updated')); ?></h3>
                    <p class="mt-1 text-sm text-emerald-700"><?php echo e(__('Your password has been changed successfully.')); ?></p>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <form method="post" action="<?php echo e(route('password.update')); ?>" class="mt-6 space-y-6">
        <?php echo csrf_field(); ?>
        <?php echo method_field('put'); ?>

        
        <div>
            <label for="update_password_current_password" class="block font-medium text-sm text-slate-700"><?php echo e(__('Current Password')); ?></label>
            <input
                id="update_password_current_password"
                name="current_password"
                type="password"
                autocomplete="current-password"
                class="mt-1 block w-full rounded-lg border border-slate-300 px-4 py-2 text-slate-900 placeholder-slate-400 focus:border-orange-500 focus:outline-none focus:ring-1 focus:ring-orange-500"
            />
            <?php if($errors->updatePassword->has('current_password')): ?>
                <div class="mt-2 rounded-lg bg-red-50 p-3 ring-1 ring-red-200">
                    <?php $__currentLoopData = $errors->updatePassword->get('current_password'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <p class="text-sm text-red-700 font-medium"><?php echo e($message); ?></p>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>

        
        <div>
            <label for="update_password_password" class="block font-medium text-sm text-slate-700"><?php echo e(__('New Password')); ?></label>
            <input
                id="update_password_password"
                name="password"
                type="password"
                autocomplete="new-password"
                class="mt-1 block w-full rounded-lg border border-slate-300 px-4 py-2 text-slate-900 placeholder-slate-400 focus:border-orange-500 focus:outline-none focus:ring-1 focus:ring-orange-500"
            />
            <?php if($errors->updatePassword->has('password')): ?>
                <div class="mt-2 rounded-lg bg-red-50 p-3 ring-1 ring-red-200">
                    <?php $__currentLoopData = $errors->updatePassword->get('password'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <p class="text-sm text-red-700 font-medium"><?php echo e($message); ?></p>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>

        
        <div>
            <label for="update_password_password_confirmation" class="block font-medium text-sm text-slate-700"><?php echo e(__('Confirm Password')); ?></label>
            <input
                id="update_password_password_confirmation"
                name="password_confirmation"
                type="password"
                autocomplete="new-password"
                class="mt-1 block w-full rounded-lg border border-slate-300 px-4 py-2 text-slate-900 placeholder-slate-400 focus:border-orange-500 focus:outline-none focus:ring-1 focus:ring-orange-500"
            />
            <?php if($errors->updatePassword->has('password_confirmation')): ?>
                <div class="mt-2 rounded-lg bg-red-50 p-3 ring-1 ring-red-200">
                    <?php $__currentLoopData = $errors->updatePassword->get('password_confirmation'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <p class="text-sm text-red-700 font-medium"><?php echo e($message); ?></p>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>

        
        <button
            type="submit"
            class="inline-flex items-center px-6 py-2 bg-orange-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-orange-700 focus:bg-orange-700 active:bg-orange-800 focus:outline-none focus:ring-2 focus:ring-orange-300 transition ease-in-out duration-150"
        >
            <?php echo e(__('Update Password')); ?>

        </button>
    </form>
</section>
<?php /**PATH C:\Users\Ian\Desktop\PROJECTS\SCHOOL\TECH\capstone-development-monitoring\resources\views/profile/partials/update-password-form.blade.php ENDPATH**/ ?>