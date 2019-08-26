<?php
use Phalcon\Mvc\Model;
use Phalcon\Validation;

 class Cars extends Model{

    public $ownername;
    public $id;
    public $regdate;
    public $licenceno;
    public $engineno;
    public $taxpayment;
    public $carmodel;
    public $carmodelyear;
    public $seatingcapacity;
    public $horsepower;


    public function validation()
    {
        $validation=new Validation();

        $validation->add("licenceNo",new Validation\Validator\PresenceOf([
            "message"=>"Licence number is required"
        ]));
        $validation->add("engineNo",new Validation\Validator\PresenceOf([
            "message"=>"Engine number is required"
        ]));

        $validation->add("licenceNo",new Validation\Validator\Uniqueness([
            "message"=>"Licence number Already Exists"
        ]));

        $validation->add("licenceNo",new Validation\Validator\Regex([
            "pattern"=>"/^[A-Z]{3}-[0-9]{3}$/",
            "message"=>"Licence number invalid"
        ]));

        $validation->add("ownerName",new Validation\Validator\PresenceOf([
            "message"=>"owner name  is required"
        ]));

        $validation->add("engineNo",new Validation\Validator\PresenceOf([
            "message"=>"Engine number Already Exists"
        ]));

        if ($this->carmodelyear < 0){
            $this->appendMessage(new Model\Message("Cars Model Cannot be zero"));
        }
        if ($this->validationHasFailed()==true){
            return false;
        }
    }

    #public function indexAction(){
      #  $car=new Cars();
       # $data=$car->find();
       # var_dump($data);
   # }


 }
?>