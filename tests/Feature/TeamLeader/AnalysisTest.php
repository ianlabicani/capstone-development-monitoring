<?php

use App\Enums\UserStoryStatus;
use App\Jobs\GenerateUserStoriesJob;
use App\Jobs\MatchStoriesToCommitsJob;
use App\Models\Commit;
use App\Models\Repository;
use App\Models\Team;
use App\Models\TeamDocument;
use App\Models\User;
use App\Models\UserStory;
use App\Services\StoryMatchingService;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->seed(RoleAndPermissionSeeder::class);
    $this->user = User::factory()->teamLeader()->create();
    $this->team = Team::factory()->create(['user_id' => $this->user->id]);
    Storage::fake('local');
});

// --- Show ---

test('team leader can view analysis page', function () {
    $this->actingAs($this->user)
        ->get(route('team-leader.analysis.show'))
        ->assertOk()
        ->assertSee('Project Analysis');
});

test('team leader without team is redirected', function () {
    $user = User::factory()->teamLeader()->create();

    $this->actingAs($user)
        ->get(route('team-leader.analysis.show'))
        ->assertRedirect(route('team-leader.team.create'));
});

test('analysis page shows progress when approved stories exist', function () {
    UserStory::factory()->covered()->create(['team_id' => $this->team->id]);
    UserStory::factory()->approved()->create(['team_id' => $this->team->id]);

    $this->actingAs($this->user)
        ->get(route('team-leader.analysis.show'))
        ->assertOk()
        ->assertSee('50%')
        ->assertSee('Development Progress');
});

// --- Upload Document ---

test('team leader can upload a document', function () {
    $file = UploadedFile::fake()->create('sop.pdf', 500, 'application/pdf');

    $this->actingAs($this->user)
        ->post(route('team-leader.analysis.upload-document'), [
            'document' => $file,
            'slot' => 1,
        ])
        ->assertRedirect()
        ->assertSessionHas('success');

    $this->assertDatabaseHas('team_documents', [
        'team_id' => $this->team->id,
        'slot' => 1,
        'original_name' => 'sop.pdf',
    ]);
});

test('upload replaces existing document in same slot', function () {
    $existing = TeamDocument::factory()->create([
        'team_id' => $this->team->id,
        'slot' => 1,
        'file_path' => 'team-documents/old.pdf',
    ]);
    Storage::disk('local')->put('team-documents/old.pdf', 'old content');

    $file = UploadedFile::fake()->create('new-sop.pdf', 300, 'application/pdf');

    $this->actingAs($this->user)
        ->post(route('team-leader.analysis.upload-document'), [
            'document' => $file,
            'slot' => 1,
        ])
        ->assertRedirect();

    expect(TeamDocument::where('team_id', $this->team->id)->where('slot', 1)->count())->toBe(1);
    $this->assertDatabaseMissing('team_documents', ['id' => $existing->id]);
});

test('upload marks completed analysis as stale', function () {
    $this->team->update(['analysis_status' => 'completed']);
    UserStory::factory()->approved()->create(['team_id' => $this->team->id]);

    $file = UploadedFile::fake()->create('new.pdf', 200, 'application/pdf');

    $this->actingAs($this->user)
        ->post(route('team-leader.analysis.upload-document'), [
            'document' => $file,
            'slot' => 1,
        ]);

    expect($this->team->fresh()->analysis_status)->toBe('stale');
    expect(UserStory::where('team_id', $this->team->id)->first()->status)->toBe(UserStoryStatus::Outdated);
});

test('upload rejects non-pdf files', function () {
    $file = UploadedFile::fake()->create('doc.docx', 200, 'application/msword');

    $this->actingAs($this->user)
        ->post(route('team-leader.analysis.upload-document'), [
            'document' => $file,
            'slot' => 1,
        ])
        ->assertSessionHasErrors('document');
});

test('upload rejects files over 10mb', function () {
    $file = UploadedFile::fake()->create('big.pdf', 11000, 'application/pdf');

    $this->actingAs($this->user)
        ->post(route('team-leader.analysis.upload-document'), [
            'document' => $file,
            'slot' => 1,
        ])
        ->assertSessionHasErrors('document');
});

test('upload rejects invalid slot', function () {
    $file = UploadedFile::fake()->create('doc.pdf', 200, 'application/pdf');

    $this->actingAs($this->user)
        ->post(route('team-leader.analysis.upload-document'), [
            'document' => $file,
            'slot' => 3,
        ])
        ->assertSessionHasErrors('slot');
});

