<?php

namespace Codememory\Screw\Options;

use Codememory\Screw\HttpRequest;
use Codememory\Screw\Interfaces\OptionInterface;
use Codememory\Screw\Response\Response;

/**
 * Class HeadersOption
 * @package Codememory\Screw\Options
 *
 * @author  Codememory
 */
class HeadersOption extends Invoke implements OptionInterface
{

    /**
     * @var bool|string
     */
    private $decodeContent = true;

    /**
     * @var callable|null
     */
    private $onHeaders = null;

    /**
     * @var array
     */
    private $readyData = [];

    /**
     * @param $decode
     *
     * @return HeadersOption
     */
    public function decodeContent($decode): HeadersOption
    {

        $this->decodeContent = $decode;

        return $this;

    }

    /**
     * @param string $name
     * @param        $value
     *
     * @return $this
     */
    public function header(string $name, $value): HeadersOption
    {

        $this->readyData['headers'][$name] = $value;

        return $this;

    }

    /**
     * @param callable $callback
     *
     * @return $this
     */
    public function onHeaders(callable $callback): HeadersOption
    {

        $this->onHeaders = $callback;

        return $this;

    }

    /**
     * @param int|bool $rule
     *
     * @return HeadersOption
     */
    public function expect($rule): HeadersOption
    {

        $this->readyData['expect'] = $rule;

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

        if ($this->decodeContent) {
            $this->readyData['decode_content'] = $this->decodeContent;
        }

        if ($this->onHeaders) {
            $this->readyData['on_headers'] = function () use ($response) {
                call_user_func($this->onHeaders, $response);
            };
        }

        return $this->readyData;

    }

}