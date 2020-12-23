<?php

namespace Codememory\Screw\Options;

use Codememory\Screw\HttpRequest;
use Codememory\Screw\Interfaces\OptionInterface;
use Codememory\Screw\Response\Response;

/**
 * Class HttpOption
 * @package Codememory\Screw\Options
 *
 * @author  Codememory
 */
class HttpOption extends Invoke implements OptionInterface
{

    /**
     * @var array
     */
    private $readyData = [];

    /**
     * @param int $version
     *
     * @return $this
     */
    public function setVersion(int $version): HttpOption
    {

        $this->readyData['version'] = $version;

        return $this;

    }

    /**
     * @param bool $status
     *
     * @return $this
     */
    public function stream(bool $status): HttpOption
    {

        $this->readyData['stream'] = $status;

        return $this;

    }

    /**
     * @param int|bool $support
     *
     * @return $this
     */
    public function idnConversion($support): HttpOption
    {

        $this->readyData['idn_conversion'] = $support;

        return $this;

    }

    /**
     * @param bool $status
     *
     * @return $this
     */
    public function httpExceptions(bool $status): HttpOption
    {

        $this->readyData['http_errors'] = $status;

        return $this;

    }

    /**
     * @param string $version
     *
     * @return $this
     */
    public function ipVersion(string $version): HttpOption
    {

        $this->readyData['force_ip_resolve'] = $version;

        return $this;

    }

    /**
     * @param callable $callback
     *
     * @return $this
     */
    public function stats(callable $callback): HttpOption
    {

        $this->readyData['on_stats'] = $callback;

        return $this;

    }

    /**
     * @param bool $status
     *
     * @return $this
     */
    public function sync(bool $status): HttpOption
    {

        $this->readyData['synchronous'] = $status;

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

        return $this->readyData;

    }

}