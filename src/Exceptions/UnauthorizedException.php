<?php

namespace CrixuAMG\Permissions\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class UnauthorizedException
 * @package CrixuAMG\Permissions\Exceptions
 */
class UnauthorizedException extends HttpException
{
    /**
     * @return UnauthorizedException
     */
    public static function notLoggedIn(): self
    {
        return new static(403, trans('permissions::errors.auth.not-logged-in'), null, []);
    }
}
