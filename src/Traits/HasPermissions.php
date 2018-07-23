<?php

namespace CrixuAMG\Permissions\Traits;
use CrixuAMG\Permissions\Services\BasePermission;
use CrixuAMG\Permissions\Services\BaseRole;

/**
 * Trait HasPermissions
 * @package CrixuAMG\Permissions\Traits
 */
trait HasPermissions
{
    /**
     * @return mixed
     */
    public function permissions()
    {
        return $this->morphToMany(
            config('permissions.models.permissions'),
            str_singular(config('permissions.tables.permissionables')),
            config('permissions.tables.permissionables')
        );
    }

    /**
     * @param mixed ...$permissions
     *
     * @return bool
     */
    public function hasPermission(...$permissions): bool
    {
        if (is_string($permissions) && false !== strpos($permissions, '|')) {
            $permissions = $this->parsePipedList($permissions);
        }

        if (is_string($permissions)) {
            return $this->permissions->contains('name', $permissions);
        }

        if ($permissions instanceof BaseRole) {
            return $this->permissions->contains('id', $permissions->id);
        }

        if (is_array($permissions)) {
            foreach ($permissions as $permission) {
                if ($this->hasPermission($permission)) {
                    return true;
                }
            }

            return false;
        }
    }
}
