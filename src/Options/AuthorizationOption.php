<?php

namespace Codememory\Screw\Options;

use Codememory\Screw\HttpRequest;
use Codememory\Screw\Interfaces\OptionInterface;
use Codememory\Screw\Response\Response;

/**
 * Class AuthorizationOption
 * @package System\Http\HttpRequest\Options
 *
 * @author  Codememory
 */
class AuthorizationOption extends Invoke implements OptionInterface
{

    const TYPE_DIGEST = 'digest';
    const TYPE_NTLM = 'ntlm';
    const TYPE_BASIC = 'basic';

    /**
     * @var int|string|null
     */
    private $username = null;

    /**
     * @var int|string|null
     */
    private $password = null;

    /**
     * @var string|null
     */
    private $type = null;

    /**
     * @var array
     */
    private $readyData = [];

    /**
     * @var bool
     */
    private $statusAuth = true;

    /**
     * @param string|int $username
     *
     * @return object
     */
    public function username($username): AuthorizationOption
    {

        $this->username = $username;

        return $this;

    }

    /**
     * @param string|int $password
     *
     * @return object
     */
    public function password($password): AuthorizationOption
    {

        $this->password = $password;

        return $this;

    }

    /**
     * @param string $type
     *
     * @return object
     */
    public function type(string $type): AuthorizationOption
    {

        $this->type = $type;

        return $this;

    }

    /**
     * @return object
     */
    public function disable(): AuthorizationOption
    {

        $this->statusAuth = false;

        return $this;

    }

    /**
     * @return object
     */
    public function enable(): AuthorizationOption
    {

        $this->statusAuth = true;

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

        if ($this->statusAuth === true) {
            $this->readyData['auth'] = [$this->username, $this->password];

            if ($this->type !== null) {
                $this->readyData['auth'][2] = $this->type;
            }
        } else {
            $this->readyData['auth'] = null;
        }

        return $this->readyData;

    }

}