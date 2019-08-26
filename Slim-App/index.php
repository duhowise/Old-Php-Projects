<?php
/**
 * Created by PhpStorm.
 * User: DUHO
 * Date: 7/15/17
 * Time: 2:18 PM
 */


require 'vendor/autoload.php';
include 'bootstrap.php';

use  Chatter\Models\Message;
use Chatter\Middleware\Logging as ChatterLogging;
use Chatter\Middleware\Authentication as ChatterAuth;


$app=new \Slim\App([
    'settings'=>[
        'displayErrorDetails'=>true
    ]
]);
$app->add(new ChatterAuth());
$app->add(new ChatterLogging());

$app->get('/',function (){
    echo  'Welcome to the slim Api';
});


$app->group('/messages',function (){
    $this->map(['GET'],'',function ($request,$response,$args){
        $_message=new Message();
        $messages=$_message->all();
        $payload=[];
        foreach ($messages as $msg) {
            $payload[$msg->id] =$msg->output();
        }
        return $response->withStatus(200)->withJson($payload);
    })->setName('get_messages');

    $this->map(['GET'],'/{id}',function ($request,$response,$args){
        $_message=new Message();
        $_message=Message::find($args['id']);
        $payload=[];
        if ($_message){
            $payload[$_message->id]= $_message->output();
        }
        return $response->withStatus(200)->withJson($payload);
    });
});

$filter=new \Chatter\Middleware\FileFilter();
$removeExif=new \Chatter\Middleware\ImageRemoveExif();
$app->post('/messages', function ($request, $response, $args) {
    $_message = $request->getParsedBodyParam('message', '');
    $imagepath='';
    $message = new Message();
    $message->body = $_message;
    $message->image_url = $imagepath;
    $message->user_id = -1;
    $message->save();

    if ($message->id) {
        $payload = ['message_id' => $message->id,
            'message_uri' => '/messages/' . $message->id,
            'image_url'=>$message->image_url
        ];
        return $response->withStatus(201)->withJson($payload);
    } else {
        return $response->withStatus(400);
    }
})->add($filter)->add($removeExif);

$app->delete('/messages/{message_id}', function ($request, $response, $args) {
    $message=Message::find($args['message_id']);

    if ($message){

        $message->delete();

        if ($message->exists){
            return $response->withStatus(400);
        }else{
            return $response->withStatus(204);
        }
    }else{
        return $response->withStatus(404);
    }

});


$app->run();
