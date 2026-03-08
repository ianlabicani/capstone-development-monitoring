<?php

namespace App\Jobs;

use App\Models\Team;
use App\Models\UserStory;
use App\Services\GeminiService;
use App\Services\PdfExtractorService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class GenerateUserStoriesJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 2;

    /** @var array<int, int> */
    public array $backoff = [30, 60];

    public function __construct(
        public Team $team,
        public string $source = 'files',
    ) {}

    public function handle(PdfExtractorService $pdfExtractor, GeminiService $gemini): void
    {
        $this->team->update(['analysis_status' => 'processing']);

        try {
            $text = $this->extractText($pdfExtractor);

            if (empty(trim($text))) {
                $this->team->update(['analysis_status' => 'stale']);

                return;
            }

            $existingStories = $this->team->userStories()
                ->select('title', 'description')
                ->get()
                ->map(fn ($s): array => ['title' => $s->title, 'description' => $s->description ?? ''])
                ->all();

            $stories = $gemini->generateUserStories(trim($text), $existingStories);

            if (empty($stories)) {
                $this->team->update(['analysis_status' => 'stale']);

                return;
            }

            $nextVersion = ($this->team->userStories()->max('version') ?? 0) + 1;

            foreach ($stories as $index => $storyData) {
                UserStory::create([
                    'team_id' => $this->team->id,
                    'title' => $storyData['title'] ?? 'Untitled Story',
                    'description' => $storyData['description'] ?? null,
                    'keywords' => $storyData['keywords'] ?? [],
                    'status' => 'draft',
                    'sort_order' => $index,
                    'version' => $nextVersion,
                ]);
            }

            $this->team->update([
                'analysis_status' => 'completed',
                'analysis_completed_at' => now(),
            ]);
        } catch (\Throwable $e) {
            Log::error('User story generation failed', [
                'team_id' => $this->team->id,
                'error' => $e->getMessage(),
            ]);

            $this->team->update(['analysis_status' => 'stale']);

            throw $e;
        }
    }

    private function extractText(PdfExtractorService $pdfExtractor): string
    {
        if ($this->source === 'text') {
            $textDoc = $this->team->documents()->where('type', 'text')->first();

            return $textDoc?->content ?? '';
        }

        $documents = $this->team->documents()->where('type', 'file')->get();

        if ($documents->isEmpty()) {
            return '';
        }

        $combinedText = '';
        foreach ($documents as $document) {
            $path = Storage::disk('local')->path($document->file_path);
            $extension = pathinfo($document->original_name, PATHINFO_EXTENSION);

            if ($extension === 'txt') {
                $combinedText .= Storage::disk('local')->get($document->file_path)."\n\n";
            } else {
                $combinedText .= $pdfExtractor->extract($path)."\n\n";
            }
        }

        return $combinedText;
    }
}
