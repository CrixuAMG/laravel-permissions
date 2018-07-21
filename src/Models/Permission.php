<?php

namespace CrixuAMG\Permissions\Models;

use CrixuAMG\Permissions\Services\BasePermission;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Permission
 * @package CrixuAMG\Permissions\Models
 */
class Permission extends BasePermission
{
    protected $fillable = [
        'name',
        'guard_name',
        'description',
    ];
}
