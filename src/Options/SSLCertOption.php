<?php

namespace Codememory\Screw\Options;

use Codememory\Screw\HttpRequest;
use Codememory\Screw\Interfaces\OptionInterface;
use Codememory\Screw\Response\Response;

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
    private $certificate = null;

    /**
     * @var array|string|null
     */
    private $sslKey = null;

    /**
     * @var array
     */
    private $readyData = [];

    /**
     * @param string $pathCertificate
     * @param null   $password
     *
     * @return object
     */
    public function certificate(string $pathCertificate, $password = null): SSLCertOption
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
    public function key(string $pathCertificate, $password = null): SSLCertOption
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