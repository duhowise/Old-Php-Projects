<?php

class hcmsdashboard_mdl extends Model{
    public function __construct(){
        parent::__construct();
    }

    /**
     * Fetch page and page container data from the database
     * @return array
     * @throws Exception
     */
    public  function page_data_fetch(){

        $page = new page();
        $pages = $page->get_pages();
        $page_data = array();
        $page_data["pages"] = $pages;
        foreach($pages as $pge) {
            //now we fetch the containers
            $container = new Container();
            $page_data["containers"][$pge->name] = $container->get_containers($pge->name);
        }
        return $page_data;
    }

    public function hcms_login($username,$password){
       $admin = new admin($username);
        if($admin->exists){
            //check for the occurrence of brute force
            if (!($this->check_brute($admin->id))) {
                /*
                 * user is valid, now we check the salt and password
                 * */
                $hashPass = $this->hash($password . $admin->salt);
                if ($admin->password == $hashPass) {
                    return array(
                        "logged_in" => true,
                        "first_name" => $admin->first_name,
                        "last_name" => $admin->last_name,
                        "email" => $admin->email
                    );
                } else {
                    //password not verified
                    //we need to take a log of this in the login_attempts table
                    $this->pdo_insert("INSERT INTO hcms.login_attempts (user_id, login_attempt_time)
                                  VALUES(:userid,:currnt_time)", array(':userid' => $admin->id, ':currnt_time' => time()));
                    return array("logged_in" => false, "error_type" => LOGIN_PASSWORD_ERR);
                }
            }else{
                //brute force check failed
                return array("logged_in" => false);
            }
        }else{
            //admin does not exist

            return array("logged_in" => false);
        }
    }

    /**
     * function to insert container for a particular container
     * @param $cntnt string the content to be entered into the database
     * @param $container_tag string the tag name of the container
     */
    public function page_content_insert ($cntnt,$container_tag){
        $container = new Container($container_tag);
        $content = new content();
        if($container->content_type == "text"){
            $content->text = $cntnt;
        }else{
            $content->url = $cntnt;
        }
        $content->container = $container;

        $content->insert_content();
    }



    /**
     * function to check the number of times login has been tried, this is a measure to prevent
     * a brute force attack on the system
     * @param $id int the id of the user
     * @return bool returns true
     */
    private function check_brute($id){
        // All login attempts are counted from the past 45 minutes
        $valid_time = time() - (45 * 60);
        $result = $this->pdo_fetch('select la.login_attempt_time from ussap.login_attempts as la
                  where la.user_id = ? and la.login_attempt_time > ?',array($id,$valid_time),PDO::FETCH_NUM);
        if($result['count'] < 5){
            session::set('login_count', $result['count']);
            return false;
        }else if($result['count'] > 5 && $result['count'] > 10){
            //todo: log brute force incident, suspicious activity

            return true;
        }else{

            return true;
        }
    }
}