<?php

use App\Models\Commit;
use App\Models\Repository;
use App\Models\Team;
use App\Models\User;

test('team belongs to an owner', function () {
    $user = User::factory()->create();
    $team = Team::factory()->create(['user_id' => $user->id]);

    expect($team->owner->id)->toBe($user->id);
});

test('team has many repositories', function () {
    $team = Team::factory()->create();
    Repository::factory()->count(3)->create(['team_id' => $team->id]);

    expect($team->repositories)->toHaveCount(3);
});

test('user has one team', function () {
    $user = User::factory()->create();
    $team = Team::factory()->create(['user_id' => $user->id]);

    expect($user->team->id)->toBe($team->id);
});

test('team slug is unique', function () {
    Team::factory()->create(['slug' => 'team-alpha']);

    expect(fn () => Team::factory()->create(['slug' => 'team-alpha']))
        ->toThrow(\Illuminate\Database\QueryException::class);
});

test('repository belongs to a team', function () {
    $team = Team::factory()->create();
    $repository = Repository::factory()->create(['team_id' => $team->id]);

    expect($repository->team->id)->toBe($team->id);
});

test('repository has many commits', function () {
    $repository = Repository::factory()->create();
    Commit::factory()->count(5)->create(['repository_id' => $repository->id]);

    expect($repository->commits)->toHaveCount(5);
});

test('repository casts is_active to boolean', function () {
    $repository = Repository::factory()->create(['is_active' => true]);

    expect($repository->is_active)->toBeTrue();
});

test('repository casts last_synced_at to datetime', function () {
    $repository = Repository::factory()->create();
    $repository->update(['last_synced_at' => now()]);
    $repository->refresh();

    expect($repository->last_synced_at)->toBeInstanceOf(\Illuminate\Support\Carbon::class);
});

test('commit belongs to a repository', function () {
    $repository = Repository::factory()->create();
    $commit = Commit::factory()->create(['repository_id' => $repository->id]);

    expect($commit->repository->id)->toBe($repository->id);
});

test('commit sha is unique per repository', function () {
    $repository = Repository::factory()->create();
    Commit::factory()->create(['repository_id' => $repository->id, 'sha' => 'abc123']);

    expect(fn () => Commit::factory()->create(['repository_id' => $repository->id, 'sha' => 'abc123']))
        ->toThrow(\Illuminate\Database\QueryException::class);
});

test('commit casts committed_at to datetime', function () {
    $commit = Commit::factory()->create();

    expect($commit->committed_at)->toBeInstanceOf(\Illuminate\Support\Carbon::class);
});

test('deleting a team cascades to repositories and commits', function () {
    $team = Team::factory()->create();
    $repository = Repository::factory()->create(['team_id' => $team->id]);
    Commit::factory()->count(3)->create(['repository_id' => $repository->id]);

    $team->delete();

    expect(Repository::where('team_id', $team->id)->count())->toBe(0)
        ->and(Commit::where('repository_id', $repository->id)->count())->toBe(0);
});

test('deleting a repository cascades to commits', function () {
    $repository = Repository::factory()->create();
    Commit::factory()->count(3)->create(['repository_id' => $repository->id]);

    $repository->delete();

    expect(Commit::where('repository_id', $repository->id)->count())->toBe(0);
});
