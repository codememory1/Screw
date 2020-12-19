<?php

namespace Codememory\Screw\Exceptions;

use ErrorException;

/**
 * Class IncorrectReturnInOptionsException
 * @package System\Http\HttpRequest\Exceptions
 *
 * @author  Codememory
 */
class IncorrectReturnInOptionsException extends ErrorException
{

    /**
     * @var string
     */
    private $option;

    /**
     * @var string
     */
    private $expected;

    /**
     * IncorrectReturnInOptionsException constructor.
     *
     * @param string $option
     * @param string $expected
     */
    public function __construct(string $option, string $expected)
    {

        $this->option = $option;
        $this->expected = $expected;

        parent::__construct(
            sprintf(
                'Option <b>%s</b> must return the <b>%s</b> object',
                $this->option, $this->expected
            )
        );

    }

    /**
     * @return string
     */
    public function getOption(): string
    {

        return $this->option;

    }

    /**
     * @return string
     */
    public function getExpected(): string
    {

        return $this->expected;

    }

}