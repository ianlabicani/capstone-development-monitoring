<?php

use App\Models\Commit;
use App\Models\Repository;
use App\Models\Team;
use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;

beforeEach(function () {
    $this->seed(RoleAndPermissionSeeder::class);
    $this->adviser = User::factory()->technicalAdviser()->create();
});

// --- Index Tests ---

test('ta can view monitoring index', function () {
    $this->actingAs($this->adviser)
        ->get(route('technical-adviser.monitoring.index'))
        ->assertOk()
        ->assertViewIs('technical-adviser.monitoring.index');
});

test('monitoring index shows teams from own team leaders', function () {
    $tl = User::factory()->teamLeader()->create(['created_by' => $this->adviser->id]);
    $team = Team::factory()->create(['user_id' => $tl->id, 'name' => 'My Supervised Team']);

    $this->actingAs($this->adviser)
        ->get(route('technical-adviser.monitoring.index'))
        ->assertOk()
        ->assertSee('My Supervised Team');
});

test('monitoring index does not show teams from other advisers', function () {
    $otherAdviser = User::factory()->technicalAdviser()->create();
    $tl = User::factory()->teamLeader()->create(['created_by' => $otherAdviser->id]);
    Team::factory()->create(['user_id' => $tl->id, 'name' => 'Other Adviser Team']);

    $this->actingAs($this->adviser)
        ->get(route('technical-adviser.monitoring.index'))
        ->assertOk()
        ->assertDontSee('Other Adviser Team');
});

test('monitoring index shows aggregate stats per team', function () {
    $tl = User::factory()->teamLeader()->create(['created_by' => $this->adviser->id]);
    $team = Team::factory()->create(['user_id' => $tl->id]);
    $repo = Repository::factory()->create(['team_id' => $team->id]);
    Commit::factory()->count(5)->create([
        'repository_id' => $repo->id,
        'committed_at' => now()->subDays(2),
    ]);

    $this->actingAs($this->adviser)
        ->get(route('technical-adviser.monitoring.index'))
        ->assertOk()
        ->assertSee('5'); // total commits shown
});

test('monitoring index shows empty state when no teams exist', function () {
    $this->actingAs($this->adviser)
        ->get(route('technical-adviser.monitoring.index'))
        ->assertOk()
        ->assertSee('No teams to monitor yet.');
});

// --- Show Tests ---

test('ta can view monitoring show for own team', function () {
    $tl = User::factory()->teamLeader()->create(['created_by' => $this->adviser->id]);
    $team = Team::factory()->create(['user_id' => $tl->id]);

    $this->actingAs($this->adviser)
        ->get(route('technical-adviser.monitoring.show', $team))
        ->assertOk()
        ->assertViewIs('technical-adviser.monitoring.show');
});

test('monitoring show displays team stats', function () {
    $tl = User::factory()->teamLeader()->create(['created_by' => $this->adviser->id]);
    $team = Team::factory()->create(['user_id' => $tl->id]);
    $repo = Repository::factory()->create(['team_id' => $team->id]);
    Commit::factory()->count(3)->create([
        'repository_id' => $repo->id,
        'committed_at' => now()->subDays(2),
    ]);
    Commit::factory()->count(2)->create([
        'repository_id' => $repo->id,
        'committed_at' => now()->subWeeks(2),
    ]);

    $this->actingAs($this->adviser)
        ->get(route('technical-adviser.monitoring.show', $team))
        ->assertOk()
        ->assertViewHas('totalCommits', 5)
        ->assertViewHas('weeklyCommits', 3);
});

test('monitoring show displays recent commits', function () {
    $tl = User::factory()->teamLeader()->create(['created_by' => $this->adviser->id]);
    $team = Team::factory()->create(['user_id' => $tl->id]);
    $repo = Repository::factory()->create(['team_id' => $team->id]);
    Commit::factory()->create([
        'repository_id' => $repo->id,
        'message' => 'Fix important bug',
    ]);

    $this->actingAs($this->adviser)
        ->get(route('technical-adviser.monitoring.show', $team))
        ->assertOk()
        ->assertSee('Fix important bug');
});

test('monitoring show counts unique contributors', function () {
    $tl = User::factory()->teamLeader()->create(['created_by' => $this->adviser->id]);
    $team = Team::factory()->create(['user_id' => $tl->id]);
    $repo = Repository::factory()->create(['team_id' => $team->id]);

    Commit::factory()->create(['repository_id' => $repo->id, 'author_email' => 'alice@test.com']);
    Commit::factory()->create(['repository_id' => $repo->id, 'author_email' => 'bob@test.com']);
    Commit::factory()->create(['repository_id' => $repo->id, 'author_email' => 'alice@test.com']);

    $this->actingAs($this->adviser)
        ->get(route('technical-adviser.monitoring.show', $team))
        ->assertOk()
        ->assertViewHas('contributors', 2);
});

test('ta cannot view monitoring show for other advisers team', function () {
    $otherAdviser = User::factory()->technicalAdviser()->create();
    $tl = User::factory()->teamLeader()->create(['created_by' => $otherAdviser->id]);
    $team = Team::factory()->create(['user_id' => $tl->id]);

    $this->actingAs($this->adviser)
        ->get(route('technical-adviser.monitoring.show', $team))
        ->assertForbidden();
});

// --- Authorization Tests ---

test('unauthenticated user cannot access monitoring', function () {
    $this->get(route('technical-adviser.monitoring.index'))
        ->assertRedirect(route('login'));
});

test('team leader cannot access monitoring', function () {
    $tl = User::factory()->teamLeader()->create();

    $this->actingAs($tl)
        ->get(route('technical-adviser.monitoring.index'))
        ->assertForbidden();
});

// --- TeamLeaderController scoping ---

test('ta only sees team leaders they created', function () {
    $ownTl = User::factory()->teamLeader()->create([
        'name' => 'Own TL',
        'created_by' => $this->adviser->id,
    ]);
    $otherTl = User::factory()->teamLeader()->create([
        'name' => 'Other TL',
        'created_by' => null,
    ]);

    $this->actingAs($this->adviser)
        ->get(route('technical-adviser.team-leaders.index'))
        ->assertOk()
        ->assertSee('Own TL')
        ->assertDontSee('Other TL');
});

test('creating a team leader sets created_by to current adviser', function () {
    $this->actingAs($this->adviser)
        ->post(route('technical-adviser.team-leaders.store'), [
            'name' => 'New TL',
            'email' => 'newtl@example.com',
        ]);

    $tl = User::where('email', 'newtl@example.com')->first();
    expect($tl->created_by)->toBe($this->adviser->id);
});
