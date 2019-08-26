<?php
/**
 * Created by PhpStorm.
 * User: DUHO
 * Date: 7/15/17
 * Time: 3:18 PM
 */


namespace Chatter\Models;

class Message extends \Illuminate\Database\Eloquent\Model
{
        public function output(){

            $data=[];
                $data[ 'body']        =$this->body;
                $data['user_id']      =$this->user_id;
                $data['user_uri']     ='/users/'.$this->user_id;
                $data['image_url']    =$this->image_url;
                $data['message_id']   =$this->id;
                $data['message_uri']  ='/messages/'.$this->id;
                $data['created_at']   =$this->created_at;
                return $data;
           }

}