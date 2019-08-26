<?php

    class offering extends Model
    {
        public function __construct()
        {
            parent::__construct();
        }

        public $id;
        public $amount;
        public $created_at;
        /**
         * @var $branch branch the branch then offering belongs to
         */
        public $branch;

        public function get_offerings($branch_name)
        {
            $offerings = array();
            $result = $this->pdo_fetch("CALL hbc.fetch_offerings(?)",array($branch_name),PDO::FETCH_ASSOC,true);
            foreach ($result["data"] as $row) {
                $offering = new offering();
                $offering->id = $row["offering_id"];
                $offering->amount = $row["amount"];
                $offering->created_at = $row["created_at"];
                $offerings[] = $offering;
            }
            return $offerings;
        }


    }