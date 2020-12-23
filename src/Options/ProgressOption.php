<?php

namespace Codememory\Screw\Options;

use Codememory\Screw\HttpRequest;
use Codememory\Screw\Interfaces\OptionInterface;
use Codememory\Screw\Response\Response;

/**
 * Class ProgressOption
 * @package System\Http\HttpRequest\Options
 *
 * @author  Codememory
 */
class ProgressOption extends Invoke implements OptionInterface
{

    /**
     * @var array
     */
    private $readyData = [];

    /**
     * @param callable $callback
     *
     * @return $this
     */
    public function progress(callable $callback): ProgressOption
    {

        $this->readyData['progress'] = $callback;

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