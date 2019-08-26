<?php

class admin extends Model{

    public function __construct($id = null)
    {
        parent::__construct();
        if(is_numeric($id) && !empty($id)){
            //the user_id is given
            $this->get_admin_by_id($id);
        }else if(!is_numeric($id) && !empty($id)){
            //the user_email is given
            $this->get_admin($id);
        }
    }

    public $id;
    public $username;
    public $password;
    public $salt;
    public $created_at;
    public $first_name;
    public $last_name;
    public $email;
    public $exists = false;
    public $error_code;

    /**
     * function to fetch the information of an admin who's username has been provided for
     * @param string $username the username of the admin
     */
    private function get_admin($username)
    {
        //check if the username exist in our database
        $admin = $this->pdo_fetch("CALL hcms.admin_verify(:username)", array(':username' => $username),PDO::FETCH_ASSOC);
        if($admin["count"] == 1 and !isset($admin["data"]["error_status"])){
            $this->id = $admin["data"]["user_id"];
            $this->username = $admin["data"]["username"];
            $this->password = $admin["data"]["password"];
            $this->salt = $admin["data"]["salt"];
            $this->created_at = $admin["data"]["created_at"];
            $this->exists = true;
            $this->get_profile();
        }else if($admin["data"]["error_status"] = 10){
            //the user does not exist
            $this->exists = false;
            $this->error_code = $admin["data"]["error_status"];
        }elseif ($admin["data"]["error_status"] = 11){
            //we have multiple users
            $this->exists = false;
            $this->error_code = $admin["data"]["error_status"];
        }
    }

    /**
     * function to fetch information for an admin using the user id of the admin
     * @param $id
     */
    public function get_admin_by_id($id)
    {
        $admin = $this->pdo_fetch("select al.username from hcms.admin_login AS al WHERE al.user_id = ?", array($id),PDO::FETCH_ASSOC);
        if($admin["count"] == 1){
            $this->get_admin($admin["data"]["username"]);
        }else{
            $this->exists = false;
        }
    }

    /**
     * function to register a new admin for the platform
     * @return boolean returns true if the admin is successfully registered
     */
    public function register()
    {
        $salt = $this->salt();
        $hashPass = $this->hash($this->password.$salt);
        $this->pdo_insert("CALL hcms.insert_admin(:first_name, :last_name, :username, :pass, :salt, :email, :created_at)",
            array(
                ":first_name" => $this->first_name,
                ":last_name" => $this->last_name,
                ":username" => $this->username,
                ":pass" =>$hashPass,
                ":salt" => $salt,
                ":email" => $this->email,
                ":created_at" => $this->dt->get_date("date.timezone")
                ));
        return true;
    }

    /**
     * function to fetch the profile of an admin
     */
    private function get_profile()
    {
        $result = $this->pdo_fetch("CALL hcms.fetch_admin_profile(?)",array($this->id),PDO::FETCH_ASSOC);
        $this->first_name = $result["data"]["first_name"];
        $this->last_name = $result["data"]["last_name"];
        $this->email = $result["data"]["email"];
    }

    public function edit($field, $value)
    {
        if($field == "password"){
            $value = $this->hash($value.$this->salt);
        }
        $this->pdo_update("update hcms.admin_login AS al SET al.{$field} = ? WHERE al.user_id = ?", array($value,$this->id));
    }

    public function is_empty()
    {
        $result = $this->pdo_fetch("select * FROM hcms.admin_login LIMIT 10",array(),PDO::FETCH_NUM,true);
        if($result["count"] == 0){
            //load default admin login credentials
            $this->first_name = "admin";
            $this->last_name = "admin";
            $this->username = "admin";
            $this->password = DEFAULTY;
            $this->email = "admin@yahoo.com";
            $this->register();
        }
    }

}