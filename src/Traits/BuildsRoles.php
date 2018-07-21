<?php

namespace CrixuAMG\Permissions\Traits;
use Illuminate\Database\Eloquent\Model;

/**
 * Trait BuildsRoles
 * @package CrixuAMG\Permissions\Traits
 */
trait BuildsRoles
{
    use BuildsPermissions;

    /**
     * @param BaseRole       $role
     * @param BasePermission $permission
     */
    public function givePermission(Model $role, Model $permission)
    {
        // Check extends

        // First check if the role does not have the permission already
        if (!$role->hasPermission($permission)) {
            // The role does not have the permission yet, add it now
            $role->permissions()->save($permission);
        }
    }
}
