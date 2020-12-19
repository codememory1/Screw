<?php

namespace System\Http\HttpRequest\Interfaces;

use System\Http\HttpRequest\HttpRequest;
use System\Http\HttpRequest\Response\Response;

/**
 * Interface OptionInterface
 * @package System\Http\HttpRequest\Interfaces
 *
 * @author  Codememory
 */
interface OptionInterface
{

    /**
     * @param HttpRequest $request
     * @param Response    $response
     *
     * @return array
     */
    public function __invoke(HttpRequest $request, Response $response): array;

}