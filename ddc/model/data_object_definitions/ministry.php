<?php

class ministry extends Model{
    public function __construct($name = null)
    {
        parent::__construct();
        if(!is_null($name))$this->get_ministry($name);
    }

    public $id;
    public $name;
    public $created_at;
    /**
     * @var member $ministerial_shepherd
     */
    public $ministerial_shepherd;
    /**
     * @var member $assistant_ministerial_shepherd
     */
    public $assistant_ministerial_shepherd;
    /**
     * @var array|member $members members of the ministry
     */
    public $members = array();
    /**
     * @var string $branch_ the name of the branch the ministry belongs to
     */
    public $branch_name;


    private function get_ministry($name)
    {
        $result = $this->pdo_fetch("CALL hbc.fetch_ministry(?)",array($name),PDO::FETCH_ASSOC);
        if($result["count"] > 0){
            $this->id = $result["data"]["ministry_id"];
            $this->name = $result["data"]["name"];
            $this->created_at = $result["data"]["created_at"];
            $this->ministerial_shepherd = new member($result["data"]["ministerial_shepherd_id"]);
            $this->assistant_ministerial_shepherd = new member($result["data"]["assistant_ministerial_shepherd"]);
        }

    }

    public function get_ministries($branchId)
    {
        $ministries = array();
        $result = $this->pdo_fetch("CALL hbc.fetch_ministries(?)",array($branchId),PDO::FETCH_ASSOC,true);
        foreach ($result["data"] as $row) {
            $ministry = new ministry($row["name"]);
            $ministries[] = $ministry;
        }
        return $ministries;
    }

    public function get_ministry_members()
    {
        $result = $this->pdo_fetch("CALL hbc.fetch_ministry_members(?)",array($this->id),PDO::FETCH_ASSOC,true);
        foreach ($result["data"] as $row) {
            $member = new member($row["member_id"]);
            $this->members[] = $member;
        }
        return $this->members;
    }

    public function set_ministry()
    {
        /*$result = */$this->pdo_insert("CALL hbc.set_ministry(:ministry_name,:createdAt,:mshepherd,:amshepherd,:branch_name)",
            array(
                ":ministry_name" => $this->name,
                ":createdAt" => $this->created_at,
                ":mshepherd" => $this->ministerial_shepherd->id,
                ":amshepherd" => $this->assistant_ministerial_shepherd->id,
                ":branch_name" => $this->branch_name
            ));
    }

}