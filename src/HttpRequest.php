<?php

namespace System\Http\HttpRequest;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use ReflectionClass;
use System\Http\HttpRequest\Exceptions\ {
    IncorrectReturnInOptionsException,
    InvalidOptionException
};
use System\Http\HttpRequest\Interfaces\OptionInterface;
use System\Http\HttpRequest\Options\ {
    AuthorizationOption,
    ProgressOption,
    ProxyOption,
    RedirectOption,
    SSLCertOption,
    TimeoutOption
};
use System\Http\HttpRequest\Response\Response;

/**
 * Class HttpRequest
 * @package System\Http
 *
 * @author  Codememory
 */
class HttpRequest extends AssemblyHandler
{

    const O_REDIRECT = 'redirect';
    const O_AUTH = 'authorization';
    const O_SSL = 'ssl-cert';
    const O_TIMEOUT = 'timeout';
    const O_PROXY = 'proxy';
    const O_PROGRESS = 'progress';

    /**
     * @var array|string[]
     */
    private array $options = [
        'redirect'      => RedirectOption::class,
        'authorization' => AuthorizationOption::class,
        'ssl-cert'      => SSLCertOption::class,
        'timeout'       => TimeoutOption::class,
        'proxy'         => ProxyOption::class,
        'progress'      => ProgressOption::class
    ];

    /**
     * @var array
     */
    public array $readyOptions = [];

    /**
     * @var string
     */
    protected string $method = 'GET';

    /**
     * @var ?string
     */
    protected ?string $url = null;

    /**
     * @var int|null
     */
    protected ?int $port = null;

    /**
     * @var GuzzleResponse
     */
    private GuzzleResponse $response;

    /**
     * @param string $url
     *
     * @return object
     */
    public function setUrl(string $url): object
    {

        $this->url = $url;

        return $this;

    }

    /**
     * @param int $port
     *
     * @return object
     */
    public function addPort(int $port): object
    {

        $this->port = $port;

        return $this;

    }

    /**
     * @param OptionInterface $options
     *
     * @return object
     * @throws GuzzleException
     */
    private function saveReadyOption(OptionInterface $options): object
    {

        $this->send();

        $response = new Response($this);
        $call = $options($this, $response);

        if ($call !== []) {
            foreach ($call as $key => $value) {
                $this->readyOptions[$key] = $value;
            }
        }

        return $this;

    }

    /**
     * @param OptionInterface $options
     * @param string          $option
     *
     * @return object
     * @throws IncorrectReturnInOptionsException
     */
    private function optionReturnCheck(OptionInterface $options, string $option): object
    {

        $reflection = new ReflectionClass($this);
        $constants = array_flip($reflection->getConstants());

        if (!$options instanceof $this->options[$option]) {
            throw new IncorrectReturnInOptionsException($constants[$option], $this->options[$option]);
        }

        return $this;

    }

    /**
     * @param string   $option
     * @param callable $callback
     *
     * @return object
     * @throws InvalidOptionException|IncorrectReturnInOptionsException
     */
    public function option(string $option, callable $callback): object
    {

        if (array_key_exists($option, $this->options)) {
            $callOption = new $this->options[$option]();

            $options = call_user_func_array($callback, [$callOption]);

            $this->optionReturnCheck($options, $option)
                ->saveReadyOption($options);
        } else {
            throw new InvalidOptionException($option);
        }

        return $this;

    }

    /**
     * @param string $method
     *
     * @return object
     */
    public function setMethod(string $method): object
    {

        $this->method = $method;

        return $this;

    }

    /**
     * @return $this
     * @throws GuzzleException
     */
    public function send(): HttpRequest
    {

        $client = new Client();
        $response = $client->request($this->method, $this->getCollectedUrl(), $this->readyOptions);

        /** @var $response GuzzleResponse */
        $this->response = $response;

        return $this;

    }

    /**
     * @return GuzzleResponse
     */
    public function response(): GuzzleResponse
    {

        return $this->response;

    }

}