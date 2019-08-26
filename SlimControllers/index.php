<?php

use App\Controllers\HomeController;
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
    $basePath = rtrim(str_ireplace('index.php', '', $container->get('request')->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container->get('router'), $basePath));

    return $view;
};
$app->get('/', HomeController::class . ':index');

$app->run();