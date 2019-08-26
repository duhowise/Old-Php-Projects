<?php
require "rb.phar";
class database extends PDO {

    /*
     * we will need a way to allow the user to choose if they want to use the orm
     * or if they want to use the native pdo class to access databases.
     * how can we achieve this feet in a way which will be easy to use for users
     */

    public function __construct($config=null) {
        if($config == 'pdo'){
            //use pdo class to connect and manage the database
            //parent::__construct(mysql:host = localhost;dbname = sswap,root,"");
            try {
                @parent :: __construct(DB_TYPE . ":host=" . HOST_NAME . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
            } catch (PDOException $error) {

                die('Oops we seem to be experiencing some technical difficulties, please forgive us and try again later <br/> '. $error->getMessage() . '<br/>');
            }
        }else if($config == 'orm' ){
            //use orm to connect and manage the database
            R::setup(DB_TYPE . ":host=" . HOST_NAME . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        }


    }
   
    

}
