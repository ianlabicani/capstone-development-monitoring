<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class GitHubService
{
    private PendingRequest $http;

    public function __construct()
    {
        $this->http = Http::baseUrl(config('services.github.api_url'))
            ->withToken(config('services.github.token'))
            ->acceptJson()
            ->throw();
    }

    /**
     * Fetch repository metadata from GitHub.
     *
     * @return array{name: string, full_name: string, default_branch: string, description: ?string}
     */
    public function fetchRepository(string $owner, string $repo): array
    {
        $response = $this->http->get("/repos/{$owner}/{$repo}");

        $data = $response->json();

        return [
            'name' => $data['name'],
            'full_name' => $data['full_name'],
            'default_branch' => $data['default_branch'],
            'description' => $data['description'],
        ];
    }

    /**
     * Fetch commits from a repository's default branch.
     *
     * @return array<int, array{sha: string, message: string, author_name: string, author_email: string, author_login: ?string, committed_at: string, url: string}>
     */
    public function fetchCommits(string $owner, string $repo, string $branch = 'main', ?string $since = null, int $perPage = 100): array
    {
        $query = [
            'sha' => $branch,
            'per_page' => $perPage,
        ];

        if ($since) {
            $query['since'] = $since;
        }

        $commits = [];
        $page = 1;

        do {
            $query['page'] = $page;
            $response = $this->http->get("/repos/{$owner}/{$repo}/commits", $query);
            $items = $response->json();

            if (empty($items)) {
                break;
            }

            foreach ($items as $item) {
                $commits[] = [
                    'sha' => $item['sha'],
                    'message' => $item['commit']['message'],
                    'author_name' => $item['commit']['author']['name'],
                    'author_email' => $item['commit']['author']['email'],
                    'author_login' => $item['author']['login'] ?? null,
                    'committed_at' => $item['commit']['author']['date'],
                    'url' => $item['html_url'],
                ];
            }

            $page++;
        } while (count($items) === $perPage);

        return $commits;
    }
}
