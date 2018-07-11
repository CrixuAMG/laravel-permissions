<?php

namespace CrixuAMG\Permissions\Models;

use Illuminate\Database\Eloquent\Model;
use CrixuAMG\Permissions\Traits\HasRoles;

class Permission extends Model
{
    use HasRoles;
}
