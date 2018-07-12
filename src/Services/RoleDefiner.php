<?php

namespace CrixuAMG\Permissions\Services;

/**
 * Class RoleDefiner
 * @package CrixuAMG\Permissions\Services
 */
class RoleDefiner
{
    /**
     * @param string $prefix
     */
    public static function defineAll(string $prefix = 'ROLE_')
    {
        $roles = (array)config('permissions.roles');

        foreach ($roles as $role) {
            self::define($role, $prefix);
        }
    }

    /**
     * @param        $role
     * @param string $prefix
     */
    private static function define(string $role, string $prefix = 'ROLE_')
    {
        $constName = sprintf(
            '%s%s',
            $prefix,
            studly_case($role)
        );

        dump($constName);

        if (!defined($constName)) {
            define($constName);
        }
    }
}