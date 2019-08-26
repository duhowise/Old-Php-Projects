<?php
/**
 * Created by PhpStorm.
 * User: DUHO
 * Date: 26/05/2018
 * Time: 21:28
 */

namespace App\controllers;
use Interop\Container\ContainerInterface;

abstract class Controller
{
    protected $Container;
    public function __construct(ContainerInterface $container)
    {
        $this->Container=$container;
    }
}