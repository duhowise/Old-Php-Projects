<?php

class multimedia extends Controller{

    public function __construct()
    {
        parent::__construct("multimedia");
    }

    public function index()
    {
        $this->viewBag["title"] = "HBC Multimedia";

        $this->view("Layout");
    }
}