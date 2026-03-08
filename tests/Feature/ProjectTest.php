<?php

use App\Models\Commit;
use App\Models\Repository;
use App\Models\Team;
use App\Models\UserStory;

test('public project page displays team info', function () {
    $team = Team::factory()->create([
        'name' => 'Team Phoenix',
        'slug' => 'team-phoenix',
        'description' => 'A great capstone project',
    ]);

    $this->get(route('projects.show', 'team-phoenix'))
        ->assertOk()
        ->assertSee('Team Phoenix')
        ->assertSee('A great capstone project');
});

test('public project page displays repositories', function () {
    $team = Team::factory()->create(['slug' => 'team-alpha']);
    Repository::factory()->create([
        'team_id' => $team->id,
        'full_name' => 'org/my-repo',
    ]);

    $this->get(route('projects.show', 'team-alpha'))
        ->assertOk()
        ->assertSee('org/my-repo');
});

test('public project page displays recent commits', function () {
    $team = Team::factory()->create(['slug' => 'team-beta']);
    $repo = Repository::factory()->create(['team_id' => $team->id]);
    Commit::factory()->create([
        'repository_id' => $repo->id,
        'message' => 'Fix login bug',
        'author_login' => 'devuser',
    ]);

    $this->get(route('projects.show', 'team-beta'))
        ->assertOk()
        ->assertSee('Fix login bug')
        ->assertSee('devuser');
});

test('public project page shows commit count stats', function () {
    $team = Team::factory()->create(['slug' => 'team-gamma']);
    $repo = Repository::factory()->create(['team_id' => $team->id]);
    Commit::factory()->count(5)->create(['repository_id' => $repo->id]);

    $this->get(route('projects.show', 'team-gamma'))
        ->assertOk()
        ->assertViewHas('totalCommits', 5);
});

test('public project page returns 404 for invalid slug', function () {
    $this->get(route('projects.show', 'nonexistent-team'))
        ->assertNotFound();
});

test('public project page is accessible without authentication', function () {
    $team = Team::factory()->create(['slug' => 'public-team']);

    $this->get(route('projects.show', 'public-team'))
        ->assertOk();
});

test('public project page shows contributor count', function () {
    $team = Team::factory()->create(['slug' => 'team-delta']);
    $repo = Repository::factory()->create(['team_id' => $team->id]);

    Commit::factory()->create([
        'repository_id' => $repo->id,
        'author_email' => 'alice@example.com',
    ]);
    Commit::factory()->create([
        'repository_id' => $repo->id,
        'author_email' => 'bob@example.com',
    ]);

    $this->get(route('projects.show', 'team-delta'))
        ->assertOk()
        ->assertViewHas('contributors', 2);
});

test('public project page shows analysis progress when stories exist', function () {
    $team = Team::factory()->create(['slug' => 'team-analysis']);
    UserStory::factory()->covered()->create(['team_id' => $team->id]);
    UserStory::factory()->approved()->create(['team_id' => $team->id]);

    $this->get(route('projects.show', 'team-analysis'))
        ->assertOk()
        ->assertViewHas('totalApproved', 2)
        ->assertViewHas('coveredCount', 1)
        ->assertViewHas('gapCount', 1)
        ->assertViewHas('progressPercent', 50);
});

test('public project page shows not ready when no approved stories', function () {
    $team = Team::factory()->create(['slug' => 'team-no-stories']);

    $this->get(route('projects.show', 'team-no-stories'))
        ->assertOk()
        ->assertViewHas('totalApproved', 0)
        ->assertSee('Not Ready');
});
