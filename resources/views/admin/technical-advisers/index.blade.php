<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-6xl sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight text-slate-900">Technical Advisers</h1>
                    <p class="mt-2 text-sm text-slate-600">Manage technical adviser accounts</p>
                </div>
                <a href="{{ route('admin.technical-advisers.create') }}" class="inline-flex items-center justify-center rounded-lg bg-orange-600 px-6 py-3 text-sm font-semibold text-white hover:bg-orange-700">
                    <i class="fas fa-plus mr-2"></i> Add Technical Adviser
                </a>
            </div>

            {{-- Flash Messages --}}
            @if ($message = session('success'))
                <div class="mb-6 rounded-2xl bg-emerald-50 p-4 ring-1 ring-emerald-200">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-check-circle text-lg text-emerald-600"></i>
                        <div>
                            <h3 class="font-semibold text-emerald-900">Success</h3>
                            <p class="mt-1 text-sm text-emerald-700">{{ $message }}</p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Table --}}
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200">
                @if ($technicalAdvisers->count() > 0)
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
                                @foreach ($technicalAdvisers as $adviser)
                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="px-6 py-4 text-sm text-slate-900">{{ $adviser->name }}</td>
                                        <td class="px-6 py-4 text-sm text-slate-600">{{ $adviser->email }}</td>
                                        <td class="px-6 py-4 text-sm">
                                            @if ($adviser->deleted_at)
                                                <span class="inline-flex items-center gap-1 rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                                    <i class="fas fa-trash-alt"></i> Deleted
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                                    <i class="fas fa-check-circle"></i> Active
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm text-right">
                                            <div class="flex items-center justify-end gap-2" 
                                                 @confirm-action.window="$event.detail === 'delete-adviser-{{ $adviser->id }}' && document.getElementById('delete-form-{{ $adviser->id }}').submit()"
                                            >
                                                <a href="{{ route('admin.technical-advisers.edit', $adviser) }}" class="text-orange-600 hover:text-orange-700 font-semibold">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <button
                                                    type="button"
                                                    @click="$dispatch('open-modal', 'delete-adviser-{{ $adviser->id }}')"
                                                    class="text-red-600 hover:text-red-700 font-semibold"
                                                >
                                                    <i class="fas fa-trash-alt"></i> Delete
                                                </button>
                                                <form id="delete-form-{{ $adviser->id }}" action="{{ route('admin.technical-advisers.destroy', $adviser) }}" method="POST" class="hidden">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-6 text-center">
                        <i class="fas fa-inbox text-4xl text-slate-300 mb-4 block"></i>
                        <p class="text-slate-600">No technical advisers yet.</p>
                        <a href="{{ route('admin.technical-advisers.create') }}" class="mt-4 inline-flex items-center justify-center rounded-lg bg-orange-600 px-6 py-3 text-sm font-semibold text-white hover:bg-orange-700">
                            <i class="fas fa-plus mr-2"></i> Create One
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @foreach ($technicalAdvisers as $adviser)
        <x-confirm-modal
            name="delete-adviser-{{ $adviser->id }}"
            title="Delete Technical Adviser"
            message="Are you sure you want to delete {{ $adviser->name }}? This action cannot be undone."
            confirmText="Delete"
            confirmClass="bg-red-600 hover:bg-red-700"
            @click.away="show = false"
            x-on:confirm="document.getElementById('delete-form-{{ $adviser->id }}').submit()"
        />
    @endforeach
</x-app-layout>
