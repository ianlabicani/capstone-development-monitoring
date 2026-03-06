<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Technical Advisers Card -->
                <a href="{{ route('admin.technical-advisers.index') }}" class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200 hover:shadow-md hover:ring-orange-300 transition duration-150 ease-in-out">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900">{{ __('Technical Advisers') }}</h3>
                                <p class="text-sm text-slate-500 mt-1">{{ __('Manage system users') }}</p>
                            </div>
                            <i class="fas fa-users text-4xl text-orange-600 opacity-20"></i>
                        </div>
                    </div>
                </a>

                <!-- Roles & Permissions Card -->
                <a href="{{ route('admin.roles.index') }}" class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200 hover:shadow-md hover:ring-orange-300 transition duration-150 ease-in-out">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900">{{ __('Roles & Permissions') }}</h3>
                                <p class="text-sm text-slate-500 mt-1">{{ __('Configure system access') }}</p>
                            </div>
                            <i class="fas fa-key text-4xl text-orange-600 opacity-20"></i>
                        </div>
                    </div>
                </a>

                <!-- System Info Card -->
                <div class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900">{{ __('Welcome') }}</h3>
                                <p class="text-sm text-slate-500 mt-1">{{ __('System Administrator') }}</p>
                            </div>
                            <i class="fas fa-cog text-4xl text-orange-600 opacity-20"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
