<?php

class hcmsdashboard extends Controller{
    public function __construct(){
        parent::__construct("hcmsdashboard");
    }

    public function index(){
        $this->viewBag["title"] = "HCMS DASHBOARD";
        if(session::get("logged_in")){
            $this->viewBag["hcms_data"] = $this->model->page_data_fetch();
            $this->select("hcmsdashboard","hcmsLayout");
            return false;
        }

        $this->select("hcmslogin","hcmsLayout");
    }

    public function upload(){
        /*--------------------------------------------------
         * handling multimedia upload (pictures and videos)
         *------------------------------------------------*/

           foreach($_FILES as $key => $file){
               if(isset($_FILES) && !empty($_FILES) && $_FILES[$key]["error"] == 0 && $_FILES[$key]["size"] > 0){
                   $upld_handler = new UploadHandler(array(
                       'upload_dir' => UPLOAD_DIR,
                       'upload_url' => UPLOAD_URL,
                       'user_dirs' => false,
                       'mkdir_mode' => 0755,
                       'param_name' => $key
                   ));

                   $upload_param = (array)json_decode($upld_handler->upload_data);
                   $upload_data = (array)$upload_param[$key];
                   $uploaded_file = (array)$upload_data[0];

                   $this->model->page_content_insert($uploaded_file["url"],$key);

               }

           }


        /*-----------------------
         * handling text uploads
         *---------------------*/
        foreach($_POST as $key => $fld_val){

            if(!empty($fld_val) && $key != "upload-submit" && $key != "page_name" && !strstr($key,"_container_type")){
                $this->model->page_content_insert($fld_val,$key);
            }

        }

        $this->redirect("hcmsdashboard");
    }

    /**
     * function to register admins for the HcmsDashBoard
     */
    public function register()
    {
        $admin = new admin();
        $admin->first_name = filter_input(INPUT_POST,'first_name');
        $admin->last_name = filter_input(INPUT_POST,'last_name');
        $admin->username = filter_input(INPUT_POST,'username',FILTER_SANITIZE_STRING);
        $admin->password = filter_input(INPUT_POST,"password",FILTER_SANITIZE_STRING);
        $admin->email = filter_input(INPUT_POST,'email');
        $admin->register();
    }

    public function login()
    {

        //the request is a form submission request
        $username = filter_input(INPUT_POST,'username',FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST,"password",FILTER_SANITIZE_STRING);

        $result = $this->model->hcms_login($username,$password);
        if($result["logged_in"]){
            session::set("logged_in",$result["logged_in"]);
            session::set("first_name",$result["first_name"]);
            session::set("last_name",$result["last_name"]);
            session::set("email",$result["email"]);
        }
        $this->redirect("hcmsdashboard");
    }

    public function logout()
    {
        session::end();
        $this->redirect("hcmsdashboard");
    }
}