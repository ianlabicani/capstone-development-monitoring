<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'Laravel')); ?></title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

        <!-- Scripts -->
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    </head>
    <body class="font-sans text-slate-900 antialiased">
        <nav x-data="{ open: false }" class="sticky top-0 z-50 bg-white shadow-sm">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <a href="/" class="flex items-center gap-2">
                        <i class="fas fa-code text-xl text-orange-600"></i>
                        <span class="text-xl font-bold text-slate-900">Capstone<span class="text-orange-600">Monitor</span></span>
                    </a>

                    
                    <div class="hidden sm:flex items-center gap-4">
                        <a href="<?php echo e(route('leaderboard.teams')); ?>" class="text-sm font-medium text-slate-600 hover:text-slate-900">Teams</a>
                        <a href="<?php echo e(route('leaderboard.contributors')); ?>" class="text-sm font-medium text-slate-600 hover:text-slate-900">Contributors</a>
                        <?php if(auth()->guard()->check()): ?>
                            <a href="<?php echo e(route('dashboard')); ?>" class="text-sm font-medium text-slate-600 hover:text-slate-900">Dashboard</a>
                        <?php else: ?>
                            <a href="<?php echo e(route('login')); ?>" class="text-sm font-medium text-slate-600 hover:text-slate-900">Log in</a>
                            <?php if(Route::has('register')): ?>
                                <a href="<?php echo e(route('register')); ?>" class="inline-flex items-center justify-center rounded-lg bg-orange-600 px-4 py-2 text-sm font-semibold text-white hover:bg-orange-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-300">Register</a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>

                    
                    <button @click="open = !open" class="sm:hidden inline-flex items-center justify-center rounded-md p-2 text-slate-500 hover:text-slate-900 hover:bg-slate-100 focus:outline-none focus:bg-slate-100 transition">
                        <i x-show="!open" x-cloak class="fas fa-bars text-xl"></i>
                        <i x-show="open" x-cloak class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>

            
            <div x-show="open" x-cloak x-transition class="fixed inset-x-0 top-16 z-40 bg-white border-t border-slate-200 sm:hidden">
                <div class="px-4 py-3 space-y-2 max-h-96 overflow-y-auto">
                    <a href="<?php echo e(route('leaderboard.teams')); ?>" class="block rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">Teams</a>
                    <a href="<?php echo e(route('leaderboard.contributors')); ?>" class="block rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">Contributors</a>
                    <?php if(auth()->guard()->check()): ?>
                        <a href="<?php echo e(route('dashboard')); ?>" class="block rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">Dashboard</a>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="block rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">Log in</a>
                        <?php if(Route::has('register')): ?>
                            <a href="<?php echo e(route('register')); ?>" class="block rounded-lg px-3 py-2 text-sm font-semibold text-center bg-orange-600 text-white hover:bg-orange-700">Register</a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </nav>

        <?php echo e($slot); ?>

    </body>
</html>
<?php /**PATH C:\Users\Ian\Desktop\PROJECTS\SCHOOL\TECH\capstone-development-monitoring\resources\views/layouts/guest.blade.php ENDPATH**/ ?>