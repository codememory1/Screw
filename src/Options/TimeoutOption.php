<?php

namespace Codememory\Screw\Options;

use Codememory\Screw\HttpRequest;
use Codememory\Screw\Interfaces\OptionInterface;
use Codememory\Screw\Response\Response;

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
    private $requestTime = 0;

    /**
     * @var float|int
     */
    private $connectionTime = 0;

    /**
     * @var float|int|null
     */
    private $delay = null;

    /**
     * @var float|int|null
     */
    private $read = null;

    /**
     * @param int|float $time
     *
     * @return object
     */
    public function connectionTime($time): TimeoutOption
    {

        $this->connectionTime = $time;

        return $this;

    }

    /**
     * @param int|float $time
     *
     * @return object
     */
    public function requestTime($time): TimeoutOption
    {

        $this->requestTime = $time;

        return $this;

    }

    /**
     * @param int|float $time
     *
     * @return object
     */
    public function delayTime($time): TimeoutOption
    {

        $this->delay = $time * 1000;

        return $this;

    }

    /**
     * @param int|float $time
     *
     * @return object
     */
    public function readTime($time): TimeoutOption
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

        $readyData = [
            'connect_timeout' => $this->connectionTime,
            'delay'           => $this->delay,
            'timeout'         => $this->requestTime
        ];

        if ($this->read !== null) {
            $readyData += [
                'stream'       => true,
                'read_timeout' => $this->read ?? ini_get('default_socket_timeout')
            ];
        }

        return $readyData;

    }

}