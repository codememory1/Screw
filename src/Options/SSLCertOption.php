<?php

namespace System\Http\HttpRequest\Options;

use System\Http\HttpRequest\HttpRequest;
use System\Http\HttpRequest\Interfaces\OptionInterface;
use System\Http\HttpRequest\Response\Response;

/**
 * Class SSLCertOption
 * @package System\Http\HttpRequest\Options
 *
 * @author  Codememory
 */
class SSLCertOption extends Invoke implements OptionInterface
{

    /**
     * @var array|string|null
     */
    private array|string|null $certificate = null;

    /**
     * @var array|string|null
     */
    private array|string|null $sslKey = null;

    /**
     * @var array
     */
    private array $readyData = [];

    /**
     * @param string $pathCertificate
     * @param null   $password
     *
     * @return object
     */
    public function certificate(string $pathCertificate, $password = null): object
    {

        $this->certificate = empty($password) ? $pathCertificate : [$pathCertificate, $password];

        return $this;

    }

    /**
     * @param string $pathCertificate
     * @param null   $password
     *
     * @return object
     */
    public function key(string $pathCertificate, $password = null): object
    {

        $this->sslKey = empty($password) ? $pathCertificate : [$pathCertificate, $password];

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

        if($this->certificate !== null) {
            $this->readyData['cert'] = $this->certificate;
        }

        if($this->sslKey !== null) {
            $this->readyData['ssl_key'] = $this->sslKey;
        }

        return $this->readyData;

    }

}