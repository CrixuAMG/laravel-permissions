<?php

namespace CrixuAMG\Permissions\Traits;

use CrixuAMG\Permissions\Exceptions\InvalidGuardException;
use CrixuAMG\Permissions\Exceptions\ModelDoesNotImplementGuardException;
use Illuminate\Database\Eloquent\Model;

/**
 * Trait ImplementsGuard
 * @package CrixuAMG\Permissions\Traits
 */
trait ImplementsGuard
{
    /**
     * @var string
     */
    private $guard;

    /**
     * @param string $guard
     *
     * @return $this
     */
    public function setGuard(string $guard): ImplementsGuard
    {
        $this->guard = $guard;

        return $this;
    }

    /**
     * @param string $defaultGuard
     *
     * @return $this
     */
    public function setDefaultGuard(string $defaultGuard): ImplementsGuard
    {
        $this->defaultGuard = $defaultGuard;

        return $this;
    }

    /**
     * @var string
     */
    private $defaultGuard;

    /**
     * @return bool
     */
    public function validateGuard()
    {
        if (!$this->defaultGuard) {
            $this->defaultGuard = (string)config('permissions.guards.default');
        }

        if (!$this->guard) {
            $this->guard = $this->defaultGuard;
        }

        throw_unless(
            $this->guard === $this->guard_name ||
            $this->defaultGuard === $this->guard_name,
            InvalidGuardException::class,
            trans('permissions::errors.guard.invalid'),
            422
        );
    }
}