<?php
/**
 * Created by PhpStorm.
 * User: DUHO
 * Date: 12/14/2017
 * Time: 9:00 AM
 */
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require '../src/config/db.php';
$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];
$c = new \Slim\Container($configuration);
$app=new \Slim\App($c);
require '../src/routes/customers.php';

$app->run();