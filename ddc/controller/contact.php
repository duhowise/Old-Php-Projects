<?php
/**
 * Created by PhpStorm.
 * User: DUHO
 * Date: 11/9/17
 * Time: 6:53 PM
 */

class contact extends Controller{

    public function __construct()
    {
        parent::__construct("contact");
    }

    public function index()
    {
        $this->viewBag["title"] = "HBC Contact";

        $this->view("Layout");
    }
}

