<?php

namespace System\Http\HttpRequest\Response;

use JetBrains\PhpStorm\Pure;
use System\Http\HttpRequest\HttpRequest;
use GuzzleHttp\Psr7\Response as GuzzleResponse;

/**
 * Class Response
 * @package System\Http\HttpRequest
 *
 * @author  Codememory
 */
class Response extends Handler
{

    const RESPONSE_JSON = 1;
    const RESPONSE_ARRAY = 2;
    const RESPONSE_OBJECT = 3;
    const RESPONSE_STRING = 4;

    /**
     * @var int
     */
    protected int $type = 4;

    /**
     * @var HttpRequest
     */
    protected HttpRequest $request;

    /**
     * Response constructor.
     *
     * @param HttpRequest $request
     */
    public function __construct(HttpRequest $request)
    {

        $this->request = $request;

    }

    /**
     * @param int $type
     *
     * @return Response
     */
    public function responseType(int $type): Response
    {

        $this->type = $type;

        return $this;

    }

    /**
     * @param callable $handler
     * @param int      $code
     *
     * @return Response
     */
    public function processResponseCode(callable $handler, int $code = 200): Response
    {

        return $this;

    }

    /**
     * @return mixed
     */
    public function getResponseBody(): mixed
    {

        return $this->responseHandler(
            $this->request
                ->response()
                ->getBody()
        );

    }

    /**
     * @return int
     */
    #[Pure] public function getResponseCode(): int
    {

        return $this->request
            ->response()
            ->getStatusCode();

    }

    /**
     * @return GuzzleResponse
     */
    #[Pure] public function getResponseGuzzle(): GuzzleResponse
    {

        return $this->request
            ->response();

    }

}