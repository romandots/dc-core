<?php
/**
 * File: RolesTableSeeder.php
 * Author: Roman Dots <ram.d.kreiz@gmail.com>
 * Date: 2019-07-22
 * Copyright (c) 2019
 */

declare(strict_types=1);

use Illuminate\Database\Seeder;

/**
 * Class RolesTableSeeder
 */
class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run(): void
    {
        $this->runUser();
    }

    private function runUser(): void
    {
        $roles = \App\Services\Permissions\UserRoles::PERMISSIONS_MAP;
        $descriptions = \App\Services\Permissions\UserRoles::getInitialDescriptions();

        $this->createRoles($roles, $descriptions);
    }

    /**
     * @param array $roles
     * @param array $descriptions
     */
    private function createRoles(array $roles, array $descriptions): void
    {
        foreach ($roles as $role => $permissions) {
            /* @var \Spatie\Permission\Models\Role $roleModel */
            try {
                $roleModel = \Spatie\Permission\Models\Role::findByName($role, 'api');
                $roleModel->syncPermissions($permissions);
            } catch (\Spatie\Permission\Exceptions\RoleDoesNotExist $e) {
                $roleModel = \Spatie\Permission\Models\Role::create([
                    'name' => $role,
                    'description' => $descriptions[$role] ?? null,
                    'guard_name' => 'api'
                ]);
                $roleModel->givePermissionTo($permissions);
            }
        }
    }
}
