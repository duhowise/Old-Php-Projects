<?php

class View extends alpha {

    public $page ='';

    function __construct() {
        parent::__construct();
    }


    //view display functions
    public function render($page,$layout=null,$binding=false){

        $this->page = $page;
        if(!empty($layout)) {
            try
            {
                //render page with a layout
                $file = "view/{$page}/index.php";
                if(file_exists($layout_file = "view/shared/{$layout}.php")){
                    require $layout_file;
                }else{
                    throw new LayoutException;
                }
            }catch(LayoutException $layout_error){
                $this->page_error($layout_error,'LAYOUT_ERROR',$layout_file);
            }
        }else{
            try
            {
                //render page without layout
                if (file_exists($file)){
                    require $file;
                }else{
                    throw new PageException;
                }
            }catch (PageException $page_error){
                $this->page_error($page_error,'PAGE_ERROR',$file);
            }
        }
        if($binding){

        }

    }

    public function shared($file){
        if(is_dir($file) && file_exists($file)){
            require $file;
        }else{
            try
            {
                if (file_exists("view/shared/{$file}.php")){
                    require "view/shared/{$file}.php";
                }else{
                    throw new PageException;
                }
            }catch(PageException $page_error){
                $this->page_error($page_error,'PAGE_ERROR',"view/shared/{$file}.php");
            }
        }
    }

    public function layout_body(){
        $body_file = "view/{$this->page}/index.php";
        try
        {
            if(file_exists($body_file)){
                require $body_file;
            }else{
                throw new PageException;
            }
        }catch(PageException $page_error){
            $this->page_error($page_error,'PAGE_ERROR',$body_file);
        }
    }
    
    public function display_uniq($page){

        try
        {
            $file = "view/{$page}";
            if (file_exists($file)){
                require $file;
            } else {
                throw new PageException;
            }
        }catch (PageException $page_error){
            $this->page_error($page_error,'PAGE_ERROR',$file);
        }
    }

    private function page_error(Exception $err_info,$view_error_type,$page){
        $error = new error_handler();
        $this->view_error_log($err_info,$page,$view_error_type);
        $error->missing_page();
        return false;
    }




    /*----------------------------------
        * html helper functions
        *-----------------------------------*/

    /**
     *
     * @param array $dict
     * @return HtmlPrps
     */
    public function setprps($dict = array()){
        $prps = new HtmlPrps();
        foreach($dict as $key => $val){
            $prps->{$key} = $val;
        }
        return $prps;
    }

    public function htmlAnchor($controller, $link_name, $action_method = null, $param = null,$text=null) {
        //we will need to come up with a way to identify the domain name automatically
        if (is_null($param) && is_null($action_method)) {
            $href = "{$controller}";
        } else if (!is_null($action_method) && is_null($param)) {
            $href = "{$controller}/{$action_method}";
        } else {
            $href = "{$controller}/{$action_method}/{$param}";
        }

        echo "<a href=\"" . DOMAIN_NAME . "{$href}\">{$link_name}{$text}</a>";
    }

    public function htmlIMG($imgPath, $class=array(), $alt = null) {
        echo "<img class = \"".join(" ",$class)."\" src=\" " . IMAGES . $imgPath . " \" alt= \"{$alt}\"/> \n";
    }

    public function htmlLink ($filename,$rel=null) {
        $file_dir = CSS."$filename";
        echo "<link rel =\"{$rel}\" type=\"text/css\" href=\"{$file_dir}\" media=\"screen\" /> \n";
    }


    public function htmlScript($filename,$type=null){
        $file_dir = JS."$filename";
        echo "<script type=\"{$type}\" src=\"{$file_dir}\"></script>\n";
    }


    public function htmlForm(htmlPrps $htmlprps,$fields){

        /*$model = new RedBean_SimpleModel();
        $model_properties = $this->inspector->getClassProperties($model);*/

    }


    /**
     * this function will display data stored in the variable passed to it as html, depending on
     * what kind of data is stored in it
     * @param $entity
     */
    public function htmlDisplay($entity){
        if(is_array($entity)){
            echo "<pre>";
            foreach($entity as $key => $value){
                echo $value;
            }
            echo "</pre>";
        }else{
            echo "<text type=\"text\">{$entity}</text>";
        }
    }



    /**
     * @description this function will display data stored in the variable passed to it in an appropriate
     * html form element, depending on what kind of data is stored in it
     * @param $entity
     * @param null $name
     * @param null $class
     */
    public function htmlFormElement($entity,$name=null,$class=null){
        if(is_array($entity)){
            echo "<select name = \"{$name}\" class=\"{$class}\">";
            foreach($entity as $key => $value){
                echo "<option value=\"{$value}\">{$key}</option>";
            }
            echo "</select>";
        }else{
            echo "<input type=\"text\" value=\"{$entity}\" name=\"{$name}\" class=\"{$class}\" />";
        }
    }



    function year(){
        echo "<option value=\"\" >Year</option>";
        for ($x = 1950; $x <= 1998; $x++){
            echo "<option value=$x>$x</option>";
        }
    }

    function month(){
        $month = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
        $i = 0;
        echo "<option value=\"\" >Month</option>";
        for ($y = 0; $y < 12; $y++) {
            echo '<option value="'.++$i.'">'.$month[$y].'</option>';
        }
    }

    function day() {
        echo "<option value=\"\" >Day</option>";
        for ($x = 1; $x <= 31; $x++) {
            echo "<option value=$x>$x</option>";
        }
    }


 /*
  * hcms functions
  * */


    /**
     * function to render a container as html
     * @param Container $container the container object to be rendered as html
     */
    public function render_container(Container $container)
    {
        $cont_type = !$container->is_child()? 'main_container' : 'sub_container';
        $class = !$container->is_child()? 'col-4' : '';

        echo "<div class=\"{$class}\">";
            //main container
            echo "<div class=\"container-pod\">";
                echo "<div class=\"{$cont_type}\">";
                echo "<div class=\"container-header\">";
                echo $container->tag;
                echo "</div>";
                echo "<div class=\"container-data-field\">";
            echo "<input type=\"hidden\" name = \"{$container->tag}_container_type\" value = \"{$cont_type}\" />";
                if($container->content_format == "text"){
                    echo "<textarea name=\"{$container->tag}\" class=\"text-data-container\" placeholder=\"Enter text\"></textarea>";
                }elseif($container->content_format == "picture"){
                    echo "<div class=\"pic-data-container\">";
                    echo "<input type=\"file\"  class=\"pic-upload\" name=\"{$container->tag}\"/>";
                    echo "
                            <div class=\"pdc-left\">Upload a picture</div>
                            <div class=\"pdc-right\"></div>
                                    ";
                    echo "</div>";

                }else if($container->content_format == "video"){
                    echo "<div class=\"vid-data-container\">";
                    echo "<input type=\"file\" multiple=\"multiple\" class=\"pic-upload\" name=\"{$container->tag}\"/>";
                    echo "
                                            <div class=\"pdc-left\">Upload a video</div>
                                            <div class=\"pdc-right\"></div>
                                    ";
                    echo "</div>";
                }
                echo "</div>";
                echo "</div>";
                echo "</div>";
                /*
                 * check and render sub containers if there are any
                 * */
                if($container->is_parent()){
                    foreach($container->children as $sub_container){
                        $this->render_container($sub_container);
                    }
                }
                echo "</div>";
    }

    public function get_content($tag)
    {
        $content = new content();

        return $content->get_content($tag);
    }

}
