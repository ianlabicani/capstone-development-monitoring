<?php

use App\Enums\UserRole;
use App\Models\Commit;
use App\Models\Repository;
use App\Models\Team;
use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;

beforeEach(function () {
    $this->seed(RoleAndPermissionSeeder::class);
    $this->user = User::factory()->create();
    $this->user->assignRole(UserRole::TeamLeader);
});

test('team leader without team is redirected to team create', function () {
    $this->actingAs($this->user)
        ->get(route('team-leader.dashboard'))
        ->assertRedirect(route('team-leader.team.create'));
});

test('team leader can view dashboard', function () {
    Team::factory()->create(['user_id' => $this->user->id]);

    $this->actingAs($this->user)
        ->get(route('team-leader.dashboard'))
        ->assertOk()
        ->assertViewIs('team-leader.dashboard');
});

test('dashboard displays aggregate stats', function () {
    $team = Team::factory()->create(['user_id' => $this->user->id]);
    $repo = Repository::factory()->create(['team_id' => $team->id]);
    Commit::factory()->count(5)->create([
        'repository_id' => $repo->id,
        'committed_at' => now()->subDays(2),
    ]);
    Commit::factory()->count(3)->create([
        'repository_id' => $repo->id,
        'committed_at' => now()->subWeeks(2),
    ]);

    $this->actingAs($this->user)
        ->get(route('team-leader.dashboard'))
        ->assertOk()
        ->assertViewHas('totalCommits', 8)
        ->assertViewHas('weeklyCommits', 5);
});

test('dashboard displays recent commits across repos', function () {
    $team = Team::factory()->create(['user_id' => $this->user->id]);
    $repo1 = Repository::factory()->create(['team_id' => $team->id]);
    $repo2 = Repository::factory()->create(['team_id' => $team->id]);

    Commit::factory()->create([
        'repository_id' => $repo1->id,
        'message' => 'First repo commit',
    ]);
    Commit::factory()->create([
        'repository_id' => $repo2->id,
        'message' => 'Second repo commit',
    ]);

    $this->actingAs($this->user)
        ->get(route('team-leader.dashboard'))
        ->assertOk()
        ->assertSee('First repo commit')
        ->assertSee('Second repo commit');
});

test('dashboard counts unique contributors', function () {
    $team = Team::factory()->create(['user_id' => $this->user->id]);
    $repo = Repository::factory()->create(['team_id' => $team->id]);

    Commit::factory()->create([
        'repository_id' => $repo->id,
        'author_email' => 'alice@example.com',
    ]);
    Commit::factory()->create([
        'repository_id' => $repo->id,
        'author_email' => 'bob@example.com',
    ]);
    Commit::factory()->create([
        'repository_id' => $repo->id,
        'author_email' => 'alice@example.com',
    ]);

    $this->actingAs($this->user)
        ->get(route('team-leader.dashboard'))
        ->assertOk()
        ->assertViewHas('contributors', 2);
});

test('unauthenticated user cannot access dashboard', function () {
    $this->get(route('team-leader.dashboard'))
        ->assertRedirect(route('login'));
});

test('non-team-leader cannot access dashboard', function () {
    $adviser = User::factory()->create();
    $adviser->assignRole(UserRole::TechnicalAdviser);

    $this->actingAs($adviser)
        ->get(route('team-leader.dashboard'))
        ->assertForbidden();
});
