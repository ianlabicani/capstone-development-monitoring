<?php

use App\Enums\Permission;
use App\Enums\UserRole;
use App\Models\User;
use Spatie\Permission\Models\Role;

it('seeds all roles', function () {
    $this->seed(\Database\Seeders\RoleAndPermissionSeeder::class);

    foreach (UserRole::cases() as $role) {
        expect(Role::findByName($role->value, 'web'))->not->toBeNull();
    }
});

it('seeds all permissions', function () {
    $this->seed(\Database\Seeders\RoleAndPermissionSeeder::class);

    foreach (Permission::cases() as $permission) {
        expect(\Spatie\Permission\Models\Permission::findByName($permission->value, 'web'))->not->toBeNull();
    }
});

it('assigns correct permissions to admin role', function () {
    $this->seed(\Database\Seeders\RoleAndPermissionSeeder::class);

    $role = Role::findByName(UserRole::Admin->value, 'web');

    expect($role->permissions->pluck('name')->toArray())
        ->toEqualCanonicalizing(array_map(fn ($p) => $p->value, Permission::cases()));
});

it('assigns correct permissions to capstone teacher role', function () {
    $this->seed(\Database\Seeders\RoleAndPermissionSeeder::class);

    $role = Role::findByName(UserRole::CapstoneTeacher->value, 'web');
    $expected = array_map(fn ($p) => $p->value, UserRole::CapstoneTeacher->permissions());

    expect($role->permissions->pluck('name')->toArray())
        ->toEqualCanonicalizing($expected);
});

it('assigns correct permissions to technical adviser role', function () {
    $this->seed(\Database\Seeders\RoleAndPermissionSeeder::class);

    $role = Role::findByName(UserRole::TechnicalAdviser->value, 'web');
    $expected = array_map(fn ($p) => $p->value, UserRole::TechnicalAdviser->permissions());

    expect($role->permissions->pluck('name')->toArray())
        ->toEqualCanonicalizing($expected);
});

it('assigns correct permissions to team leader role', function () {
    $this->seed(\Database\Seeders\RoleAndPermissionSeeder::class);

    $role = Role::findByName(UserRole::TeamLeader->value, 'web');
    $expected = array_map(fn ($p) => $p->value, UserRole::TeamLeader->permissions());

    expect($role->permissions->pluck('name')->toArray())
        ->toEqualCanonicalizing($expected);
});

it('allows a user to have multiple roles', function () {
    $this->seed(\Database\Seeders\RoleAndPermissionSeeder::class);

    $user = User::factory()->create();
    $user->assignRole(UserRole::Admin);
    $user->assignRole(UserRole::TeamLeader);

    expect($user->getRoleNames())->toHaveCount(2)
        ->and($user->hasRole(UserRole::Admin))->toBeTrue()
        ->and($user->hasRole(UserRole::TeamLeader))->toBeTrue();
});

it('creates admin user via factory state', function () {
    $this->seed(\Database\Seeders\RoleAndPermissionSeeder::class);

    $user = User::factory()->admin()->create();

    expect($user->hasRole(UserRole::Admin))->toBeTrue();
});

it('creates capstone teacher user via factory state', function () {
    $this->seed(\Database\Seeders\RoleAndPermissionSeeder::class);

    $user = User::factory()->capstoneTeacher()->create();

    expect($user->hasRole(UserRole::CapstoneTeacher))->toBeTrue();
});

it('creates technical adviser user via factory state', function () {
    $this->seed(\Database\Seeders\RoleAndPermissionSeeder::class);

    $user = User::factory()->technicalAdviser()->create();

    expect($user->hasRole(UserRole::TechnicalAdviser))->toBeTrue();
});

it('creates team leader user via factory state', function () {
    $this->seed(\Database\Seeders\RoleAndPermissionSeeder::class);

    $user = User::factory()->teamLeader()->create();

    expect($user->hasRole(UserRole::TeamLeader))->toBeTrue();
});

it('admin user can do everything via gate', function () {
    $this->seed(\Database\Seeders\RoleAndPermissionSeeder::class);

    $admin = User::factory()->admin()->create();

    foreach (Permission::cases() as $permission) {
        expect($admin->can($permission->value))->toBeTrue();
    }
});

it('team leader cannot manage system', function () {
    $this->seed(\Database\Seeders\RoleAndPermissionSeeder::class);

    $teamLeader = User::factory()->teamLeader()->create();

    expect($teamLeader->can(Permission::ManageSystem->value))->toBeFalse()
        ->and($teamLeader->can(Permission::RegisterRepository->value))->toBeTrue();
});

it('seeds all user accounts via database seeder', function () {
    $this->seed(\Database\Seeders\DatabaseSeeder::class);

    expect(User::where('email', 'admin@example.com')->exists())->toBeTrue()
        ->and(User::where('email', 'teacher@example.com')->exists())->toBeTrue()
        ->and(User::where('email', 'adviser@example.com')->exists())->toBeTrue()
        ->and(User::where('email', 'teamleader@example.com')->exists())->toBeTrue();
});
