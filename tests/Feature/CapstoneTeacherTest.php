<?php

use App\Enums\UserRole;
use App\Models\Team;
use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;

beforeEach(function () {
    $this->seed(RoleAndPermissionSeeder::class);
});

describe('Capstone Teacher Features', function () {
    describe('Dashboard', function () {
        it('shows dashboard with all teams for capstone teachers', function () {
            $teacher = User::factory()->capstoneTeacher()->create();
            Team::factory()->count(3)->create();

            $response = $this->actingAs($teacher)->get(route('capstone-teacher.dashboard'));

            expect($response->status())->toBe(200);
            $response->assertSee('Team Monitoring');
        });

        it('requires authentication for dashboard', function () {
            $response = $this->get(route('capstone-teacher.dashboard'));

            expect($response->status())->toBe(302);
            $response->assertRedirect('/login');
        });

        it('denies access to non-capstone teachers', function () {
            $teamLeader = User::factory()->teamLeader()->create();

            $response = $this->actingAs($teamLeader)->get(route('capstone-teacher.dashboard'));

            expect($response->status())->toBe(403);
        });
    });

    describe('Team Detail View', function () {
        it('shows team progress details for capstone teachers', function () {
            $teacher = User::factory()->capstoneTeacher()->create();
            $team = Team::factory()->withRepositories(2)->create();

            $response = $this->actingAs($teacher)->get(route('capstone-teacher.team.show', $team));

            expect($response->status())->toBe(200);
            $response->assertSee($team->name);
            $response->assertSee('Team progress and activity');
        });

        it('displays team statistics correctly', function () {
            $teacher = User::factory()->capstoneTeacher()->create();
            $team = Team::factory()->withRepositories(1)->create();

            $response = $this->actingAs($teacher)->get(route('capstone-teacher.team.show', $team));

            expect($response->status())->toBe(200);
            $response->assertSee('Total Commits');
            $response->assertSee('Contributors');
        });
    });

    describe('Technical Adviser Management (CRUD)', function () {
        it('lists all technical advisers for capstone teachers', function () {
            $teacher = User::factory()->capstoneTeacher()->create();
            User::factory()->technicalAdviser()->count(2)->create();

            $response = $this->actingAs($teacher)->get(route('capstone-teacher.technical-advisers.index'));

            expect($response->status())->toBe(200);
            $response->assertSee('Technical Advisers');
        });

        it('shows create form for new technical adviser', function () {
            $teacher = User::factory()->capstoneTeacher()->create();

            $response = $this->actingAs($teacher)->get(route('capstone-teacher.technical-advisers.create'));

            expect($response->status())->toBe(200);
            $response->assertSee('Add Technical Adviser');
        });

        it('creates new technical adviser with valid data', function () {
            $teacher = User::factory()->capstoneTeacher()->create();

            $response = $this->actingAs($teacher)->post(
                route('capstone-teacher.technical-advisers.store'),
                [
                    'name' => 'Jane Doe',
                    'email' => 'jane@example.com',
                ]
            );

            expect($response->status())->toBe(302);
            expect(User::where('email', 'jane@example.com')->first())
                ->not->toBeNull()
                ->and(User::whereEmail('jane@example.com')->first()->hasRole(UserRole::TechnicalAdviser->value))->toBeTrue();
        });

        it('validates required fields when creating adviser', function () {
            $teacher = User::factory()->capstoneTeacher()->create();

            $response = $this->actingAs($teacher)->post(
                route('capstone-teacher.technical-advisers.store'),
                []
            );

            expect($response->status())->toBe(302);
            $response->assertSessionHasErrors(['name', 'email']);
        });

        it('shows technical adviser details', function () {
            $teacher = User::factory()->capstoneTeacher()->create();
            $adviser = User::factory()->technicalAdviser()->create();

            $response = $this->actingAs($teacher)->get(route('capstone-teacher.technical-advisers.show', $adviser));

            expect($response->status())->toBe(200);
            $response->assertSee($adviser->name);
            $response->assertSee($adviser->email);
        });

        it('shows edit form for technical adviser', function () {
            $teacher = User::factory()->capstoneTeacher()->create();
            $adviser = User::factory()->technicalAdviser()->create();

            $response = $this->actingAs($teacher)->get(route('capstone-teacher.technical-advisers.edit', $adviser));

            expect($response->status())->toBe(200);
            $response->assertSee('Edit Technical Adviser');
        });

        it('updates technical adviser with valid data', function () {
            $teacher = User::factory()->capstoneTeacher()->create();
            $adviser = User::factory()->technicalAdviser()->create();

            $response = $this->actingAs($teacher)->patch(
                route('capstone-teacher.technical-advisers.update', $adviser),
                [
                    'name' => 'Updated Name',
                    'email' => 'updated@example.com',
                ]
            );

            expect($response->status())->toBe(302);
            expect($adviser->refresh()->name)->toBe('Updated Name');
            expect($adviser->refresh()->email)->toBe('updated@example.com');
        });

        it('deletes technical adviser', function () {
            $teacher = User::factory()->capstoneTeacher()->create();
            $adviser = User::factory()->technicalAdviser()->create();

            $response = $this->actingAs($teacher)->delete(
                route('capstone-teacher.technical-advisers.destroy', $adviser)
            );

            expect($response->status())->toBe(302);
            expect($adviser->refresh()->deleted_at)->not->toBeNull();
        });

        it('restricts adviser management to capstone teachers with permission', function () {
            $teamLeader = User::factory()->teamLeader()->create();

            $response = $this->actingAs($teamLeader)->get(route('capstone-teacher.technical-advisers.index'));

            expect($response->status())->toBe(403);
        });
    });

    describe('Permissions', function () {
        it('capstone teacher has correct permissions', function () {
            $teacher = User::factory()->capstoneTeacher()->create();

            expect($teacher->can('view dashboard'))->toBeTrue();
            expect($teacher->can('view team progress'))->toBeTrue();
            expect($teacher->can('view commit activity'))->toBeTrue();
            expect($teacher->can('manage team leaders'))->toBeTrue();
        });

        it('denies unauthorized access to capstone teacher routes', function () {
            $publicUser = User::factory()->create();

            $response = $this->actingAs($publicUser)->get(route('capstone-teacher.dashboard'));

            expect($response->status())->toBe(403);
        });
    });
});
