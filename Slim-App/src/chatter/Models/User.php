<?php
/**
 * Created by PhpStorm.
 * User: DUHO
 * Date: 7/15/17
 * Time: 3:18 PM
 */


namespace Chatter\Models;

class User extends \Illuminate\Database\Eloquent\Model
{

    public function authenticate($apikey)
    {
        $user = User::where('apikey', '=', $apikey)->take(1)->get();
        $this->details = $user[0];

        return ($user[0]->exists) ? true : false;
    }
}