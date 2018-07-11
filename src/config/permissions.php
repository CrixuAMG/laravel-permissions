<?php

use CrixuAMG\Permissions\Models\Permission;
use CrixuAMG\Permissions\Models\Role;

return [
    'cache_enabled' => true,

    // The amount of minutes the permissions will be cached if caching is enabled
    'cache_time' => 60,

    'tables' => [
        'permissions' => 'permissions',
        'roles' => 'roles',
    ],

    'models' => [
        'permissions' => Permission,
        'roles' => Role,
    ],

    'roles' => [
        // Register any roles here, recommended is to use class constants to have a single declaration of role names
        'admin' => trans('roles.admin'),
        'moderator' => trans('roles.moderator'),
        'member' => trans('roles.member'),
    ],
];
