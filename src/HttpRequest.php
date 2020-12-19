<?php

namespace Codememory\Screw;

use Codememory\Screw\Exceptions\IncorrectReturnInOptionsException;
use Codememory\Screw\Exceptions\InvalidOptionException;
use Codememory\Screw\Interfaces\OptionInterface;
use Codememory\Screw\Options\AuthorizationOption;
use Codememory\Screw\Options\ProgressOption;
use Codememory\Screw\Options\ProxyOption;
use Codememory\Screw\Options\RedirectOption;
use Codememory\Screw\Options\SSLCertOption;
use Codememory\Screw\Options\TimeoutOption;
use Codememory\Screw\Response\Response;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use ReflectionClass;

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
    private $options = [
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
    public $readyOptions = [];

    /**
     * @var string
     */
    protected $method = 'GET';

    /**
     * @var ?string
     */
    protected $url = null;

    /**
     * @var int|null
     */
    protected $port = null;

    /**
     * @var GuzzleResponse
     */
    private $response;

    /**
     * @param string $url
     *
     * @return object
     */
    public function setUrl(string $url): HttpRequest
    {

        $this->url = $url;

        return $this;

    }

    /**
     * @param int $port
     *
     * @return object
     */
    public function addPort(int $port): HttpRequest
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
    private function saveReadyOption(OptionInterface $options): HttpRequest
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
    private function optionReturnCheck(OptionInterface $options, string $option): HttpRequest
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
     * @throws GuzzleException
     */
    public function option(string $option, callable $callback): HttpRequest
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
    public function setMethod(string $method): HttpRequest
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