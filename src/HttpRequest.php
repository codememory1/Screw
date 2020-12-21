<?php

namespace Codememory\Screw;

use Closure;
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
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Psr\Http\Message\ResponseInterface;
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
     * @var null
     */
    protected $baseUrl = null;

    /**
     * @var int|null
     */
    protected $port = null;

    /**
     * @var GuzzleResponse
     */
    private $response;

    /**
     * @var callable|null
     */
    protected $refuser = null;

    /**
     * @var array
     */
    private $processResponseCode = [];

    /**
     * @var bool
     */
    private $clientOptions = false;

    /**
     * @param string $url
     *
     * @return $this
     */
    public function baseUrl(string $url): HttpRequest
    {

        $this->baseUrl = $url;

        return $this;

    }

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
                if($this->clientOptions === false) {
                    $this->readyOptions[$key] = $value;
                } else {
                    $this->readyOptions['clientOptions'][$key] = $value;
                }
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
     * @param bool $status
     *
     * @return $this
     */
    public function clientOptions(bool $status): HttpRequest
    {

        $this->clientOptions = $status;

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
     * @param callable $callback
     * @param int      $code
     *
     * @return $this
     */
    public function processResponseCode(callable $callback, int $code = 200): HttpRequest
    {

        $this->processResponseCode[$code] = [
            'callback' => $callback
        ];

        return $this;

    }

    /**
     * @param int $status
     * @param     $response
     *
     * @return $this
     */
    private function handlerResponseCode(int $status, $response): HttpRequest
    {

        if (array_key_exists($status, $this->processResponseCode)) {
            call_user_func($this->processResponseCode[$status]['callback'], $response);
        }

        return $this;

    }

    /**
     * @param callable $callback
     *
     * @return $this
     */
    public function refuser(callable $callback): HttpRequest
    {

        $this->refuser = $callback;

        return $this;

    }

    /**
     * @param Client $client
     *
     * @return ResponseInterface
     * @throws GuzzleException
     */
    private function request(Client $client): ResponseInterface
    {

        return $client->request($this->method, $this->getCollectedUrl(), $this->readyOptions);

    }

    /**
     * @param Client $client
     *
     * @return Exception|RequestException|ResponseInterface
     * @throws GuzzleException
     */
    private function processRefuser(Client $client)
    {

        if ($this->refuser instanceof Closure) {
            try {
                return $this->request($client);
            } catch (RequestException $e) {
                call_user_func($this->refuser, $e);

                return $e->getResponse();
            }
        }

        return $this->request($client);

    }

    /**
     * @return array
     */
    private function getClientOptions(): array
    {

        $options = [];

        if($this->baseUrl !== null) {
            $options['base_uri'] = $this->getCollectBaseUrl();
        }

        if(array_key_exists('clientOptions', $this->readyOptions)) {
            $options += $this->readyOptions['clientOptions'];

            unset($this->readyOptions['clientOptions']);
        }

        return $options;

    }

    /**
     * @return $this
     * @throws GuzzleException
     */
    public function send(): HttpRequest
    {

        $client = new Client($this->getClientOptions());
        $response = new Response($this);

        try {
            $this->response = $this->processRefuser($client);

            $this->handlerResponseCode($this->response->getStatusCode(), $response);
        } catch (ClientException | ServerException $e) {
            $this->handlerResponseCode($e->getCode(), $response);
        }

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