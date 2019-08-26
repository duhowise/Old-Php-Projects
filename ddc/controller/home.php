<?php

 class home extends Controller{

     public function __construct()
     {
         parent::__construct("home");
     }

     public function index()
     {
         $this->viewBag["title"] = "HERITAGE BAPTIST CHURCH";

         $this->view("Layout");
     }
}