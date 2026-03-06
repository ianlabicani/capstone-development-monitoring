<?php

use App\Models\Commit;
use App\Models\Repository;
use App\Models\Team;
use App\Models\User;

describe('Team Leaderboard', function () {
    test('team leaderboard page is accessible', function () {
        $response = $this->get(route('leaderboard.teams'));
        $response->assertStatus(200);
        $response->assertViewIs('leaderboard.teams');
    });

    test('teams are ranked by weekly commits by default', function () {
        $adviser = User::factory()->create();
        $tl1 = User::factory()->create(['created_by' => $adviser->id]);
        $tl2 = User::factory()->create(['created_by' => $adviser->id]);

        $team1 = Team::factory()->create(['user_id' => $tl1->id]);
        $team2 = Team::factory()->create(['user_id' => $tl2->id]);

        $repo1 = Repository::factory()->create(['team_id' => $team1->id]);
        $repo2 = Repository::factory()->create(['team_id' => $team2->id]);

        Commit::factory(5)->create(['repository_id' => $repo1->id, 'committed_at' => now()]);
        Commit::factory(2)->create(['repository_id' => $repo2->id, 'committed_at' => now()]);

        $response = $this->get(route('leaderboard.teams', ['period' => 'week']));

        $teams = $response->viewData('teams');
        expect($teams->first()->slug)->toEqual($team1->slug);
        expect($teams->last()->slug)->toEqual($team2->slug);
    });

    test('teams can be filtered by adviser', function () {
        $adviser1 = User::factory()->create();
        $adviser2 = User::factory()->create();

        $tl1 = User::factory()->create(['created_by' => $adviser1->id]);
        $tl2 = User::factory()->create(['created_by' => $adviser2->id]);

        $team1 = Team::factory()->create(['user_id' => $tl1->id]);
        $team2 = Team::factory()->create(['user_id' => $tl2->id]);

        $repo1 = Repository::factory()->create(['team_id' => $team1->id]);
        $repo2 = Repository::factory()->create(['team_id' => $team2->id]);

        Commit::factory(3)->create(['repository_id' => $repo1->id]);
        Commit::factory(3)->create(['repository_id' => $repo2->id]);

        $response = $this->get(route('leaderboard.teams', ['adviser' => $adviser1->id]));

        $teams = $response->viewData('teams');
        expect($teams->count())->toBe(1);
        expect($teams->first()->slug)->toEqual($team1->slug);
    });

    test('teams without commits are not shown', function () {
        $adviser = User::factory()->create();
        $tl = User::factory()->create(['created_by' => $adviser->id]);

        $team1 = Team::factory()->create(['user_id' => $tl->id]);
        $team2 = Team::factory()->create(['user_id' => $tl->id]);

        $repo1 = Repository::factory()->create(['team_id' => $team1->id]);
        Repository::factory()->create(['team_id' => $team2->id]);

        Commit::factory(3)->create(['repository_id' => $repo1->id]);

        $response = $this->get(route('leaderboard.teams'));

        $teams = $response->viewData('teams');
        expect($teams->count())->toBe(1);
        expect($teams->first()->slug)->toEqual($team1->slug);
    });

    test('period filter works correctly', function () {
        $adviser = User::factory()->create();
        $tl = User::factory()->create(['created_by' => $adviser->id]);
        $team = Team::factory()->create(['user_id' => $tl->id]);
        $repo = Repository::factory()->create(['team_id' => $team->id]);

        Commit::factory(5)->create(['repository_id' => $repo->id, 'committed_at' => now()]);
        Commit::factory(3)->create(['repository_id' => $repo->id, 'committed_at' => now()->subDays(5)]);

        $weekResponse = $this->get(route('leaderboard.teams', ['period' => 'week']));
        $monthResponse = $this->get(route('leaderboard.teams', ['period' => 'month']));
        $allResponse = $this->get(route('leaderboard.teams', ['period' => 'all']));

        expect($weekResponse->viewData('teams')->first()->this_week_commits)->toBe(5);
        expect($monthResponse->viewData('teams')->first()->this_month_commits)->toBe(8);
        expect($allResponse->viewData('teams')->first()->all_time_commits)->toBe(8);
    });
});

describe('Contributor Leaderboard', function () {
    test('contributor leaderboard page is accessible', function () {
        $response = $this->get(route('leaderboard.contributors'));
        $response->assertStatus(200);
        $response->assertViewIs('leaderboard.contributors');
    });

    test('contributors are ranked by commit count', function () {
        $repo = Repository::factory()->create();

        Commit::factory(5)->create(['repository_id' => $repo->id, 'author_login' => 'alice', 'author_email' => 'alice@example.com', 'author_name' => 'Alice']);
        Commit::factory(3)->create(['repository_id' => $repo->id, 'author_login' => 'bob', 'author_email' => 'bob@example.com', 'author_name' => 'Bob']);

        $response = $this->get(route('leaderboard.contributors', ['period' => 'all']));

        $contributors = $response->viewData('contributors');
        expect($contributors->first()->author_login)->toEqual('alice');
        expect($contributors->last()->author_login)->toEqual('bob');
    });

    test('period filtering works for contributors', function () {
        $repo = Repository::factory()->create();

        Commit::factory(3)->create(['repository_id' => $repo->id, 'author_login' => 'alice', 'author_email' => 'alice@example.com', 'author_name' => 'Alice', 'committed_at' => now()]);
        Commit::factory(2)->create(['repository_id' => $repo->id, 'author_login' => 'bob', 'author_email' => 'bob@example.com', 'author_name' => 'Bob', 'committed_at' => now()]);
        Commit::factory(3)->create(['repository_id' => $repo->id, 'author_login' => 'bob', 'author_email' => 'bob@example.com', 'author_name' => 'Bob', 'committed_at' => now()->subDays(30)]);

        $weekResponse = $this->get(route('leaderboard.contributors', ['period' => 'week']));
        $allResponse = $this->get(route('leaderboard.contributors', ['period' => 'all']));

        $weekContributors = $weekResponse->viewData('contributors');
        expect($weekContributors->first()->author_login)->toEqual('alice');

        $allContributors = $allResponse->viewData('contributors');
        expect($allContributors->first()->author_login)->toEqual('bob');
    });

    test('contributors with null author_login are excluded', function () {
        $repo = Repository::factory()->create();

        Commit::factory(5)->create(['repository_id' => $repo->id, 'author_login' => 'alice', 'author_email' => 'alice@example.com', 'author_name' => 'Alice', 'committed_at' => now()]);
        Commit::factory(3)->create(['repository_id' => $repo->id, 'author_login' => null, 'author_email' => 'unknown@example.com', 'author_name' => 'Unknown', 'committed_at' => now()]);

        $response = $this->get(route('leaderboard.contributors'));

        $contributors = $response->viewData('contributors');
        expect($contributors->count())->toBe(1);
        expect($contributors->first()->author_login)->toEqual('alice');
    });
});
