<?php

namespace CrixuAMG\Permissions\Models;

use CrixuAMG\Permissions\Services\BaseRole;

class Role extends BaseRole
{
    protected $fillable = [
        'name',
        'display_name',
        'guard_name',
        'description',
    ];
}