// --- Delete Document ---

test('team leader can delete a document', function () {
    $doc = TeamDocument::factory()->create([
        'team_id' => $this->team->id,
        'file_path' => 'team-documents/test.pdf',
    ]);
    Storage::disk('local')->put('team-documents/test.pdf', 'content');

    $this->actingAs($this->user)
        ->delete(route('team-leader.analysis.delete-document', $doc))
        ->assertRedirect()
        ->assertSessionHas('success');

    $this->assertDatabaseMissing('team_documents', ['id' => $doc->id]);
    Storage::disk('local')->assertMissing('team-documents/test.pdf');
});

test('team leader cannot delete another teams document', function () {
    $otherTeam = Team::factory()->create();
    $doc = TeamDocument::factory()->create(['team_id' => $otherTeam->id]);

    $this->actingAs($this->user)
        ->delete(route('team-leader.analysis.delete-document', $doc))
        ->assertForbidden();
});

// --- Generate ---

test('team leader can trigger generation', function () {
    Queue::fake();
    TeamDocument::factory()->create(['team_id' => $this->team->id]);

    $this->actingAs($this->user)
        ->post(route('team-leader.analysis.generate'))
        ->assertRedirect()
        ->assertSessionHas('success');

    Queue::assertPushed(GenerateUserStoriesJob::class, function ($job) {
        return $job->team->id === $this->team->id;
    });
});

test('generate fails without documents', function () {
    $this->actingAs($this->user)
        ->post(route('team-leader.analysis.generate'))
        ->assertRedirect()
        ->assertSessionHasErrors('generate');
});

test('generate fails when already processing', function () {
    $this->team->update(['analysis_status' => 'processing']);
    TeamDocument::factory()->create(['team_id' => $this->team->id]);

    $this->actingAs($this->user)
        ->post(route('team-leader.analysis.generate'))
        ->assertRedirect()
        ->assertSessionHasErrors('generate');
});

// --- Update Story ---

test('team leader can update a story', function () {
    $story = UserStory::factory()->create(['team_id' => $this->team->id]);

    $this->actingAs($this->user)
        ->patch(route('team-leader.analysis.update-story', $story), [
            'title' => 'Updated Title',
            'description' => 'Updated description',
        ])
        ->assertRedirect()
        ->assertSessionHas('success');

    expect($story->fresh()->title)->toBe('Updated Title');
});

test('team leader cannot update another teams story', function () {
    $otherTeam = Team::factory()->create();
    $story = UserStory::factory()->create(['team_id' => $otherTeam->id]);

    $this->actingAs($this->user)
        ->patch(route('team-leader.analysis.update-story', $story), [
            'title' => 'Hack',
        ])
        ->assertForbidden();
});

test('story title is required', function () {
    $story = UserStory::factory()->create(['team_id' => $this->team->id]);

    $this->actingAs($this->user)
        ->patch(route('team-leader.analysis.update-story', $story), [
            'title' => '',
        ])
        ->assertSessionHasErrors('title');
});

// --- Approve Story ---

test('team leader can approve a draft story', function () {
    $story = UserStory::factory()->create([
        'team_id' => $this->team->id,
        'status' => UserStoryStatus::Draft,
    ]);

    $this->actingAs($this->user)
        ->post(route('team-leader.analysis.approve-story', $story))
        ->assertRedirect()
        ->assertSessionHas('success');

    expect($story->fresh()->status)->toBe(UserStoryStatus::Approved);
});

test('team leader can unapprove an approved story', function () {
    $story = UserStory::factory()->approved()->create(['team_id' => $this->team->id]);

    $this->actingAs($this->user)
        ->post(route('team-leader.analysis.approve-story', $story))
        ->assertRedirect();

    expect($story->fresh()->status)->toBe(UserStoryStatus::Draft);
});

test('team leader cannot approve another teams story', function () {
    $otherTeam = Team::factory()->create();
    $story = UserStory::factory()->create(['team_id' => $otherTeam->id]);

    $this->actingAs($this->user)
        ->post(route('team-leader.analysis.approve-story', $story))
        ->assertForbidden();
});

// --- Delete Story ---

test('team leader can delete a story', function () {
    $story = UserStory::factory()->create(['team_id' => $this->team->id]);

    $this->actingAs($this->user)
        ->delete(route('team-leader.analysis.delete-story', $story))
        ->assertRedirect()
        ->assertSessionHas('success');

    $this->assertDatabaseMissing('user_stories', ['id' => $story->id]);
});

