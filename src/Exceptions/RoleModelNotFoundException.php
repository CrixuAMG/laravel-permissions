<?php

namespace CrixuAMG\Permissions\Exceptions;

use Throwable;

/**
 * Class RoleModelNotFoundException
 * @package CrixuAMG\Permissions\Exceptions
 */
class RoleModelNotFoundException extends \Exception
{
    /**
     * ModelDoesNotImplementGuardException constructor.
     *
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = "Role model could not be found", int $code = 422, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}