<?php

namespace System\Http\HttpRequest\Options;

use System\Http\HttpRequest\HttpRequest;
use System\Http\HttpRequest\Interfaces\OptionInterface;
use System\Http\HttpRequest\Response\Response;

/**
 * Class TimeoutOption
 * @package System\Http\HttpRequest\Options
 *
 * @author  Codememory
 */
class TimeoutOption extends Invoke implements OptionInterface
{

    /**
     * @var int
     */
    private int $requestTime = 0;

    /**
     * @var float|int
     */
    private float|int $connectionTime = 0;

    /**
     * @var float|int|null
     */
    private float|int|null $delay = null;

    /**
     * @var float|int|null
     */
    private float|int|null $read = null;

    /**
     * @var array
     */
    private array $readyData = [];

    /**
     * @param int|float $time
     *
     * @return object
     */
    public function connectionTime(int|float $time): object
    {

        $this->connectionTime = $time;

        return $this;

    }

    /**
     * @param int|float $time
     *
     * @return object
     */
    public function requestTime(int|float $time): object
    {

        $this->requestTime = $time;

        return $this;

    }

    /**
     * @param int|float $time
     *
     * @return object
     */
    public function delayTime(int|float $time): object
    {

        $this->delay = $time * 1000;

        return $this;

    }

    /**
     * @param int|float $time
     *
     * @return object
     */
    public function readTime(int|float $time): object
    {

        $this->read = $time;

        return $this;

    }

    /**
     * @param HttpRequest $request
     * @param Response    $response
     *
     * @return array
     */
    protected function call(HttpRequest $request, Response $response): array
    {

        $this->readyData = [
            'connect_timeout' => $this->connectionTime,
            'delay'           => $this->delay,
            'timeout'         => $this->requestTime
        ];

        if ($this->read !== null) {
            $this->readyData += [
                'stream'       => true,
                'read_timeout' => $this->read ?? ini_get('default_socket_timeout')
            ];
        }

        return $this->readyData;

    }

}