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

    /**
     * @var array
     */
    private $notProxy = [];

    /**
     * @var array|string
     */
    private $proxy;

    /**
     * @var array
     */
    private $userdata = [];

    /**
     * @var bool
     */
    private $forAllAddresses = false;

    /**
     * @param string $address
     *
     * @return string
     */
    private function assemblyAddress(string $address): string
    {

        preg_match('/(?<protocol>[a-z-A-Z]+):\/\/(?<address>.*)/', $address, $match);

        if(isset($this->userdata['username']) && isset($this->userdata['password'])) {
            return sprintf(
                '%s://%s:%s@%s',
                $match['protocol'], $this->userdata['username'], $this->userdata['password'], $match['address']
            );
        }

        return $address;

    }

    /**
     * @param string      $proxy
     * @param string|null $protocol
     *
     * @return $this
     */
    public function setProxy(string $proxy, string $protocol = null): ProxyOption
    {

        if($protocol === null) {
            $this->proxy = $this->assemblyAddress($proxy);
        } else {
            $this->proxy[$protocol] = $this->assemblyAddress($proxy);
        }

        if(!$this->forAllAddresses) {
            $this->userdata = [];
        }

        return $this;

    }

    /**
     * @param string $username
     *
     * @return $this
     */
    public function username(string $username): ProxyOption
    {

        $this->userdata['username'] = $username;

        return $this;

    }

    /**
     * @param string $password
     *
     * @return $this
     */
    public function password(string $password): ProxyOption
    {

        $this->userdata['password'] = $password;

        return $this;

    }

    /**
     * @param string $username
     * @param string $password
     * @param bool   $forAllAddresses
     *
     * @return $this
     */
    public function setUser(string $username, string $password, bool $forAllAddresses = false): ProxyOption
    {

        $this->forAllAddresses = $forAllAddresses;
        $this->username($username)->password($password);

        return $this;

    }

    /**
     * @param mixed ...$args
     *
     * @return $this
     */
    public function preventProxy(...$args): ProxyOption
    {

        $this->notProxy = $args;

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

        $readyData = [];

        if($this->proxy !== [] && $this->proxy !== null) {
            $readyData['proxy'] = $this->proxy;
        }

        if($this->notProxy !== []) {
            $readyData['proxy']['no'] = $this->notProxy;
        }

        return $readyData;

    }

}