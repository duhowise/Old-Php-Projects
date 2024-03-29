<?php

/**
 * Created by PhpStorm.
 * User: DUHO
 * Date: 7/30/17
 * Time: 4:08 PM
 */
class Categories extends CI_Controller
{
    public function index(){
        $data['title']='All Categories';
        $data['categories']= $this->category_model->get_categories();
        $this->load->view('templates/header');
        $this->load->view('categories/index',$data);
        $this->load->view('templates/footer');
    }
    public function posts($id){
        $data['title']=$this->category_model->get_category($id)->name;
        $data['posts']=$this->post_model->get_posts_by_category($id);
        $this->load->view('templates/header');
        $this->load->view('posts/index',$data);
        $this->load->view('templates/footer');
    }
    public function create(){
        $data['title']='Create Category';
        $this->form_validation->set_rules('name','Name','required');
        if ($this->form_validation->run()===false){
            $this->load->view('templates/header');
            $this->load->view('categories/create',$data);
            $this->load->view('templates/footer');
        }else{
            $this->category_model->create_category();
            redirect('categories/create');
        }
    }
}