<?php

namespace Codememory\Screw\Options;

use Codememory\Screw\HttpRequest;
use Codememory\Screw\Interfaces\OptionInterface;
use Codememory\Screw\Response\Response;

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