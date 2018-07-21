<?php

namespace CrixuAMG\Permissions\Services;

use CrixuAMG\Permissions\Models\Role;
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

        foreach ($this->permissionsForRoles as $role => $assignedPermissions) {
            $role = config('permissions.models.roles')::whereName($role)->first();

            $role->permissions()->detach();

            foreach ($assignedPermissions as $permission) {
                $role->permissions()->attach($permission);
            }

            $users->each(function ($user) use ($role) {
                if ($user->roles->isEmpty()) {
                    $user->syncRoles($role);
                }
            });
        }
    }
}