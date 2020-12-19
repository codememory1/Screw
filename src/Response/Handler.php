<?php

namespace Codememory\Screw\Response;

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
     * @return false|mixed|string
     */
    protected function responseHandler($data)
    {

        switch ($this->type) {
            case 1:
                $data = json_encode($data);
                break;
            case 2:
                $data = json_decode($data, true);
                break;
            case 3:
                $data = json_decode($data, false);
                break;
            default:
                $data = (string) $data;

        }

        return $data;

    }



}