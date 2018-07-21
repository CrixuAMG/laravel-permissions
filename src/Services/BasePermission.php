<?php

namespace CrixuAMG\Permissions\Services;

use CrixuAMG\Permissions\Traits\ImplementsGuard;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BasePermission
 * @package CrixuAMG\Permissions\Services
 */
abstract class BasePermission extends Model
{
    use ImplementsGuard;
}