test('team leader cannot delete another teams story', function () {
    $otherTeam = Team::factory()->create();
    $story = UserStory::factory()->create(['team_id' => $otherTeam->id]);

    $this->actingAs($this->user)
        ->delete(route('team-leader.analysis.delete-story', $story))
        ->assertForbidden();
});

// --- Story Matching Service ---

test('matching service marks stories as covered when keywords match', function () {
    $repo = Repository::factory()->create(['team_id' => $this->team->id]);
    Commit::factory()->create([
        'repository_id' => $repo->id,
        'message' => 'Implement user authentication login flow',
    ]);

    $story = UserStory::factory()->approved()->create([
        'team_id' => $this->team->id,
        'keywords' => ['authentication', 'login'],
    ]);

    $matcher = new StoryMatchingService;
    $matcher->matchForTeam($this->team);

    expect($story->fresh()->is_covered)->toBeTrue();
});

test('matching service marks stories as gap when no keywords match', function () {
    $repo = Repository::factory()->create(['team_id' => $this->team->id]);
    Commit::factory()->create([
        'repository_id' => $repo->id,
        'message' => 'Fix CSS styling issues',
    ]);

    $story = UserStory::factory()->approved()->create([
        'team_id' => $this->team->id,
        'keywords' => ['payment', 'checkout'],
    ]);

    $matcher = new StoryMatchingService;
    $matcher->matchForTeam($this->team);

    expect($story->fresh()->is_covered)->toBeFalse();
});

test('matching service handles empty keywords', function () {
    $repo = Repository::factory()->create(['team_id' => $this->team->id]);
    Commit::factory()->create(['repository_id' => $repo->id]);

    $story = UserStory::factory()->approved()->create([
        'team_id' => $this->team->id,
        'keywords' => [],
    ]);

    $matcher = new StoryMatchingService;
    $matcher->matchForTeam($this->team);

    expect($story->fresh()->is_covered)->toBeFalse();
});

test('matching service skips non-approved stories', function () {
    $repo = Repository::factory()->create(['team_id' => $this->team->id]);
    Commit::factory()->create([
        'repository_id' => $repo->id,
        'message' => 'Implement login',
    ]);

    $draft = UserStory::factory()->create([
        'team_id' => $this->team->id,
        'keywords' => ['login'],
        'status' => UserStoryStatus::Draft,
    ]);

    $matcher = new StoryMatchingService;
    $matcher->matchForTeam($this->team);

    expect($draft->fresh()->is_covered)->toBeFalse();
});

// --- Authorization ---

test('guest cannot access analysis routes', function () {
    $this->get(route('team-leader.analysis.show'))->assertRedirect(route('login'));
    $this->post(route('team-leader.analysis.upload-document'))->assertRedirect(route('login'));
    $this->post(route('team-leader.analysis.generate'))->assertRedirect(route('login'));
});

test('non-team-leader cannot access analysis routes', function () {
    $adviser = User::factory()->technicalAdviser()->create();

    $this->actingAs($adviser)
        ->get(route('team-leader.analysis.show'))
        ->assertForbidden();
});

// --- Repo Sync triggers matching ---

test('repository sync dispatches matching job when approved stories exist', function () {
    Queue::fake();
    $repo = Repository::factory()->create(['team_id' => $this->team->id]);
    UserStory::factory()->approved()->create(['team_id' => $this->team->id]);

    $this->mock(\App\Services\GitHubService::class, function ($mock) {
        $mock->shouldReceive('fetchCommits')->andReturn([]);
    });

    $this->actingAs($this->user)
        ->post(route('team-leader.repositories.sync', $repo))
        ->assertRedirect();

    Queue::assertPushed(MatchStoriesToCommitsJob::class);
});

test('repository sync does not dispatch matching when no approved stories', function () {
    Queue::fake();
    $repo = Repository::factory()->create(['team_id' => $this->team->id]);

    $this->mock(\App\Services\GitHubService::class, function ($mock) {
        $mock->shouldReceive('fetchCommits')->andReturn([]);
    });

    $this->actingAs($this->user)
        ->post(route('team-leader.repositories.sync', $repo))
        ->assertRedirect();

    Queue::assertNotPushed(MatchStoriesToCommitsJob::class);
});
