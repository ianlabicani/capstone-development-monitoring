<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="mb-6 flex items-center">
                <a href="{{ route('admin.roles.show', $role) }}" class="text-orange-600 hover:text-orange-700 mr-3">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="text-3xl font-bold tracking-tight text-slate-900">Edit {{ ucfirst(str_replace('_', ' ', $role->name)) }}</h1>
                    <p class="mt-2 text-sm text-slate-600">Manage permissions for this role</p>
                </div>
            </div>

            {{-- Edit Form --}}
            <form action="{{ route('admin.roles.update', $role) }}" method="POST" class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200 p-6">
                @csrf
                @method('PATCH')

                {{-- Permissions Grid --}}
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-slate-900 mb-4">Select Permissions</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach ($allPermissions as $permission)
                            <label class="flex items-center p-4 rounded-lg border border-slate-200 hover:bg-slate-50 cursor-pointer transition">
                                <input 
                                    type="checkbox" 
                                    name="permissions[]" 
                                    value="{{ $permission->value }}"
                                    {{ $role->hasPermissionTo($permission->value) ? 'checked' : '' }}
                                    class="w-4 h-4 rounded border-slate-300 text-orange-600 focus:ring-orange-600"
                                >
                                <span class="ml-3">
                                    <span class="block text-sm font-medium text-slate-900">{{ $permission->name }}</span>
                                    <span class="block text-xs text-slate-500">{{ $permission->value }}</span>
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- Form Actions --}}
                <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-200">
                    <a href="{{ route('admin.roles.show', $role) }}" class="inline-flex items-center justify-center rounded-lg border border-slate-300 px-6 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-orange-600 px-6 py-3 text-sm font-semibold text-white hover:bg-orange-700">
                        <i class="fas fa-save mr-2"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
