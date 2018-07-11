<?php

namespace CrixuAMG\Permissions\Traits;

/**
 * Trait BuildsPermissions
 * @package CrixuAMG\Permissions\Traits
 */
trait BuildsPermissions
{
    /**
     * @param string      $permission
     * @param string|null $minimumRole
     * @param string      ...$roleExceptions
     */
    public function permission(string $permission, string $minimumRole = null, string ...$roleExceptions)
    {
        // TODO: build this
    }
}
