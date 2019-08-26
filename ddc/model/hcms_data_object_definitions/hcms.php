<?php

class hcms extends Model{

    public function __construct()
    {
        parent::__construct();
    }

    public function check_state()
    {
        // check if we also have the default admin loaded
        $admin = new admin();
        $admin->is_empty();
        $sth_check = $this->pdo_fetch("SELECT * FROM hcms.page LIMIT 10;",array(),PDO::FETCH_NUM);
        return $sth_check["count"];
    }
}