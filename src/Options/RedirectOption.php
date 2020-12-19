<?php

namespace System\Http\HttpRequest\Options;

use System\Http\HttpRequest\HttpRequest;
use System\Http\HttpRequest\Interfaces\OptionInterface;
use System\Http\HttpRequest\Response\Response;

/**
 * Class OptionRedirect
 * @package System\Http\HttpRequest
 *
 * @author  Codememory
 */
class RedirectOption extends Invoke implements OptionInterface
{

    /**
     * @var bool|null
     */
    private ?bool $redirect = null;

    /**
     * @var int
     */
    private int $numberRedirects = 5;

    /**
     * @var bool
     */
    private bool $strictRedirect = false;

    /**
     * @var bool
     */
    private bool $referer = true;

    /**
     * @var callable|object
     */
    private $handler = null;

    /**
     * @var array
     */
    private array $protocols = [
        'http', 'https'
    ];

    /**
     * @var array
     */
    private array $readyData = [];

    /**
     * @param bool $performRedirects
     *
     * @return object
     */
    public function redirect(bool $performRedirects): object
    {

        $this->redirect = $performRedirects;

        return $this;

    }

    /**
     * @param int $redirects
     *
     * @return object
     */
    public function numberRedirects(int $redirects): object
    {

        $this->numberRedirects = $redirects;

        return $this;

    }

    /**
     * @param bool $strictly
     *
     * @return object
     */
    public function strictRedirect(bool $strictly): object
    {

        $this->strictRedirect = $strictly;

        return $this;

    }

    /**
     * @param bool $referer
     *
     * @return object
     */
    public function addRefererOnRedirect(bool $referer): object
    {

        $this->referer = $referer;

        return $this;

    }

    /**
     * @param callable|object $handler
     *
     * @return object
     */
    public function redirectHandler(callable|object $handler): object
    {

        $this->handler = $handler;

        return $this;

    }

    /**
     * @param mixed ...$protocols
     *
     * @return object
     */
    public function allowProtocols(...$protocols): object
    {

        $this->protocols = $protocols;

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

        $this->readyData = [
            'allow_redirects' => []
        ];

        if ($this->redirect !== null) {
            $this->readyData['allow_redirects'] = $this->redirect;
        } else {
            $this->readyData['allow_redirects'] = [
                'max'         => $this->numberRedirects,
                'strict'      => $this->strictRedirect,
                'referer'     => $this->referer,
                'protocols'   => $this->protocols,
                'on_redirect' => fn () => call_user_func($this->handler, $request, $response)
            ];
        }

        return $this->readyData;

    }

}