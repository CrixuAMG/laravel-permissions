<?php

namespace CrixuAMG\Permissions\Services;

use CrixuAMG\Permissions\Traits\HasPermissions;
use CrixuAMG\Permissions\Traits\ImplementsGuard;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseRole
 * @package CrixuAMG\Permissions\Services
 */
abstract class BaseRole extends Model
{
    use HasPermissions, ImplementsGuard;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function roleable()
    {
        return $this->morphTo();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public static function getAllRoles()
    {
        $roles = (array)config('permissions.roles');

        $return = collect();
        foreach ($roles as $role) {
            // Create the roles if it does not exist yet and add it to the return array
            $return->push(
                self::createRole($role)
            );
        }

        // Return a collection of the roles so we can iterate over it
        return $return;
    }

    /**
     * @param string      $name
     * @param string|null $displayName
     * @param string|null $description
     *
     * @return mixed
     */
    public static function createRole(string $name, string $displayName = null, string $description = null)
    {
        return config('permissions.models.roles')::firstOrCreate([
            'name'         => $name,
            'display_name' => $displayName ?? ucfirst($name),
            'guard_name'   => config('permissions.guards.default'),
            'description'  => $description,
        ]);
    }
}
