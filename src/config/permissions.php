<?php

use CrixuAMG\Permissions\Models\Permission;
use CrixuAMG\Permissions\Models\Role;

return [
    'cache_enabled' => true,

    // The amount of minutes the permissions will be cached if caching is enabled
    'cache_time'    => 60,

    'tables' => [
        'permissionables' => 'permissionables',
        'roleables'       => 'roleables',
        'permissions'     => 'permissions',
        'roles'           => 'roles',
    ],

    'models' => [
        'permissions' => Permission::class,
        'roles'       => Role::class,
    ],

    'roles' => [
        // Register any roles here, recommended is to use class constants to have a single declaration of role names
        'admin'     => trans('roles.admin', 'admin'),
        'moderator' => trans('roles.moderator', 'moderator'),
        'member'    => trans('roles.member', 'member'),
    ],
];
