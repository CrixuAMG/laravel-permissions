<?php

namespace CrixuAMG\Permissions\Services;

use CrixuAMG\Permissions\Traits\BuildsRoles;
use Illuminate\Database\Seeder;

/**
 * Class AbstractPermissionSeeder
 * @package CrixuAMG\Permissions\Services
 */
abstract class AbstractPermissionSeeder extends Seeder
{
    use BuildsRoles;
    /**
     * @var
     */
    protected $permissionsForRoles;
    /**
     * @var
     */
    protected $roles;

    /**
     * AbstractPermissionSeeder constructor.
     */
    public function __construct()
    {
        $this->setup();
    }

    /**
     *
     */
    private function setup()
    {
        $this->roles = config('permissions.roles');

        foreach ($this->roles as $role) {
            // Make sure it exists before continueing into the seeder
            BaseRole::createRole($role);

            $this->permissionsForRoles[$role] = collect();

            $this->permissionsForRoles[$role]->push(
                $this->addPermission($role, $role)
            );
        }
    }

    /**
     * Create a permission if it's not created already.
     *
     * @param string      $name the name of the permission, which is used in (PROJECT ROOT)/routes/api.php
     * @param string|null $minimumRole
     * @param string      ...$roleExceptions
     */
    protected function addPermission(string $name, string $minimumRole = null, string ...$roleExceptions)
    {
        $permission = $this->permission($name);

        foreach ($this->permissionsForRoles as $role => $assignedPermissions) {
            if (!$minimumRole || empty($roleExceptions)) {
                $assignedPermissions->push($permission);
            }
        }
    }

    /**
     *
     */
    protected function givePermissions()
    {
        $users = config('permissions.user_model')::with('roles')
            ->get();
        $permissionModel = config('permissions.models.permissions');

        foreach ($this->permissionsForRoles as $role => $assignedPermissions) {
            // Get the role model
            $role = config('permissions.models.roles')::whereName($role)->first();

            // Remove the current permissions
            $role->permissions()->detach();

            foreach ($assignedPermissions as $permission) {
                // First check if the role does not have the permission already
                if (!$role->hasPermission($permission)) {
                    $permission = $permission instanceof $permissionModel
                        ? $permission->name
                        : $permission;

                    // The role does not have the permission yet, add it now
                    $role->permissions()->attach(config('permissions.models.permissions')::firstOrCreate([
                        'name'       => sprintf('%s:update', $permission),
                        'guard_name' => config('permissions.guards.default'),
                    ]));
                }
            }

            $users->each(function ($user) use ($role) {
                if ($user->roles->isEmpty()) {
                    $user->syncRoles($role);
                }
            });
        }
    }
}