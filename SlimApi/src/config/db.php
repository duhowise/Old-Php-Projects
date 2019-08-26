<?php
class db{
    //properties
    private $dbhost='localhost';
    private $dbname='slimapp';
    private $dbuser='root';
    private $dbpass='';

    //connect

    /**
     * @return string
     */
    public function connect()
    {
        $mysql_connection_str="mysql:host=$this->dbhost;dbname=$this->dbname";
        $connection=new PDO($mysql_connection_str,$this->dbuser,$this->dbpass);
        $connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        return $connection;
    }

}