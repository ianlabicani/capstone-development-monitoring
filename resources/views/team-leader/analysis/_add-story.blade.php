{{-- Add Manual Story --}}
<div class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200">
    <div class="border-b border-slate-200 p-6">
        <h2 class="text-lg font-semibold text-slate-900">Add User Story Manually</h2>
        <p class="mt-1 text-sm text-slate-500">Create user stories directly without AI analysis</p>
    </div>
    <div class="p-6">
        <form action="{{ route('team-leader.analysis.store-story') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="story_title" class="block text-sm font-medium text-slate-900 mb-1">Story Title</label>
                <input
                    type="text"
                    id="story_title"
                    name="title"
                    value="{{ old('title') }}"
                    placeholder="e.g., User Authentication System"
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:border-orange-500 focus:ring-1 focus:ring-orange-500"
                    required
                >
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="story_description" class="block text-sm font-medium text-slate-900 mb-1">Description</label>
                <textarea
                    id="story_description"
                    name="description"
                    rows="3"
                    placeholder="Describe what this user story involves..."
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:border-orange-500 focus:ring-1 focus:ring-orange-500"
                    required
                >{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex justify-end">
                <button
                    type="submit"
                    class="inline-flex items-center rounded-lg bg-orange-600 px-6 py-2.5 text-sm font-semibold text-white hover:bg-orange-700"
                >
                    <i class="fas fa-plus mr-2"></i> Add Story
                </button>
            </div>
        </form>
    </div>
</div>
