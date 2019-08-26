<?php
/**
 * Created by PhpStorm.
 * User: DUHO
 * Date: 7/15/17
 * Time: 3:57 PM
 */


namespace Chatter\Middleware;


class Logging{
    public function __invoke($request,$response,$next)
    {
        error_log($request->getMethod(). "--" .$request->getUri());
        $response=$next($request,$response);

        return $response;
    }
}