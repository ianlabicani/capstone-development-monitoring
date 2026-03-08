{{-- Empty State or Fallback to Add Manual Story --}}
@if ($team->documents->isEmpty())
    <div class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200">
        <div class="p-6 text-center">
            <i class="fas fa-file-upload text-4xl text-slate-300 mb-4 block"></i>
            <p class="text-slate-600">Provide project input to get started.</p>
            <p class="mt-1 text-sm text-slate-500">Upload files (PDF or TXT) or write a project description above.</p>
        </div>
    </div>
@else
    @include('team-leader.analysis._add-story')
@endif
