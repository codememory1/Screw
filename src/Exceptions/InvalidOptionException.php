<?php

namespace Codememory\Screw\Exceptions;

use ErrorException;

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
    public function __construct(string $option)
    {

        parent::__construct(sprintf('An error occurred in the Http Request %s option not found', $option));

    }

}