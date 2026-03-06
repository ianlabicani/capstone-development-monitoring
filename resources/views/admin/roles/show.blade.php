<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <a href="{{ route('admin.roles.index') }}" class="text-orange-600 hover:text-orange-700">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <h1 class="text-3xl font-bold tracking-tight text-slate-900">{{ ucfirst(str_replace('_', ' ', $role->name)) }}</h1>
                    </div>
                    <p class="text-sm text-slate-600">View and manage role permissions</p>
                </div>
                <a href="{{ route('admin.roles.edit', $role) }}" class="inline-flex items-center justify-center rounded-lg bg-orange-600 px-6 py-3 text-sm font-semibold text-white hover:bg-orange-700">
                    <i class="fas fa-edit mr-2"></i> Edit Permissions
                </a>
            </div>

            {{-- Permissions Card --}}
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200 p-6">
                <h2 class="text-lg font-semibold text-slate-900 mb-4">Assigned Permissions ({{ $role->permissions->count() }})</h2>

                @if ($role->permissions->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @foreach ($role->permissions as $permission)
                            <div class="flex items-center gap-3 p-3 rounded-lg bg-slate-50 border border-slate-200">
                                <i class="fas fa-check-circle text-emerald-600"></i>
                                <span class="text-sm font-medium text-slate-900">{{ $permission->name }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-lock text-4xl text-slate-300 mb-3"></i>
                        <p class="text-slate-600">No permissions assigned to this role</p>
                    </div>
                @endif
            </div>

            {{-- Role Info Card --}}
            <div class="mt-6 bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200 p-6">
                <h2 class="text-lg font-semibold text-slate-900 mb-4">Role Information</h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Role Name</label>
                        <p class="mt-1 text-sm text-slate-900 font-mono">{{ $role->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Guard</label>
                        <p class="mt-1 text-sm text-slate-900">{{ $role->guard_name }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
