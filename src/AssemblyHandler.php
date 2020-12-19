<?php

namespace Codememory\Screw;

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
    protected function getCollectedUrl(): string
    {

        if(!is_null($this->port) && is_integer($this->port)) {
            return sprintf('%s:%s', $this->url, $this->port);
        }

        return $this->url;

    }

}