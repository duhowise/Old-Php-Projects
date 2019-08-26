<?php

/**
 * Created by PhpStorm.
 * User: DUHO
 * Date: 7/27/17
 * Time: 9:36 PM
 */
class Pages extends CI_Controller
{
    public function view($page='home'){
      if (!file_exists(APPPATH.'views/pages/'.$page.'.php')){
           show_404();
       }
        $data['title']=ucfirst($page);
        $this->load->view('templates/header');
        $this->load->view('pages/'.$page,$data);
        $this->load->view('templates/footer');
    }
}