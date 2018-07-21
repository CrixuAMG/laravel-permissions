<?php

use CrixuAMG\Permissions\Models\Permission;
use CrixuAMG\Permissions\Models\Role;

return [
    /**
     * Whether or not the permissions and roles should be cached in
     */
    'cache_enabled' => true,

    /**
     * The amount of minutes the permissions will be cached if caching is enabled
     */
    'cache_time'    => 60,

    /**
     * The cache tags that will be used if the cache driver implements tags
     */
    'cache_tags' => [

    ],

    /**
     * The prefix used for constants
     */
    'role_pefix' => 'ROLE_',

    /**
     * The database tables used
     */
    'tables' => [
        'permissionables' => 'permissionables',
        'roleables'       => 'roleables',
        'permissions'     => 'permissions',
        'roles'           => 'roles',
    ],

    /**
     * The models used in the package
     */
    'models' => [
        'permissions' => Permission::class,
        'roles'       => Role::class,
    ],

    /**
     * Define any role here
     */
    'roles' => [
        // Register any roles here, recommended is to use class constants to have a single declaration of role names
        'admin',
        'moderator',
        'member',
    ],
];
