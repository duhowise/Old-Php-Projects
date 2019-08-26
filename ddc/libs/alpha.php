<?php

class alpha implements IErrorReport{

    private static $viewBagVar = array();
    private $alpha_model;
    private $key;
    public function __construct(){
        $this->set_key();
        $this->dt = new date_time();/*
        $this->alpha_model = new alpha_mdl();*/
        //creating an alias for our static viewBag variable
        $this->viewBag = &self::$viewBagVar;
    }


    /**
     * function to generates a hash value from the data provided
     * @param $data
     * @return string
     */
    public function hash($data){
       return hash("sha512",$data);
    }

    /**
     * function to generate a 128 character hashed salt string value
     * @return string
     */
    public function salt (){
        //logic to create a good salt value and also hash the $data value with the salt
        return $this->hash(uniqid(mt_rand(1, mt_getrandmax()), true));
    }

    protected function get_socket_model ($model_name){

        return new $model_name();//an instance of the model specified by the model name
    }

    public function model_error_log(Exception $error_info, $query = null, $params = null)
    {
        // TODO: Implement model_error_log() method.
        $this->alpha_model->model_log_err($error_info, $query = null, $params = null);
    }

    public function view_error_log(Exception $error_info, $page, $view_error_type)
    {
        // TODO: Implement view_error_log() method.
        $this->alpha_model->view_log_err($error_info, $page, $view_error_type);
    }

    public function controller_error_log(Exception $error_info,$controller_name,$controller_error_type){
        $this->alpha_model->controller_log_err($error_info,$controller_name,$controller_error_type);
    }

    /**
     * Returns an encrypted & utf8-encoded
     * @var $pure_string string the string to encrypt
     * @return string cipher text
     */
    function encrypt($pure_string) {
        $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH, $this->key, utf8_encode($pure_string), MCRYPT_MODE_ECB, $iv);
        return $encrypted_string;
    }

    /**
     * Returns decrypted original string
     * @var $encrypted_string string the string to decrypt
     * @return string plain text
     */
    function decrypt($encrypted_string) {
        $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $decrypted_string = mcrypt_decrypt(MCRYPT_BLOWFISH, $this->key, $encrypted_string, MCRYPT_MODE_ECB, $iv);
        return $decrypted_string;
    }

    private function set_key()
    {
        $salt = 'cH!swe!retReGu7W6bEDRuk7usuDUh9THeD2CHeGE*ewr4n39=E@rAsp7c-Ph@pH';
        $this->key = substr($this->hash($salt.DIGEST.$salt), 0, 32);
    }

} 