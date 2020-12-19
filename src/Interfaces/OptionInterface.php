<?php

namespace Codememory\Screw\Interfaces;

use Codememory\Screw\HttpRequest;
use Codememory\Screw\Response\Response;

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