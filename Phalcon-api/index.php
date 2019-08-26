<?php

use Phalcon\Mvc\Micro;
use Phalcon\Db\Adapter\Pdo\Mysql as PdoMysql;


        $loader=new \Phalcon\Loader();
        $loader->registerDirs([

            __DIR__.'/app/models/'

        ])->register();

        $di=new \Phalcon\Di\FactoryDefault();
        $di->set('db',function (){
            return new PdoMysql([
                "host"     => "localhost",
                "dbname"   => "phalconApi",
                "port"     => 3306,
                "username" => "photo",
                "password" => "photo"
            ]);
        });
        $app = new Micro($di);



        #retieves all cars
        $app->get('/api/cars',function () use($app){

           $cars=Cars::find();

            $response=new \Phalcon\Http\Response();

            if ($cars==false){
                $response->setJsonContent([
                    'status'=>'NOT-FOUND'
                ]);

            }else{

                $response->setJsonContent([

                    'status'=>'FOUND',
                    'data'=>$cars
                ]);
            }
            return $response;
        });

        #POST Insert CArs
        $app->post('/api/cars',function () use($app){


                $newCar=new Cars();
                $newCar=$app->request->getJsonRawBody(true);
                /*$newCar->ownername= $app->request->get('ownername');
                $newCar->regdate=$app->request->get('regdate');
                $newCar->licenceno=$app->request->get('licenceno');
                $newCar->engineno=$app->request->get('engineno');
                $newCar->taxpayment=$app->request->get('taxpayment');
                $newCar->carmodelyear=$app->request->get('carmodelyear');
                $newCar->seatingcapacity=$app->request->get('seatingcapacity');
                $newCar->horsepower=$app->request->get('horsepower');*/
                var_dump($newCar);
                //$result=$newCar->save();
                $result=false;
                $response=new \Phalcon\Http\Response();


                if ($result==true){

                    $response->setStatusCode(201,'Created');
                    $response->setJsonContent([
                        "status"=>"OK",
                        "data"=>$newCar->id
                    ]);
                }else{
                   // $error[]=$newCar->getMessages();
                   // $response->setStatusCode(409,'Conflict');
                   // $response->setJsonContent([
                     //   "status"=>"error",
                     //   "messages"=>$error
                    //]);
                }
                return $response;
            });





        #find cars by id
        $app->get('/api/cars/{id:[0-9]+}',function ($id) use($app){
            $car=Cars::findFirst($id);

            $response=new \Phalcon\Http\Response();

            if ($car==false){
                $response->setJsonContent([
                    'status'=>'NOT-FOUND'
                ]);

            }else{

                $response->setJsonContent([

                    'status'=>'FOUND',
                    'data'=>$car
                ]);
            }
            return $response;
        });

        #update cars by id
        $app->put('/api/cars/{id:[0-9]+}',function () use($app){



        });


        $app->notFound(function () use($app){
            $app->response->setStatusCode(404,"NOT FOUND")->sendHeaders();
            echo "Page Doesn't Exist";
        });

        $app->get('/',function (){

            echo "<h1>Welcome to the Cars Api</h1>";
            echo "<h1>use /Api to access the Cars Api</h1>";
        });

        $app->get('/api/cars/search/{licenceno}',function ($licenceno){

            $cars=Cars::findFirst([
                "conditions" => "licenceno = ?1",
                "bind"       => array(1 => $licenceno)
            ]);

            $response=new \Phalcon\Http\Response();

            if ($cars==false){
                $response->setJsonContent([
                    'status'=>'NOT-FOUND'
                ]);

            }else{

                $response->setJsonContent([

                    'status'=>'FOUND',
                    'data'=>$cars
                ]);
            }
            return $response;

        });


$app->handle();