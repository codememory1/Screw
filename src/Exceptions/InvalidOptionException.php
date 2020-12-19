<?php

namespace System\Http\HttpRequest\Exceptions;

use ErrorException;
use JetBrains\PhpStorm\Pure;

/**
 * Class InvalidOptionException
 * @package System\Http\HttpRequest\Exceptions
 *
 * @author  Codememory
 */
class InvalidOptionException extends ErrorException
{

    /**
     * InvalidOptionException constructor.
     *
     * @param string $option
     */
    #[Pure] public function __construct(string $option)
    {

        parent::__construct(sprintf('An error occurred in the Http Request %s option not found', $option));

    }

}