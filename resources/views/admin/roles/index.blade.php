<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-6xl sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight text-slate-900">Roles & Permissions</h1>
                    <p class="mt-2 text-sm text-slate-600">Manage system roles and their permissions</p>
                </div>
            </div>

            {{-- Roles List --}}
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200">
                @if ($roles->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="border-b border-slate-200 bg-slate-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900">Role Name</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900">Permissions</th>
                                    <th class="px-6 py-3 text-right text-sm font-semibold text-slate-900">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200">
                                @foreach ($roles as $role)
                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="px-6 py-4 text-sm font-medium text-slate-900">
                                            <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1">
                                                <i class="fas fa-shield-alt text-slate-600"></i>
                                                {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-slate-600">
                                            <div class="flex flex-wrap gap-2">
                                                @forelse ($role->permissions->take(3) as $permission)
                                                    <span class="inline-flex items-center rounded-full bg-orange-50 px-2.5 py-0.5 text-xs font-medium text-orange-700 ring-1 ring-orange-200">
                                                        {{ $permission->name }}
                                                    </span>
                                                @empty
                                                    <span class="text-slate-400 italic">No permissions</span>
                                                @endforelse
                                                @if ($role->permissions->count() > 3)
                                                    <span class="text-xs text-slate-500">+{{ $role->permissions->count() - 3 }} more</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="{{ route('admin.roles.show', $role) }}" class="inline-flex items-center justify-center rounded-lg text-sm font-semibold text-slate-700 hover:bg-slate-100 px-3 py-2">
                                                    <i class="fas fa-eye mr-1"></i> View
                                                </a>
                                                <a href="{{ route('admin.roles.edit', $role) }}" class="inline-flex items-center justify-center rounded-lg text-sm font-semibold text-slate-700 hover:bg-slate-100 px-3 py-2">
                                                    <i class="fas fa-edit mr-1"></i> Edit
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="px-6 py-12 text-center">
                        <i class="fas fa-shield-alt text-4xl text-slate-300 mb-3"></i>
                        <p class="text-slate-600">No roles found</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
