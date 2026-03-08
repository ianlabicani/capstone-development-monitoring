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

    public function __construct(public Team $team) {}

    public function handle(PdfExtractorService $pdfExtractor, GeminiService $gemini): void
    {
        $this->team->update(['analysis_status' => 'processing']);

        try {
            $documents = $this->team->documents;

            if ($documents->isEmpty()) {
                $this->team->update(['analysis_status' => null]);

                return;
            }

            $combinedText = '';
            foreach ($documents as $document) {
                $path = Storage::disk('local')->path($document->file_path);
                $combinedText .= $pdfExtractor->extract($path)."\n\n";
            }

            $stories = $gemini->generateUserStories(trim($combinedText));

            if (empty($stories)) {
                $this->team->update(['analysis_status' => 'stale']);

                return;
            }

            $this->team->userStories()
                ->whereIn('status', ['draft', 'outdated'])
                ->delete();

            foreach ($stories as $index => $storyData) {
                UserStory::create([
                    'team_id' => $this->team->id,
                    'title' => $storyData['title'] ?? 'Untitled Story',
                    'description' => $storyData['description'] ?? null,
                    'keywords' => $storyData['keywords'] ?? [],
                    'status' => 'draft',
                    'sort_order' => $index,
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
}
