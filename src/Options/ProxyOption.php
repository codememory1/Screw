<?php

namespace System\Http\HttpRequest\Options;

use System\Http\HttpRequest\HttpRequest;
use System\Http\HttpRequest\Interfaces\OptionInterface;
use System\Http\HttpRequest\Response\Response;

/**
 * Class ProxyOption
 * @package System\Http\HttpRequest\Options
 *
 * @author  Codememory
 */
class ProxyOption extends Invoke implements OptionInterface
{

    public function schema()
    {



    }

    /**
     * @param HttpRequest $request
     * @param Response    $response
     *
     * @return array
     */
    protected function call(HttpRequest $request, Response $response): array
    {

        return [];

    }

}