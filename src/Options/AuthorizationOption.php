<?php

namespace System\Http\HttpRequest\Options;

use System\Http\HttpRequest\HttpRequest;
use System\Http\HttpRequest\Interfaces\OptionInterface;
use System\Http\HttpRequest\Response\Response;

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
    private int|string|null $username = null;

    /**
     * @var int|string|null
     */
    private int|string|null $password = null;

    /**
     * @var string|null
     */
    private ?string $type = null;

    /**
     * @var array
     */
    private array $readyData = [];

    /**
     * @var bool
     */
    private bool $statusAuth = true;

    /**
     * @param string|int $username
     *
     * @return object
     */
    public function username(string|int $username): object
    {

        $this->username = $username;

        return $this;

    }

    /**
     * @param string|int $password
     *
     * @return object
     */
    public function password(string|int $password): object
    {

        $this->password = $password;

        return $this;

    }

    /**
     * @param string $type
     *
     * @return object
     */
    public function type(string $type): object
    {

        $this->type = $type;

        return $this;

    }

    /**
     * @return object
     */
    public function disable(): object
    {

        $this->statusAuth = false;

        return $this;

    }

    /**
     * @return object
     */
    public function enable(): object
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