<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Welcome Section -->
            <div class="mb-8">
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-2">
                        {{ __('Welcome to Administration') }}
                    </h3>
                    <p class="text-slate-600">
                        {{ __('Manage capstone teachers, technical advisers, and role permissions from here.') }}
                    </p>
                </div>
            </div>

            <!-- Admin Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Capstone Teachers Card -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-slate-600 text-sm font-medium">{{ __('Capstone Teachers') }}</p>
                                <p class="text-3xl font-bold text-slate-900 mt-1">
                                    {{ $capstoneTeachersCount }}
                                </p>
                            </div>
                            <div class="p-3 bg-green-100 rounded-lg">
                                <i class="fas fa-graduation-cap text-2xl text-green-600"></i>
                            </div>
                        </div>
                        <a href="{{ route('admin.capstone-teachers.index') }}" class="inline-block mt-4 text-green-600 hover:text-green-700 text-sm font-medium">
                            {{ __('Manage') }} →
                        </a>
                    </div>
                </div>

                <!-- Technical Advisers Card -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-slate-600 text-sm font-medium">{{ __('Technical Advisers') }}</p>
                                <p class="text-3xl font-bold text-slate-900 mt-1">
                                    {{ $technicalAdvisersCount }}
                                </p>
                            </div>
                            <div class="p-3 bg-blue-100 rounded-lg">
                                <i class="fas fa-users text-2xl text-blue-600"></i>
                            </div>
                        </div>
                        <a href="{{ route('admin.technical-advisers.index') }}" class="inline-block mt-4 text-blue-600 hover:text-blue-700 text-sm font-medium">
                            {{ __('Manage') }} →
                        </a>
                    </div>
                </div>

                <!-- Roles Card -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-slate-600 text-sm font-medium">{{ __('Roles') }}</p>
                                <p class="text-3xl font-bold text-slate-900 mt-1">
                                    {{ $rolesCount }}
                                </p>
                            </div>
                            <div class="p-3 bg-purple-100 rounded-lg">
                                <i class="fas fa-shield-alt text-2xl text-purple-600"></i>
                            </div>
                        </div>
                        <a href="{{ route('admin.roles.index') }}" class="inline-block mt-4 text-purple-600 hover:text-purple-700 text-sm font-medium">
                            {{ __('Manage') }} →
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                <h4 class="text-lg font-semibold text-slate-900 mb-4">{{ __('Quick Actions') }}</h4>
                <div class="space-y-2">
                    <a href="{{ route('admin.capstone-teachers.create') }}" class="flex items-center px-4 py-2 text-green-600 hover:bg-green-50 rounded-lg transition">
                        <i class="fas fa-plus mr-2"></i>
                        {{ __('Add Capstone Teacher') }}
                    </a>
                    <a href="{{ route('admin.technical-advisers.create') }}" class="flex items-center px-4 py-2 text-blue-600 hover:bg-blue-50 rounded-lg transition">
                        <i class="fas fa-plus mr-2"></i>
                        {{ __('Add Technical Adviser') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
