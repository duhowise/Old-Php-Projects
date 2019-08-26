<?php

/**
 * Created by PhpStorm.
 * User: DUHO
 * Date: 7/30/17
 * Time: 4:25 PM
 */
class Category_model extends CI_Model
{
    function __construct()
    {
        $this->load->database();
    }
    public function get_categories(){
        $this->db->order_by('name');
        $query=  $this->db->get('categories');
//        var_dump($query->result_array());
        return $query->result_array();
    }
    public function create_category(){
        $data=['name'=>$this->input->post('name')];
    return $this->db->insert('categories',$data);
    }
    public function get_category($id){
         $query= $this->db->get_where('categories',['id'=>$id]);
        return $query->row();
    }
}