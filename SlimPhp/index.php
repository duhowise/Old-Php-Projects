<?php
/**
 * Created by PhpStorm.
 * User: DUHO
 * Date: 25/05/2018
 * Time: 12:56
 */

require 'vendor/autoload.php';
$app=new Slim\App([
    'settings'=>[
        'displayErrorDetails'=>true
    ]
]);

$container=$app->getContainer();
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(__DIR__.'/resources/views', [
        'cache' => false
    ]);

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php','', $container->get('request')->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container->get('router'), $basePath));

    return $view;
};

$app->get('/',function ($request,$response){
    return $this->view->render($response,'home.twig');
});
$app->get('/users',function ($request,$response){
    $user=[
        'username'=>'Billy',
        'password'=>'pass',
        'email'=>'some@email.com'
    ];

    return $this->view->render($response,'users.twig',[
        'user'=>$user
    ]);
})->setName('users.index');


$app->get('/contact',function ($request,$response){
    return $this->view->render($response,'contact.twig');
})->setName('contact');


$app->get('/contact/confirm',function ($request,$response){
    return $this->view->render($response,'contact_confirm.twig');
})->setName('contact.confirm');

$app->post('/contact',function ($request,$response){
 echo  $request->getParam('name');
 echo  $request->getParam('email');
 echo  $request->getParam('message');
})->setName('contact');
$app->run();