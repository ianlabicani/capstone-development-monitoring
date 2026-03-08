{{-- Documents Section (Hidden for presentation) --}}
@if (false)
<div class="bg-white overflow-hidden shadow-sm rounded-2xl ring-1 ring-slate-200">
    <div class="border-b border-slate-200 p-6">
        <h2 class="text-lg font-semibold text-slate-900">Project Documents</h2>
        <p class="mt-1 text-sm text-slate-500">Upload up to 2 files (PDF or TXT, max 10MB each)</p>
    </div>
    <div class="p-6 space-y-4">
        @foreach ([1, 2] as $slot)
            @php $doc = $team->documents->where('type', 'file')->firstWhere('slot', $slot); @endphp
            <div class="flex items-center justify-between rounded-lg border border-slate-200 p-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center {{ $doc ? 'bg-orange-100' : 'bg-slate-100' }}">
                        <i class="fas fa-file{{ $doc ? (str_ends_with($doc->original_name, '.txt') ? '-alt' : '-pdf') : '' }} text-lg {{ $doc ? 'text-orange-600' : 'text-slate-400' }}"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-900">Document {{ $slot }}</p>
                        @if ($doc)
                            <p class="text-xs text-slate-500">{{ $doc->original_name }} ({{ number_format($doc->file_size / 1024, 0) }} KB)</p>
                        @else
                            <p class="text-xs text-slate-400">No file uploaded</p>
                        @endif
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    @if ($doc)
                        <form action="{{ route('team-leader.analysis.delete-document', $doc) }}" method="POST" onsubmit="return confirm('Remove this document?')" x-data="{ loading: false }" @submit="loading = true">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center rounded-lg border border-red-300 px-3 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-50" :disabled="loading">
                                <template x-if="loading">
                                    <i class='fas fa-spinner fa-spin mr-1'></i>
                                </template>
                                <template x-if="!loading">
                                    <i class="fas fa-trash mr-1"></i>
                                </template>
                                <span x-text="loading ? 'Removing...' : 'Remove'"></span>
                            </button>
                        </form>
                    @endif
                    <form action="{{ route('team-leader.analysis.upload-document') }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-2" x-data="{ fileName: '' }">
                        @csrf
                        <input type="hidden" name="slot" value="{{ $slot }}">
                        <label class="inline-flex items-center rounded-lg border border-slate-300 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50 cursor-pointer">
                            <i class="fas fa-upload mr-1"></i>
                            <span x-text="fileName || '{{ $doc ? 'Replace' : 'Upload' }}'"></span>
                            <input type="file" name="document" accept=".pdf,.txt" class="hidden" @change="fileName = $event.target.files[0]?.name; $el.closest('form').submit()">
                        </label>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif
