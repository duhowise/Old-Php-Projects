<?php

class branch extends Model{
    public function __construct($branch_name = null)
    {
        parent::__construct();
        if(!is_null($branch_name))$this->get_branch($branch_name);
    }

    public $id;
    public $branch_name;
    public $branch_url;
    public $created_at;
    /**
     * @var member $members the members who belong to the branch
     */
    public $members = array();
    /**
     * @var member $leaders the members who belong to the branch
     */
    public $leaders;

    private function get_branch($branch_name)
    {
        $result = $this->pdo_fetch("CALL hbc.fetch_branch(?)",array($branch_name),PDO::FETCH_ASSOC);

        if($result["count"] > 0){
            $this->branch_name = $result["data"]["branch_name"];
            $this->branch_url = $result["data"]["branch_url"];
            $this->created_at = $result["data"]["created_at"];
            $this->get_branch_leaders($this->id);
        }
    }

    public function get_branches()
    {
        $branches = array();
        $result = $this->pdo_fetch("CALL hbc.fetch_branches()",array(),PDO::FETCH_ASSOC,true);
        foreach ($result["data"] as $row) {
            $branch = new branch($row["branch_name"]);
            $branches[] = $branch;
        }

    }

    public function get_branch_members(){
        $result = $this->pdo_fetch("CALL hbc.fetch_branch_members(?)",array($this->id),PDO::FETCH_ASSOC,true);
        foreach ($result["data"] as $row) {
            $member = new member($row["member_id"]);
            $this->members[] = $member;
        }
        return $this->members;
    }

    public function get_branch_leaders()
    {
        $result = $this->pdo_fetch("CALL hbc.fetch_branch_leaders(?)",array($this->id),PDO::FETCH_ASSOC,true);
        foreach ($result["data"] as $row) {
            $leader = new member($row["member_id"]);
            $this->leaders[] = $leader;
        }
        return $this->leaders;
    }

    public function set_branch()
    {
        $result = $this->pdo_insert("CALL hbc.set_branch(:branch_name,:branch_url,:createdAt)",
            array(
                ":branch_name" => $this->branch_name,
                ":branch_url" => $this->branch_url,
                ":createdAt" => $this->created_at,
            ));
    }
}