<?php
/**
 * Created by PhpStorm.
 * User: DUHO
 * Date: 7/30/17
 * Time: 10:10 PM
 */

namespace Chatter\Middleware;


class FileMove
{
    public function __invoke($request,$response,$next)
    {
        $response=$next($request,$response);

        return $response;
    }
}