<?php

namespace CrixuAMG\Permissions\Traits;

use CrixuAMG\Permissions\Models\Role;

trait HasRoles
{
    public function roles()
    {
        return $this->hasMany(config('permissions.models.roles'));
    }
}
