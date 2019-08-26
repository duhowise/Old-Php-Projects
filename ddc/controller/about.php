<?php

class about extends Controller{

    public function __construct()
    {
        parent::__construct("about");
    }

    public function index()
    {
        $this->viewBag["title"] = "HBC Information";

        $this->view("Layout");
    }
}