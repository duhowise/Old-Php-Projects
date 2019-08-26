<?php
/**
 * Created by PhpStorm.
 * User: DUHO
 * Date: 7/15/17
 * Time: 3:57 PM
 */


namespace Chatter\Middleware;


use Chatter\Models\User;

class Authentication
{
    public function __invoke($request, $response, $next)
    {
        $auth = $request->getHeader('Authorization');
        $_apikey = array_pop($auth);
        $apikey = substr($_apikey, strpos($_apikey, ' ') + 1);

        $user = new User();
        if (!$user->authenticate($apikey)) {
            $response->withStatus(401);

            return $response;
        }

        $response = $next($request, $response);

        return $response;
    }
}