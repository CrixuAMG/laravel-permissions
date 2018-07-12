<?php

namespace CrixuAMG\Permissions\Models;

use CrixuAMG\Permissions\Traits\HasPermissions;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasPermissions;
}
