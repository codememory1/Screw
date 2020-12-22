<?php


namespace Codememory\Screw\Options;

use Codememory\Screw\HttpRequest;
use Codememory\Screw\Interfaces\OptionInterface;
use Codememory\Screw\Response\Response;

/**
 * Class ParamsOption
 * @package Codememory\Screw\Options
 *
 * @author  Codememory
 */
class ParamsOption extends Invoke implements OptionInterface
{

    /**
     * @var array
     */
    private $readyData = [];

    /**
     * @param array $data
     *
     * @return $this
     */
    public function form(array $data): ParamsOption
    {

        $this->readyData['form_params'] = $data;

        return $this;

    }

    /**
     * @param array $data
     *
     * @return $this
     */
    public function query(array $data): ParamsOption
    {

        $this->readyData['query'] = $data;

        return $this;

    }

    /**
     * @param array $data
     *
     * @return $this
     */
    public function withFiles(array $data): ParamsOption
    {

        $this->readyData['multipart'][] = $data;

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

        dd($this->readyData);
        return $this->readyData;

    }

}