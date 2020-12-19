<?php

namespace System\Http\HttpRequest\Exceptions;

use ErrorException;
use JetBrains\PhpStorm\Pure;

/**
 * Class IncorrectReturnInOptionsException
 * @package System\Http\HttpRequest\Exceptions
 *
 * @author  Codememory
 */
class IncorrectReturnInOptionsException extends ErrorException
{

    /**
     * @var string|null
     */
    private ?string $option;

    /**
     * @var string|null
     */
    private ?string $expected;

    /**
     * IncorrectReturnInOptionsException constructor.
     *
     * @param string $option
     * @param string $expected
     */
    #[Pure] public function __construct(string $option, string $expected)
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
     * @return string|null
     */
    public function getOption(): ?string
    {

        return $this->option;

    }

    /**
     * @return string|null
     */
    public function getExpected(): ?string
    {

        return $this->expected;

    }

}