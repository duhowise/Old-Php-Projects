<?php
/**
 * Created by PhpStorm.
 * User: DUHO
 * Date: 7/31/17
 * Time: 1:47 PM
 */
class Pages extends CI_Controller
{
   public function index(){
       $data['title']='Login';
        $this->load->view('templates/header',$data);
        $this->load->view('pages/login_modal');
        $this->load->view('templates/footer');
   }
   public function home()
   {
       $data['title']='Home';
       $this->load->view('templates/header',$data);
       $this->load->view('pages/home');
       $this->load->view('templates/footer');

   }


}