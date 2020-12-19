<?php

namespace System\Http\HttpRequest;

use JetBrains\PhpStorm\Pure;

/**
 * @package System\Http\HttpRequest
 *
 * Class AssemblyHandler
 * @author Codememory
 */
class AssemblyHandler
{

    /**
     * @return string
     */
    #[Pure] protected function getCollectedUrl(): string
    {

        if(!is_null($this->port) && is_integer($this->port)) {
            return sprintf('%s:%s', $this->url, $this->port);
        }

        return $this->url;

    }

}