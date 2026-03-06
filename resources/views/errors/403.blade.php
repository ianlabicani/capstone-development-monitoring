<x-guest-layout>
<div class="flex items-center justify-center min-h-[calc(100vh-4rem)] bg-gradient-to-br from-slate-50 to-slate-100 px-4">
    <div class="rounded-2xl bg-white p-8 shadow-sm ring-1 ring-slate-200 text-center max-w-md">
        <div class="mb-6 flex justify-center">
            <div class="flex h-20 w-20 items-center justify-center rounded-full bg-orange-50 ring-1 ring-orange-200">
                <i class="fas fa-lock text-4xl text-orange-600"></i>
            </div>
        </div>

        <h1 class="text-3xl font-bold text-slate-900 mb-2">Access Denied</h1>
        <p class="text-slate-600 mb-6">Sorry, you don't have permission to access this resource. Check your permissions and try again.</p>

        <div class="flex flex-col gap-3 sm:flex-row sm:justify-center">
            <a href="/" class="inline-flex items-center justify-center rounded-lg bg-orange-600 px-4 py-2 text-sm font-semibold text-white hover:bg-orange-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-300">
                <i class="fas fa-home mr-2"></i> Go Home
            </a>
            <a href="javascript:history.back()" class="inline-flex items-center justify-center rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-slate-300">
                <i class="fas fa-arrow-left mr-2"></i> Go Back
            </a>
        </div>
    </div>
</div>
</x-guest-layout>
