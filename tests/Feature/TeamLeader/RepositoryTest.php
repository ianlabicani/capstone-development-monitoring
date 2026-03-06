<?php

use App\Enums\UserRole;
use App\Models\Repository;
use App\Models\Team;
use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    $this->seed(RoleAndPermissionSeeder::class);
    $this->user = User::factory()->create();
    $this->user->assignRole(UserRole::TeamLeader);
    $this->team = Team::factory()->create(['user_id' => $this->user->id]);
});

test('team leader can view repositories index', function () {
    $this->actingAs($this->user)
        ->get(route('team-leader.repositories.index'))
        ->assertOk();
});

test('team leader without team is redirected from repositories index', function () {
    $userNoTeam = User::factory()->create();
    $userNoTeam->assignRole(UserRole::TeamLeader);

    $this->actingAs($userNoTeam)
        ->get(route('team-leader.repositories.index'))
        ->assertRedirect(route('team-leader.team.create'));
});

test('team leader can view repository create page', function () {
    $this->actingAs($this->user)
        ->get(route('team-leader.repositories.create'))
        ->assertOk();
});

test('team leader can connect a repository', function () {
    Http::fake([
        'api.github.com/repos/octocat/hello-world' => Http::response([
            'name' => 'hello-world',
            'full_name' => 'octocat/hello-world',
            'default_branch' => 'main',
            'description' => 'My first repository on GitHub!',
        ]),
    ]);

    $this->actingAs($this->user)
        ->post(route('team-leader.repositories.store'), [
            'github_owner' => 'octocat',
            'github_repo' => 'hello-world',
        ])
        ->assertRedirect();

    $this->assertDatabaseHas('repositories', [
        'team_id' => $this->team->id,
        'github_owner' => 'octocat',
        'github_repo' => 'hello-world',
        'full_name' => 'octocat/hello-world',
        'default_branch' => 'main',
    ]);
});

test('connecting a nonexistent repository shows error', function () {
    Http::fake([
        'api.github.com/repos/octocat/nope' => Http::response(['message' => 'Not Found'], 404),
    ]);

    $this->actingAs($this->user)
        ->post(route('team-leader.repositories.store'), [
            'github_owner' => 'octocat',
            'github_repo' => 'nope',
        ])
        ->assertRedirect()
        ->assertSessionHasErrors('github_repo');
});

test('team leader can view a repository', function () {
    $repository = Repository::factory()->create(['team_id' => $this->team->id]);

    $this->actingAs($this->user)
        ->get(route('team-leader.repositories.show', $repository))
        ->assertOk()
        ->assertSee($repository->full_name);
});

test('team leader cannot view another teams repository', function () {
    $otherRepo = Repository::factory()->create();

    $this->actingAs($this->user)
        ->get(route('team-leader.repositories.show', $otherRepo))
        ->assertForbidden();
});

test('team leader can sync commits', function () {
    $repository = Repository::factory()->create([
        'team_id' => $this->team->id,
        'github_owner' => 'octocat',
        'github_repo' => 'hello-world',
        'default_branch' => 'main',
    ]);

    Http::fake([
        'api.github.com/repos/octocat/hello-world/commits*' => Http::response([
            [
                'sha' => 'abc123def456',
                'commit' => [
                    'message' => 'Initial commit',
                    'author' => [
                        'name' => 'Octocat',
                        'email' => 'octocat@github.com',
                        'date' => '2026-03-06T10:00:00Z',
                    ],
                ],
                'author' => ['login' => 'octocat'],
                'html_url' => 'https://github.com/octocat/hello-world/commit/abc123def456',
            ],
        ]),
    ]);

    $this->actingAs($this->user)
        ->post(route('team-leader.repositories.sync', $repository))
        ->assertRedirect()
        ->assertSessionHas('success');

    $this->assertDatabaseHas('commits', [
        'repository_id' => $repository->id,
        'sha' => 'abc123def456',
        'author_login' => 'octocat',
    ]);

    $repository->refresh();
    expect($repository->last_synced_at)->not->toBeNull();
});

test('team leader can delete a repository', function () {
    $repository = Repository::factory()->create(['team_id' => $this->team->id]);

    $this->actingAs($this->user)
        ->delete(route('team-leader.repositories.destroy', $repository))
        ->assertRedirect(route('team-leader.repositories.index'));

    $this->assertDatabaseMissing('repositories', ['id' => $repository->id]);
});

test('team leader cannot delete another teams repository', function () {
    $otherRepo = Repository::factory()->create();

    $this->actingAs($this->user)
        ->delete(route('team-leader.repositories.destroy', $otherRepo))
        ->assertForbidden();
});

test('guest cannot access repository routes', function () {
    $this->get(route('team-leader.repositories.index'))->assertRedirect(route('login'));
    $this->post(route('team-leader.repositories.store'))->assertRedirect(route('login'));
});

test('repository owner field is required', function () {
    $this->actingAs($this->user)
        ->post(route('team-leader.repositories.store'), [
            'github_owner' => '',
            'github_repo' => 'hello-world',
        ])
        ->assertSessionHasErrors('github_owner');
});

test('repository name field is required', function () {
    $this->actingAs($this->user)
        ->post(route('team-leader.repositories.store'), [
            'github_owner' => 'octocat',
            'github_repo' => '',
        ])
        ->assertSessionHasErrors('github_repo');
});
