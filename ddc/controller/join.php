<?php

class join extends Controller{
    public function __construct()
    {
        parent::__construct("join");
    }

    public function index()
    {
        $this->viewBag["title"] = "Join Us";

        $this->view("Layout");
    }
}