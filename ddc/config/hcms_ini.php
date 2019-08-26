<?php

class hcms_ini {
    private $pages = array();
    private $main_containers = array();
    private $sub_containers = array();

    public function __construct(){
        $this->load_data();
        $this->insert_data();
    }

    /**
     * @description function to fetch config data from the HCMS config file hcms_config.json
     *
     */
    private function load_data(){
        try{
            $config_json = fread(fopen( __DIR__.'/hcms_config.json','r'),4*1024);
        }catch (Exception $ex){
            die("We are very sorry for the inconvenience caused but we are having problems with our server, please try again later");
        }
        $data = (array)json_decode($config_json);

        foreach ($data as $page) {

            /*obtain page name*/
            $s_p = (array)$page;
            $this->pages[] = $s_p["name"];
            /*obtain main containers*/
            $containers = (array)$s_p["containers"];
            foreach ($containers as $std_obj) {
                $main_container = (array)$std_obj;
                $this->main_containers[] = array(
                    "page_name" => $s_p["name"],
                    "tag" => $main_container["tag"],
                    "parent" => $main_container["parent"],
                    "child" => $main_container["child"],
                    "content_multi" => $main_container["content_multi"],
                    "content_format" => $main_container["content_format"],
                    "content_type" => $main_container["content_type"]
                );
                $sub_containers = @(array)$main_container["sub_container"];
                /*obtain sub containers*/
                foreach ($sub_containers as $std_obj1) {
                    $sub_container = (array)$std_obj1;
                    $this->sub_containers[] = array(
                        "main_container_tag" => $main_container["tag"],
                        "tag" => $sub_container["tag"],
                        "parent" => $sub_container["parent"],
                        "child" => $sub_container["child"],
                        "content_multi" => $sub_container["content_multi"],
                        "content_format" => $sub_container["content_format"],
                        "content_type" => $sub_container["content_type"],
                        "page_name" => $s_p["name"]
                    );
                }
            }

        }

    }

    /**
     * @description function to insert hcms config data into the hcms database
     *
     */
    private function insert_data(){
        $hcms = new hcms();

        //check to see if the the hcms dashboard tables are empty
        if($hcms->check_state() == 0 && HCMS){
            //if empty and HCMS is set to true, go ahead and insert hcms page data into hcms database
            foreach($this->pages as $key => $pageName) {
                $page = new page();
                $page->name = $pageName;
                //insert page
                $page->set_page();
            }

            //insert main containers
            foreach ($this->main_containers as $mc) {
                $container = new Container();
                $container->tag = $mc["tag"];
                $container->page = new page($mc["page_name"]);
                $container->content_type = $mc["content_type"];
                $container->content_format = $mc["content_format"];
                $container->content_multi = $mc["content_multi"];
                $container->parent = $mc["parent"];
                $container->child = $mc["child"];
                $container->set_container();
            }


            //insert sub containers
            foreach ($this->sub_containers as $sc) {
                $container = new Container();
                $container->tag = $sc["tag"];
                $container->page = new page($sc["page_name"]);
                $container->content_type = $sc["content_type"];
                $container->content_format = $sc["content_format"];
                $container->content_multi = $sc["content_multi"];
                $container->parent = $sc["parent"];
                $container->child = $sc["child"];
                $container->set_container();
                $container->set_sub_container($sc["main_container_tag"],$sc["tag"]);
            }


        }
    }
}