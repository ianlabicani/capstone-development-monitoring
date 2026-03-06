@extends('layouts.guest')

@section('title', 'Server Error')

@push('body')
<div class="flex items-center justify-center min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 px-4">
    <div class="rounded-2xl bg-white p-8 shadow-sm ring-1 ring-slate-200 text-center max-w-md">
        <div class="mb-6 flex justify-center">
            <div class="flex h-20 w-20 items-center justify-center rounded-full bg-red-50 ring-1 ring-red-200">
                <i class="fas fa-exclamation-circle text-4xl text-red-600"></i>
            </div>
        </div>

        <h1 class="text-3xl font-bold text-slate-900 mb-2">Server Error</h1>
        <p class="text-slate-600 mb-6">Oops! Something went wrong on our end. We're working to fix it. Please try again later.</p>

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
@endpush
