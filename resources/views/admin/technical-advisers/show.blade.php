<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-2xl sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight text-slate-900">{{ $user->name }}</h1>
                    <p class="mt-2 text-sm text-slate-600">Technical Adviser Account</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.technical-advisers.edit', $user) }}" class="inline-flex items-center justify-center rounded-lg bg-orange-600 px-6 py-3 text-sm font-semibold text-white hover:bg-orange-700">
                        <i class="fas fa-edit mr-2"></i> Edit
                    </a>
                    <a href="{{ route('admin.technical-advisers.index') }}" class="inline-flex items-center justify-center rounded-lg border border-slate-300 px-6 py-3 text-sm font-semibold text-slate-900 hover:bg-slate-50">
                        <i class="fas fa-arrow-left mr-2"></i> Back
                    </a>
                </div>
            </div>

            {{-- Success Message --}}
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

            {{-- Account Details --}}
            <div class="space-y-4">
                {{-- Basic Info --}}
                <div class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200">
                    <div class="border-b border-slate-200 p-6">
                        <h2 class="text-lg font-semibold text-slate-900">Account Information</h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <p class="text-sm font-semibold text-slate-600">Name</p>
                                <p class="mt-1 text-slate-900">{{ $user->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-600">Email</p>
                                <p class="mt-1 text-slate-900">{{ $user->email }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Status --}}
                <div class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200">
                    <div class="border-b border-slate-200 p-6">
                        <h2 class="text-lg font-semibold text-slate-900">Status</h2>
                    </div>
                    <div class="p-6">
                        @if ($user->deleted_at)
                            <div class="inline-flex items-center gap-2 rounded-full bg-red-100 px-4 py-2">
                                <i class="fas fa-trash-alt text-red-600"></i>
                                <span class="font-semibold text-red-700">Deleted on {{ $user->deleted_at->format('M d, Y') }}</span>
                            </div>
                        @else
                            <div class="inline-flex items-center gap-2 rounded-full bg-emerald-100 px-4 py-2">
                                <i class="fas fa-check-circle text-emerald-600"></i>
                                <span class="font-semibold text-emerald-700">Active</span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Password Info --}}
                <div class="bg-blue-50 border border-blue-200 overflow-hidden shadow-sm rounded-2xl ring-1 ring-blue-200">
                    <div class="p-6">
                        <h2 class="text-lg font-semibold text-blue-900 mb-2">Password Management</h2>
                        <p class="text-sm text-blue-700">The technical adviser can reset their password anytime from their profile settings page.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
