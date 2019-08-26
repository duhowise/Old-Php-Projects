<?php

/**
 * Created by PhpStorm.
 * User: DUHO
 * Date: 7/27/17
 * Time: 11:00 PM
 */
class post_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function get_posts($slug=false){

        if ($slug===false){
            $this->db->order_by('posts.id','DESC');
            $this->db->join('categories','categories.id=posts.category_id');
            $query=$this->db->get('posts');
            return $query->result_array();
        }
        $this->db->join('categories','categories.id=posts.category_id');
        $query=$this->db->get_where('posts',['slug'=>$slug]);
        return $query->row_array();

    }

    public function create_posts($post_image){
        $slug=url_title($this->input->post('title'));
        $data=[
            'title'=>$this->input->post('title'),
            'slug'=>$slug,
            'body'=>$this->input->post('body'),
            'category_id'=>$this->input->post('category_id'),
            'post_image'=>$post_image
        ];
        return $this->db->insert('posts',$data);
    }

    public function delete_post($slug){
        $this->db->where('slug',$slug);
        $this->db->delete('posts');
        return true;
    }

    public function update_post(){
        $slug=url_title($this->input->post('title'));
        $data=[
            'title'=>$this->input->post('title'),
            'slug'=>$slug,
            'body'=>$this->input->post('body'),
            'category_id'=>$this->input->post('category_id')
        ];
       $this->db->where('slug',$slug);
        return $this->db->update('posts',$data);
    }

    public function get_categories(){
        $this->db->order_by('name');
      $query=  $this->db->get('categories');
        return $query->result_array();
    }
    public function get_posts_by_category($category_id){
        $this->db->order_by('posts.id','DESC');
        $this->db->join('categories','categories.id=posts.category_id');
      $query=  $this->db->get_where('posts',['category_id'=>$category_id]);
        return $query->result_array();
    }
    }