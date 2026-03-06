<nav x-data="{ open: false, dropdown: false }" class="sticky top-0 z-50 bg-white shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="/" class="flex items-center gap-2">
                        <i class="fas fa-code text-xl text-orange-600"></i>
                        <span class="text-xl font-bold text-slate-900">Capstone<span class="text-orange-600">Monitor</span></span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <!-- Dashboard: Role-aware routing -->
                    <?php if(Auth::user()->hasRole('admin')): ?>
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out <?php echo e(request()->routeIs('admin.dashboard') ? 'border-orange-500 text-slate-900 focus:border-orange-700' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300 focus:text-slate-700 focus:border-slate-300'); ?>">
                            <?php echo e(__('Dashboard')); ?>

                        </a>
                    <?php elseif(Auth::user()->hasRole('team_leader')): ?>
                        <a href="<?php echo e(route('team-leader.dashboard')); ?>" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out <?php echo e(request()->routeIs('team-leader.dashboard') ? 'border-orange-500 text-slate-900 focus:border-orange-700' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300 focus:text-slate-700 focus:border-slate-300'); ?>">
                            <?php echo e(__('Dashboard')); ?>

                        </a>
                    <?php elseif(Auth::user()->hasRole('capstone_teacher')): ?>
                        <a href="<?php echo e(route('capstone-teacher.dashboard')); ?>" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out <?php echo e(request()->routeIs('capstone-teacher.dashboard') ? 'border-orange-500 text-slate-900 focus:border-orange-700' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300 focus:text-slate-700 focus:border-slate-300'); ?>">
                            <?php echo e(__('Dashboard')); ?>

                        </a>
                    <?php elseif(Auth::user()->hasRole('technical_adviser')): ?>
                        <a href="<?php echo e(route('technical-adviser.monitoring.index')); ?>" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out <?php echo e(request()->routeIs('technical-adviser.monitoring.*') ? 'border-orange-500 text-slate-900 focus:border-orange-700' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300 focus:text-slate-700 focus:border-slate-300'); ?>">
                            <?php echo e(__('Dashboard')); ?>

                        </a>
                    <?php else: ?>
                        <a href="<?php echo e(route('dashboard')); ?>" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out <?php echo e(request()->routeIs('dashboard') ? 'border-orange-500 text-slate-900 focus:border-orange-700' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300 focus:text-slate-700 focus:border-slate-300'); ?>">
                            <?php echo e(__('Dashboard')); ?>

                        </a>
                    <?php endif; ?>

                    <!-- Capstone Teacher Management -->
                    <?php if(Auth::user()->hasRole('capstone_teacher')): ?>
                        <a href="<?php echo e(route('capstone-teacher.technical-advisers.index')); ?>" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out <?php echo e(request()->routeIs('capstone-teacher.technical-advisers.*') ? 'border-orange-500 text-slate-900 focus:border-orange-700' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300 focus:text-slate-700 focus:border-slate-300'); ?>">
                            <?php echo e(__('Technical Advisers')); ?>

                        </a>
                    <?php endif; ?>

                    <!-- Technical Adviser Management -->
                    <?php if(Auth::user()->hasRole('technical_adviser')): ?>
                        <a href="<?php echo e(route('technical-adviser.team-leaders.index')); ?>" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out <?php echo e(request()->routeIs('technical-adviser.team-leaders.*') ? 'border-orange-500 text-slate-900 focus:border-orange-700' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300 focus:text-slate-700 focus:border-slate-300'); ?>">
                            <?php echo e(__('Team Leaders')); ?>

                        </a>
                        <a href="<?php echo e(route('technical-adviser.monitoring.index')); ?>" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out <?php echo e(request()->routeIs('technical-adviser.monitoring.*') ? 'border-orange-500 text-slate-900 focus:border-orange-700' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300 focus:text-slate-700 focus:border-slate-300'); ?>">
                            <?php echo e(__('Monitoring')); ?>

                        </a>
                    <?php endif; ?>

                    <!-- System Administration -->
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage users')): ?>
                        <a href="<?php echo e(route('admin.technical-advisers.index')); ?>" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out <?php echo e(request()->routeIs('admin.technical-advisers.*') ? 'border-orange-500 text-slate-900 focus:border-orange-700' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300 focus:text-slate-700 focus:border-slate-300'); ?>">
                            <?php echo e(__('Technical Advisers')); ?>

                        </a>
                        <a href="<?php echo e(route('admin.capstone-teachers.index')); ?>" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out <?php echo e(request()->routeIs('admin.capstone-teachers.*') ? 'border-orange-500 text-slate-900 focus:border-orange-700' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300 focus:text-slate-700 focus:border-slate-300'); ?>">
                            <?php echo e(__('Capstone Teachers')); ?>

                        </a>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage system')): ?>
                        <a href="<?php echo e(route('admin.roles.index')); ?>" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out <?php echo e(request()->routeIs('admin.roles.*') ? 'border-orange-500 text-slate-900 focus:border-orange-700' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300 focus:text-slate-700 focus:border-slate-300'); ?>">
                            <?php echo e(__('Roles & Permissions')); ?>

                        </a>
                    <?php endif; ?>

                    <!-- Team Management -->
                    <?php if(Auth::user()->hasRole('team_leader') && !Auth::user()->hasRole('admin')): ?>
                        <a href="<?php echo e(route('team-leader.team.show')); ?>" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out <?php echo e(request()->routeIs('team-leader.team.*') ? 'border-orange-500 text-slate-900 focus:border-orange-700' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300 focus:text-slate-700 focus:border-slate-300'); ?>">
                            <?php echo e(__('My Team')); ?>

                        </a>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('register repository')): ?>
                        <?php if(!Auth::user()->hasRole('admin')): ?>
                            <a href="<?php echo e(route('team-leader.repositories.index')); ?>" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out <?php echo e(request()->routeIs('team-leader.repositories.*') ? 'border-orange-500 text-slate-900 focus:border-orange-700' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300 focus:text-slate-700 focus:border-slate-300'); ?>">
                                <?php echo e(__('Repositories')); ?>

                            </a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <div class="relative" @click.outside="dropdown = false">
                    <button @click="dropdown = !dropdown" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-lg text-slate-600 bg-white hover:text-slate-900 focus:outline-none transition ease-in-out duration-150">
                        <div><?php echo e(Auth::user()->name); ?></div>
                        <div class="ms-1">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </button>

                    <div x-show="dropdown" x-cloak
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute z-50 mt-2 w-48 rounded-lg shadow-lg ltr:origin-top-right rtl:origin-top-left end-0"
                         @click="dropdown = false">
                        <div class="rounded-lg ring-1 ring-black/5 py-1 bg-white">
                            <a href="<?php echo e(route('profile.edit')); ?>" class="block w-full px-4 py-2 text-start text-sm leading-5 text-slate-700 hover:bg-slate-100 focus:outline-none focus:bg-slate-100 transition duration-150 ease-in-out">
                                <?php echo e(__('Profile')); ?>

                            </a>

                            <form method="POST" action="<?php echo e(route('logout')); ?>">
                                <?php echo csrf_field(); ?>
                                <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); this.closest('form').submit();" class="block w-full px-4 py-2 text-start text-sm leading-5 text-slate-700 hover:bg-slate-100 focus:outline-none focus:bg-slate-100 transition duration-150 ease-in-out">
                                    <?php echo e(__('Log Out')); ?>

                                </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-slate-500 hover:text-slate-900 hover:bg-slate-100 focus:outline-none focus:bg-slate-100 transition duration-150 ease-in-out">
                    <i x-show="!open" x-cloak class="fas fa-bars text-xl"></i>
                    <i x-show="open" x-cloak class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': !open}" class="fixed inset-x-0 top-16 z-40 bg-white border-t border-slate-200 hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1 max-h-96 overflow-y-auto">
            <!-- Dashboard: Role-aware routing -->
            <?php if(Auth::user()->hasRole('admin')): ?>
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="block w-full ps-3 pe-4 py-2 border-l-4 text-start text-base font-medium transition duration-150 ease-in-out <?php echo e(request()->routeIs('admin.dashboard') ? 'border-orange-500 text-orange-700 bg-orange-50 focus:text-orange-800 focus:bg-orange-100 focus:border-orange-700' : 'border-transparent text-slate-600 hover:text-slate-800 hover:bg-slate-50 hover:border-slate-300 focus:text-slate-800 focus:bg-slate-50 focus:border-slate-300'); ?>">
                    <?php echo e(__('Dashboard')); ?>

                </a>
            <?php elseif(Auth::user()->hasRole('team_leader')): ?>
                <a href="<?php echo e(route('team-leader.dashboard')); ?>" class="block w-full ps-3 pe-4 py-2 border-l-4 text-start text-base font-medium transition duration-150 ease-in-out <?php echo e(request()->routeIs('team-leader.dashboard') ? 'border-orange-500 text-orange-700 bg-orange-50 focus:text-orange-800 focus:bg-orange-100 focus:border-orange-700' : 'border-transparent text-slate-600 hover:text-slate-800 hover:bg-slate-50 hover:border-slate-300 focus:text-slate-800 focus:bg-slate-50 focus:border-slate-300'); ?>">
                    <?php echo e(__('Dashboard')); ?>

                </a>
            <?php elseif(Auth::user()->hasRole('capstone_teacher')): ?>
                <a href="<?php echo e(route('capstone-teacher.dashboard')); ?>" class="block w-full ps-3 pe-4 py-2 border-l-4 text-start text-base font-medium transition duration-150 ease-in-out <?php echo e(request()->routeIs('capstone-teacher.dashboard') ? 'border-orange-500 text-orange-700 bg-orange-50 focus:text-orange-800 focus:bg-orange-100 focus:border-orange-700' : 'border-transparent text-slate-600 hover:text-slate-800 hover:bg-slate-50 hover:border-slate-300 focus:text-slate-800 focus:bg-slate-50 focus:border-slate-300'); ?>">
                    <?php echo e(__('Dashboard')); ?>

                </a>
            <?php elseif(Auth::user()->hasRole('technical_adviser')): ?>
                <a href="<?php echo e(route('technical-adviser.monitoring.index')); ?>" class="block w-full ps-3 pe-4 py-2 border-l-4 text-start text-base font-medium transition duration-150 ease-in-out <?php echo e(request()->routeIs('technical-adviser.monitoring.*') ? 'border-orange-500 text-orange-700 bg-orange-50 focus:text-orange-800 focus:bg-orange-100 focus:border-orange-700' : 'border-transparent text-slate-600 hover:text-slate-800 hover:bg-slate-50 hover:border-slate-300 focus:text-slate-800 focus:bg-slate-50 focus:border-slate-300'); ?>">
                    <?php echo e(__('Dashboard')); ?>

                </a>
            <?php else: ?>
                <a href="<?php echo e(route('dashboard')); ?>" class="block w-full ps-3 pe-4 py-2 border-l-4 text-start text-base font-medium transition duration-150 ease-in-out <?php echo e(request()->routeIs('dashboard') ? 'border-orange-500 text-orange-700 bg-orange-50 focus:text-orange-800 focus:bg-orange-100 focus:border-orange-700' : 'border-transparent text-slate-600 hover:text-slate-800 hover:bg-slate-50 hover:border-slate-300 focus:text-slate-800 focus:bg-slate-50 focus:border-slate-300'); ?>">
                    <?php echo e(__('Dashboard')); ?>

                </a>
            <?php endif; ?>

            <!-- Capstone Teacher Management -->
            <?php if(Auth::user()->hasRole('capstone_teacher')): ?>
                <a href="<?php echo e(route('capstone-teacher.technical-advisers.index')); ?>" class="block w-full ps-3 pe-4 py-2 border-l-4 text-start text-base font-medium transition duration-150 ease-in-out <?php echo e(request()->routeIs('capstone-teacher.technical-advisers.*') ? 'border-orange-500 text-orange-700 bg-orange-50 focus:text-orange-800 focus:bg-orange-100 focus:border-orange-700' : 'border-transparent text-slate-600 hover:text-slate-800 hover:bg-slate-50 hover:border-slate-300 focus:text-slate-800 focus:bg-slate-50 focus:border-slate-300'); ?>">
                    <?php echo e(__('Technical Advisers')); ?>

                </a>
            <?php endif; ?>

            <!-- Technical Adviser Management -->
            <?php if(Auth::user()->hasRole('technical_adviser')): ?>
                <a href="<?php echo e(route('technical-adviser.team-leaders.index')); ?>" class="block w-full ps-3 pe-4 py-2 border-l-4 text-start text-base font-medium transition duration-150 ease-in-out <?php echo e(request()->routeIs('technical-adviser.team-leaders.*') ? 'border-orange-500 text-orange-700 bg-orange-50 focus:text-orange-800 focus:bg-orange-100 focus:border-orange-700' : 'border-transparent text-slate-600 hover:text-slate-800 hover:bg-slate-50 hover:border-slate-300 focus:text-slate-800 focus:bg-slate-50 focus:border-slate-300'); ?>">
                    <?php echo e(__('Team Leaders')); ?>

                </a>
                <a href="<?php echo e(route('technical-adviser.monitoring.index')); ?>" class="block w-full ps-3 pe-4 py-2 border-l-4 text-start text-base font-medium transition duration-150 ease-in-out <?php echo e(request()->routeIs('technical-adviser.monitoring.*') ? 'border-orange-500 text-orange-700 bg-orange-50 focus:text-orange-800 focus:bg-orange-100 focus:border-orange-700' : 'border-transparent text-slate-600 hover:text-slate-800 hover:bg-slate-50 hover:border-slate-300 focus:text-slate-800 focus:bg-slate-50 focus:border-slate-300'); ?>">
                    <?php echo e(__('Monitoring')); ?>

                </a>
            <?php endif; ?>

            <!-- System Administration -->
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage users')): ?>
                <a href="<?php echo e(route('admin.technical-advisers.index')); ?>" class="block w-full ps-3 pe-4 py-2 border-l-4 text-start text-base font-medium transition duration-150 ease-in-out <?php echo e(request()->routeIs('admin.technical-advisers.*') ? 'border-orange-500 text-orange-700 bg-orange-50 focus:text-orange-800 focus:bg-orange-100 focus:border-orange-700' : 'border-transparent text-slate-600 hover:text-slate-800 hover:bg-slate-50 hover:border-slate-300 focus:text-slate-800 focus:bg-slate-50 focus:border-slate-300'); ?>">
                    <?php echo e(__('Technical Advisers')); ?>

                </a>
                <a href="<?php echo e(route('admin.capstone-teachers.index')); ?>" class="block w-full ps-3 pe-4 py-2 border-l-4 text-start text-base font-medium transition duration-150 ease-in-out <?php echo e(request()->routeIs('admin.capstone-teachers.*') ? 'border-orange-500 text-orange-700 bg-orange-50 focus:text-orange-800 focus:bg-orange-100 focus:border-orange-700' : 'border-transparent text-slate-600 hover:text-slate-800 hover:bg-slate-50 hover:border-slate-300 focus:text-slate-800 focus:bg-slate-50 focus:border-slate-300'); ?>">
                    <?php echo e(__('Capstone Teachers')); ?>

                </a>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage system')): ?>
                <a href="<?php echo e(route('admin.roles.index')); ?>" class="block w-full ps-3 pe-4 py-2 border-l-4 text-start text-base font-medium transition duration-150 ease-in-out <?php echo e(request()->routeIs('admin.roles.*') ? 'border-orange-500 text-orange-700 bg-orange-50 focus:text-orange-800 focus:bg-orange-100 focus:border-orange-700' : 'border-transparent text-slate-600 hover:text-slate-800 hover:bg-slate-50 hover:border-slate-300 focus:text-slate-800 focus:bg-slate-50 focus:border-slate-300'); ?>">
                    <?php echo e(__('Roles & Permissions')); ?>

                </a>
            <?php endif; ?>

            <!-- Team Management -->
            <?php if(Auth::user()->hasRole('team_leader') && !Auth::user()->hasRole('admin')): ?>
                <a href="<?php echo e(route('team-leader.team.show')); ?>" class="block w-full ps-3 pe-4 py-2 border-l-4 text-start text-base font-medium transition duration-150 ease-in-out <?php echo e(request()->routeIs('team-leader.team.*') ? 'border-orange-500 text-orange-700 bg-orange-50 focus:text-orange-800 focus:bg-orange-100 focus:border-orange-700' : 'border-transparent text-slate-600 hover:text-slate-800 hover:bg-slate-50 hover:border-slate-300 focus:text-slate-800 focus:bg-slate-50 focus:border-slate-300'); ?>">
                    <?php echo e(__('My Team')); ?>

                </a>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('register repository')): ?>
                <?php if(!Auth::user()->hasRole('admin')): ?>
                    <a href="<?php echo e(route('team-leader.repositories.index')); ?>" class="block w-full ps-3 pe-4 py-2 border-l-4 text-start text-base font-medium transition duration-150 ease-in-out <?php echo e(request()->routeIs('team-leader.repositories.*') ? 'border-orange-500 text-orange-700 bg-orange-50 focus:text-orange-800 focus:bg-orange-100 focus:border-orange-700' : 'border-transparent text-slate-600 hover:text-slate-800 hover:bg-slate-50 hover:border-slate-300 focus:text-slate-800 focus:bg-slate-50 focus:border-slate-300'); ?>">
                        <?php echo e(__('Repositories')); ?>

                    </a>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-slate-200">
            <div class="px-4">
                <div class="font-medium text-base text-slate-800"><?php echo e(Auth::user()->name); ?></div>
                <div class="font-medium text-sm text-slate-500"><?php echo e(Auth::user()->email); ?></div>
            </div>

            <div class="mt-3 space-y-1">
                <a href="<?php echo e(route('profile.edit')); ?>" class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-slate-600 hover:text-slate-800 hover:bg-slate-50 hover:border-slate-300 focus:outline-none focus:text-slate-800 focus:bg-slate-50 focus:border-slate-300 transition duration-150 ease-in-out">
                    <?php echo e(__('Profile')); ?>

                </a>

                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); this.closest('form').submit();" class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-slate-600 hover:text-slate-800 hover:bg-slate-50 hover:border-slate-300 focus:outline-none focus:text-slate-800 focus:bg-slate-50 focus:border-slate-300 transition duration-150 ease-in-out">
                        <?php echo e(__('Log Out')); ?>

                    </a>
                </form>
            </div>
        </div>
    </div>
</nav>
<?php /**PATH C:\Users\Ian\Desktop\PROJECTS\SCHOOL\TECH\capstone-development-monitoring\resources\views/layouts/navigation.blade.php ENDPATH**/ ?>