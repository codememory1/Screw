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
     * @param string|null $url
     *
     * @return string|null
     */
    private function handlerCollectUrl(string $url = null)
    {

        if(!is_null($this->port) && is_integer($this->port)) {
            return sprintf('%s:%s', $url, $this->port);
        }

        return $url;

    }

    /**
     * @return string
     */
    protected function getCollectBaseUrl()
    {

        return $this->handlerCollectUrl($this->baseUrl);

    }

    /**
     * @return string
     */
    protected function getCollectedUrl()
    {

        if($this->baseUrl === null) {
            return $this->handlerCollectUrl($this->url);
        }

        return $this->url;

    }

}