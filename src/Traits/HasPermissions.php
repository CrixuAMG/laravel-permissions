<?php

namespace CrixuAMG\Permissions\Traits;

/**
 * Trait HasPermissions
 * @package CrixuAMG\Permissions\Traits
 */
trait HasPermissions
{
    /**
     * @return mixed
     */
    public function roles()
    {
        return $this->hasMany(config('permissions.tables.permissions'), config('permissions.tables.permissions'));
    }
}
