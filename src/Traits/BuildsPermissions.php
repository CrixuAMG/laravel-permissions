<?php

namespace CrixuAMG\Permissions\Traits;

use CrixuAMG\Permissions\Services\BasePermission;
use CrixuAMG\Permissions\Services\BaseRole;
use Illuminate\Database\Eloquent\Model;

/**
 * Trait BuildsPermissions
 * @package CrixuAMG\Permissions\Traits
 */
trait BuildsPermissions
{
    /**
     * @var string|null
     */
    protected $guard;

    /**
     * @param mixed $guard
     */
    public function setGuard($guard)
    {
        $this->guard = $guard;
    }

    /**
     * @param string $permission
     *
     * @return Model
     */
    public function permission(string $permission, string $guardName = null)
    {
        return config('permissions.models.permissions')::firstOrCreate(array_merge(
            [
                'name'       => $permission,
                'guard_name' => $guardName ?? $this->guard,
            ]
        ));
    }

    /**
     * @param BaseRole       $role
     * @param BasePermission $permission
     * @param string|null    $minimumRole
     * @param string[]       ...$roleExceptions
     */
    public function givePermission(BaseRole $role, BasePermission $permission, string $minimumRole = null, string ...$roleExceptions)
    {
        // First check if the role does not have the permission already
        if (!$role->hasPermissionTo($permission)) {
            // The role does not have the permission yet, add it now
            $role->permissions()->save($permission);
        }
    }

    /**
     * @param string $permission
     *
     * @return mixed
     */
    public function hasPermission(string $permission)
    {
        return $this->permissions->contains('name', $permission);
    }
}
