<?php

namespace CrixuAMG\Permissions\Exceptions;

use Throwable;

/**
 * Class ModelDoesNotImplementGuardException
 * @package CrixuAMG\Permissions\Exceptions
 */
class ModelDoesNotImplementGuardException extends \Exception
{
    /**
     * ModelDoesNotImplementGuardException constructor.
     *
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = "Model does not implement guards", int $code = 422, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}