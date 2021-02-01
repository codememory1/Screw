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
     * @param string      $inputName
     * @param             $contents
     * @param string|null $filename
     * @param array       $headers
     *
     * @return $this
     */
    public function withFiles(string $inputName, $contents, string $filename = null, array $headers = []): ParamsOption
    {

        $data = [
            'name'     => $inputName,
            'contents' => $contents
        ];

        if($filename !== null) {
            $data['filename'] = $filename;
        }

        if($headers !== []) {
            $data['headers'] = $headers;
        }

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

        return $this->readyData;

    }

}