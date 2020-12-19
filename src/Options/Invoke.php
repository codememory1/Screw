<?php

namespace System\Http\HttpRequest\Options;

use System\Http\HttpRequest\HttpRequest;
use System\Http\HttpRequest\Response\Response;

/**
 * Class Invoke
 * @package System\Http\HttpRequest\Options
 *
 * @author  Codememory
 */
abstract class Invoke
{

    /**
     * @param HttpRequest $request
     * @param Response    $response
     *
     * @return array
     */
    public function __invoke(HttpRequest $request, Response $response): array
    {

        return $this->call($request, $response);

    }

}