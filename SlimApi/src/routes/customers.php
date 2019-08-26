<?php
/**
 * Created by PhpStorm.
 * User: DUHO
 * Date: 12/14/2017
 * Time: 9:17 AM
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app=new \Slim\App;

//get all customers

$app->get('/api/customers',function (Request $request,Response $response){
   $sql="select * from customers";
   try{
       //get db
       $db=new db();
       //get connection
       $db=$db->connect();
       $stmt=$db->query($sql);

       $customers=$stmt->fetchAll(PDO::FETCH_OBJ);
       $db=null;
      // echo json_encode($customers);
       return $response->withStatus(200)->withJson($customers);
   }catch (PDOException $exception){
echo '{"error:
            {
            text:'.$exception->getMessage();'
            }
      "}';

   }
});

//Get Single Customer
$app->get('/api/customers/{id}',function (Request $request,Response $response){
  $id=$request->getAttribute('id');
   $sql="select * from customers WHERE  id=$id";
   try{
       //get db
       $db=new db();
       //get connection
       $db=$db->connect();
       $stmt=$db->query($sql);

       $customer=$stmt->fetchAll(PDO::FETCH_OBJ);
       $db=null;
       //echo json_encode($customer);
       return $response->withStatus(200)->withJson($customer);
   }catch (PDOException $exception){
echo '{"error:
            {
            text:'.$exception->getMessage();'
            }
      "}';

   }
});


//add customer
$app->post('/api/customers/add',function (Request $request,Response $response){

    $first_name=$request->getParsedBodyParam('first_name');
    $last_name =$request->getParsedBodyParam('last_name');
    $phone =$request->getParsedBodyParam('phone');
    $email=$request->getParsedBodyParam('email');
    $address=$request->getParsedBodyParam('address');
    $city=$request->getParsedBodyParam('city');
    $state=$request->getParsedBodyParam('state');


   $sql="INSERT INTO customers(first_name,last_name,phone,email,address,city,state)VALUES(:first_name,:last_name,:phone,:email,:address,:city,:state)";
   try{
       //get db
       $db=new db();
       //get connection
       $db=$db->connect();
       $stmt=$db->prepare($sql);
       $stmt->bindParam(':first_name',$first_name);
       $stmt->bindParam(':last_name',$last_name);
       $stmt->bindParam(':phone',$phone);
       $stmt->bindParam(':email',$email);
       $stmt->bindParam(':address',$address);
       $stmt->bindParam(':city',$city);
       $stmt->bindParam(':state',$state);

       $customer=$stmt->execute();
       $db=null;
       return $response->withStatus(201)->withJson("customer added");
      // echo '{"notice":{"text":"customer added"}}';
   }catch (PDOException $exception){
       echo '{"error:
            {
            text:'.$exception->getMessage();'
            }
      "}';

   }
});





$app->put('/api/customers/update/{id}',function (Request $request,Response $response){
    $id=$request->getAttribute('id');
    $first_name=$request->getParsedBodyParam('first_name');
    $last_name =$request->getParsedBodyParam('last_name');
    $phone =$request->getParsedBodyParam('phone');
    $email=$request->getParsedBodyParam('email');
    $address=$request->getParsedBodyParam('address');
    $city=$request->getParsedBodyParam('city');
    $state=$request->getParsedBodyParam('state');


   $sql="UPDATE customers SET  first_name =:first_name ,last_name =:last_name  ,phone =:phone  ,email =:email,address =:address,city = :city ,state = ''WHERE  id = :id";
   try{
       //get db
      $db=new db();
       //get connection
       $db=$db->connect();
       $stmt=$db->prepare($sql);
       $id->bindParam(':id',$id);
       $stmt->bindParam(':first_name',$first_name);
       $stmt->bindParam(':last_name',$last_name);
       $stmt->bindParam(':phone',$phone);
       $stmt->bindParam(':email',$email);
       $stmt->bindParam(':address',$address);
       $stmt->bindParam(':city',$city);
       $stmt->bindParam(':state',$state);
       var_dump($stmt);
      // $stmt->execute();
       $db=null;
       return $response->withStatus(201)->withJson($stmt);
      // echo '{"notice":{"text":"customer added"}}';
   }catch (PDOException $exception){
       echo '{"error:{  text:'.$exception->getMessage();'    }  "}';

   }
});