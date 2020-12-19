<?php

namespace Codememory\Screw\Options;

use Codememory\Screw\HttpRequest;
use Codememory\Screw\Interfaces\OptionInterface;
use Codememory\Screw\Response\Response;

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
    private $redirect = null;

    /**
     * @var int
     */
    private $numberRedirects = 5;

    /**
     * @var bool
     */
    private $strictRedirect = false;

    /**
     * @var bool
     */
    private $referer = true;

    /**
     * @var callable|object
     */
    private $handler = null;

    /**
     * @var array
     */
    private $protocols = [
        'http', 'https'
    ];

    /**
     * @param bool $performRedirects
     *
     * @return object
     */
    public function redirect(bool $performRedirects): RedirectOption
    {

        $this->redirect = $performRedirects;

        return $this;

    }

    /**
     * @param int $redirects
     *
     * @return object
     */
    public function numberRedirects(int $redirects): RedirectOption
    {

        $this->numberRedirects = $redirects;

        return $this;

    }

    /**
     * @param bool $strictly
     *
     * @return object
     */
    public function strictRedirect(bool $strictly): RedirectOption
    {

        $this->strictRedirect = $strictly;

        return $this;

    }

    /**
     * @param bool $referer
     *
     * @return object
     */
    public function addRefererOnRedirect(bool $referer): RedirectOption
    {

        $this->referer = $referer;

        return $this;

    }

    /**
     * @param callable|object $handler
     *
     * @return object
     */
    public function redirectHandler($handler): RedirectOption
    {

        $this->handler = $handler;

        return $this;

    }

    /**
     * @param mixed ...$protocols
     *
     * @return object
     */
    public function allowProtocols(...$protocols): RedirectOption
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

        $readyData = [
            'allow_redirects' => []
        ];

        if ($this->redirect !== null) {
            $readyData['allow_redirects'] = $this->redirect;
        } else {
            $readyData['allow_redirects'] = [
                'max'         => $this->numberRedirects,
                'strict'      => $this->strictRedirect,
                'referer'     => $this->referer,
                'protocols'   => $this->protocols,
                'on_redirect' => function() use ($request, $response) {
                    call_user_func($this->handler, $request, $response);
                }
            ];
        }

        return $readyData;

    }

}