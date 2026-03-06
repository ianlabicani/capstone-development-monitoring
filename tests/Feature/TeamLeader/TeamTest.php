<?php

use App\Enums\UserRole;
use App\Models\Team;
use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;

beforeEach(function () {
    $this->seed(RoleAndPermissionSeeder::class);
    $this->user = User::factory()->create();
    $this->user->assignRole(UserRole::TeamLeader);
});

test('team leader can view team create page', function () {
    $this->actingAs($this->user)
        ->get(route('team-leader.team.create'))
        ->assertOk();
});

test('team leader is redirected to team show if team exists', function () {
    Team::factory()->create(['user_id' => $this->user->id]);

    $this->actingAs($this->user)
        ->get(route('team-leader.team.create'))
        ->assertRedirect(route('team-leader.team.show'));
});

test('team leader can create a team', function () {
    $this->actingAs($this->user)
        ->post(route('team-leader.team.store'), [
            'name' => 'Team Alpha',
            'description' => 'Our capstone project',
        ])
        ->assertRedirect(route('team-leader.team.show'));

    $this->assertDatabaseHas('teams', [
        'user_id' => $this->user->id,
        'name' => 'Team Alpha',
        'slug' => 'team-alpha',
        'description' => 'Our capstone project',
    ]);
});

test('team leader cannot create a second team', function () {
    Team::factory()->create(['user_id' => $this->user->id]);

    $this->actingAs($this->user)
        ->post(route('team-leader.team.store'), [
            'name' => 'Another Team',
        ])
        ->assertRedirect(route('team-leader.team.show'));

    expect(Team::where('user_id', $this->user->id)->count())->toBe(1);
});

test('team leader can view their team', function () {
    Team::factory()->create(['user_id' => $this->user->id, 'name' => 'Team Alpha']);

    $this->actingAs($this->user)
        ->get(route('team-leader.team.show'))
        ->assertOk()
        ->assertSee('Team Alpha');
});

test('team leader without team is redirected to create', function () {
    $this->actingAs($this->user)
        ->get(route('team-leader.team.show'))
        ->assertRedirect(route('team-leader.team.create'));
});

test('team leader can update their team', function () {
    Team::factory()->create(['user_id' => $this->user->id, 'name' => 'Old Name']);

    $this->actingAs($this->user)
        ->patch(route('team-leader.team.update'), [
            'name' => 'New Name',
            'description' => 'Updated description',
        ])
        ->assertRedirect(route('team-leader.team.show'));

    $this->assertDatabaseHas('teams', [
        'user_id' => $this->user->id,
        'name' => 'New Name',
        'slug' => 'new-name',
    ]);
});

test('team name is required', function () {
    $this->actingAs($this->user)
        ->post(route('team-leader.team.store'), ['name' => ''])
        ->assertSessionHasErrors('name');
});

test('team name must be unique', function () {
    Team::factory()->create(['name' => 'Taken Name', 'slug' => 'taken-name']);

    $this->actingAs($this->user)
        ->post(route('team-leader.team.store'), ['name' => 'Taken Name'])
        ->assertSessionHasErrors('name');
});

test('guest cannot access team routes', function () {
    $this->get(route('team-leader.team.create'))->assertRedirect(route('login'));
    $this->post(route('team-leader.team.store'))->assertRedirect(route('login'));
    $this->get(route('team-leader.team.show'))->assertRedirect(route('login'));
});

test('user without team leader role cannot access team routes', function () {
    $nonTl = User::factory()->create();
    $nonTl->assignRole(UserRole::TechnicalAdviser);

    $this->actingAs($nonTl)
        ->get(route('team-leader.team.create'))
        ->assertForbidden();
});
