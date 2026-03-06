<?php

namespace Database\Seeders;

use App\Enums\Permission;
use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission as PermissionModel;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Seed roles and permissions for the system.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        foreach (Permission::cases() as $permission) {
            PermissionModel::findOrCreate($permission->value, 'web');
        }

        foreach (UserRole::cases() as $role) {
            $createdRole = Role::findOrCreate($role->value, 'web');

            $permissionValues = array_map(
                fn (Permission $p): string => $p->value,
                $role->permissions(),
            );

            $createdRole->syncPermissions($permissionValues);
        }
    }
}
