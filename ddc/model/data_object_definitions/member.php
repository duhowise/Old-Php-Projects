<?php

class member extends Model{
    public function __construct($id=null)
    {
        parent::__construct();
        if(!is_null($id))$this->get_member($id);
    }

    public $id;
    public $first_name;
    public $last_name;
    public $dob;
    public $email;
    public $phone_no1;
    public $phone_no2;
    public $phone_no3;
    public $location;
    private $marital_status;
    public $address;
    public $occupation;
    public $position;
    private $baptism_status;
    public $membership_status;
    private $gender;
    public $created_at;
    public $church_status;
    public $comment;
    public $picture_url;

    private function get_member($id) {
        $result = $this->pdo_fetch("CALL hbc.fetch_member(?)",array($id),PDO::FETCH_ASSOC);
        $this->id = $result["data"]["member_id"];
        $this->first_name = $result["data"]["first_name"];
        $this->last_name = $result["data"]["last_name"];
        $this->dob = $result["data"]["dob"];
        $this->email = $result["data"]["email"];
        $this->phone_no1 = $result["data"]["phone_no1"];
        $this->phone_no2 = $result["data"]["phone_no2"];
        $this->phone_no3 = $result["data"]["phone_no3"];
        $this->location = $result["data"]["location"];
        $this->marital_status = $result["data"]["marital_status"];
        $this->address = $result["data"]["address"];
        $this->occupation = $result["data"]["occupation"];
        $this->position = $result["data"]["position"];
        $this->baptism_status = $result["data"]["baptism_status"];
        $this->membership_status = $result["data"]["membership_status"];
        $this->gender = $result["data"]["gender"];
        $this->created_at = $result["data"]["created_at"];
        $this->church_status = $result["data"]["church_status"];
        $this->comment = $result["data"]["comment"];
        $this->picture_url = $result["data"]["picture_url"];
    }

    public function set_member()
    {
        $result = $this->pdo_insert("CALL hbc.set_member(:fname,:lname,:dob,:location,:email,:martialStatus,:phoneNo1,:phoneNo2,:phoneNo3,:address,:occupation,:position,:baptismStatus,:membershipStatus,:gender,:comment,:createdAt,:churchStatus,:picUrl)",
            array(
                ":fname" => $this->first_name,
                ":lname" => $this->last_name,
                ":dob" => $this->dob,
                ":location" => $this->location,
                ":email" => $this->email,
                ":martialStatus" => $this->marital_status,
                ":phoneNo1" => $this->phone_no1,
                ":phoneNo2" => $this->phone_no2,
                ":phoneNo3" => $this->phone_no3,
                ":address" => $this->address,
                ":occupation" => $this->occupation,
                ":position" => $this->position,
                ":baptismStatus" => $this->baptism_status,
                ":membershipStatus" => $this->membership_status,
                ":gender" => $this->gender,
                ":comment" => $this->comment,
                ":createdAt" => $this->created_at,
                ":churchStatus" => $this->church_status,
                ":picUrl" => $this->picture_url
            ));
    }

    public function is_male()
    {      ;
        return $this->gender == 0;
    }

    public function is_baptized()
    {
        return $this->baptism_status == 1;
    }

    public function is_married()
    {
        return $this->marital_status == 1;
    }

}