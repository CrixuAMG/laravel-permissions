<?php

namespace CrixuAMG\Permissions\Traits;

use CrixuAMG\Permissions\Models\Role;
use CrixuAMG\Permissions\Services\BaseRole;

/**
 * Trait HasRoles
 * @package CrixuAMG\Permissions\Traits
 */
trait HasRoles
{
    use HasPermissions;

    /**
     * @return mixed
     */
    public function roles()
    {
        return $this->morphToMany(
            config('permissions.models.roles'),
            str_singular(config('permissions.tables.roleables')),
            config('permissions.tables.roleables')
        );
    }

    /**
     * @param mixed ...$roles
     *
     * @return bool
     */
    public function hasRole(...$roles)
    {
        if (is_string($roles) && false !== strpos($roles, '|')) {
            $roles = $this->parsePipedList($roles);
        }

        if (is_string($roles)) {
            return $this->roles->contains('name', $roles);
        }

        if ($roles instanceof Role) {
            return $this->roles->contains('id', $roles->id);
        }

        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }

            return false;
        }
    }

    /**
     * @param mixed ...$roles
     *
     * @return HasRoles
     */
    public function syncRoles(...$roles)
    {
        $this->roles()->detach();

        return $this->assignRole($roles);
    }

    /**
     * @param mixed ...$roles
     *
     * @return $this
     */
    public function assignRole(...$roles)
    {
        $roleModel = config('permissions.models.roles');
        $roles = collect($roles)
            ->flatten()
            ->map(function ($role) use ($roleModel) {
                if (!$role instanceof $roleModel) {
                    $role = $this->getRoleModel($role);
                }

                return $role;
            })
            ->each(function ($role) use ($roleModel) {
                $role->validateGuard();
            })
            ->all();

        $this->roles()->saveMany($roles);

        return $this;
    }

    /**
     * @param string $roles
     *
     * @return array
     */
    private function parsePipedList(string $roles)
    {
        return explode('|', $roles);
    }

    /**
     * @param $role
     *
     * @return mixed
     */
    public function getRoleModel($role)
    {
        $roleModel = config('permissions.models.roles');
        if ($role instanceof $roleModel) {
            return $role;
        }

        if (is_numeric($role)) {
            return $roleModel::firstOrFail($role);
        }

        if (is_string($role)) {
            return $roleModel::whereName($role)
                ->orWhereDisplayName($role)
                ->first();
        }

        throw new RoleModelNotFoundException();
    }
}
