<?php

namespace System\Http\HttpRequest\Response;

/**
 * Class Handler
 * @package System\Http\HttpRequest\Response
 *
 * @author  Codememory
 */
class Handler
{

    /**
     * @param $data
     *
     * @return mixed
     */
    protected function responseHandler($data): mixed
    {

        return match ($this->type) {
            1 => json_encode($data),
            2 => json_decode($data, true),
            3 => json_decode($data, false),
            default => (string) $data
        };

    }



}