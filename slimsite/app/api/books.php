<?php

$app->get('/api/books',function(){


 require_once('dbconnect.php');
 $query="select * from books ";
 $result=$mysqli->query($query);

 while($row=$result->fetch_assoc()){
     $data=$row;
     if(isset($data)){
         header('Content-Type:Application/json');
     echo json_encode($data);

     }
 }
});

$app->get('/api/books/{id}',function($request ){

            include_once 'dbconnect.php';
            $id=$request->getAttribute('id');
             $query="select * from books where id=$id ";
             $result=$mysqli->query($query);

            while($row=$result->fetch_assoc()){
             $data=$row;
            if(isset($data)){
             header('Content-Type:Application/json');
            echo json_encode($data);

     }
 }
});
$app->post('/api/books',function($request){
        require_once('dbconnect.php');

        $query="INSERT INTO `books` (`book_title`, `author`, `amazon_url`) VALUES (?,?,?)";
        $statement=$mysqli->prepare($query);
        $statement->bind_param("sss",$book_title,$author,$amazon_url);

        $book_title=$request->getParsedBody()['book_title'];
        $author=$request->getParsedBody()['author'];
        $amazon_url=$request->getParsedBody()['amazon_url'];

    $statement->execute();

});

$app->put('/api/books/{id}',function($request){
        require_once('dbconnect.php');
    
        $id=$request->getAttribute('id');
        $query="UPDATE `books` SET `book_title` =?, `author` =?, `amazon_url` =? WHERE `books`.`id` =$id";
        $statement=$mysqli->prepare($query);
        $statement->bind_param("sss",$book_title,$author,$amazon_url);
        $book_title=$request->getParsedBody()['book_title'];
        $author=$request->getParsedBody()['author'];
        $amazon_url=$request->getParsedBody()['amazon_url'];

    $statement->execute();
});
$app->delete('/api/books/{id}',function($request){
        require_once('dbconnect.php');
        $id=$request->getAttribute('id');
        $query="DELETE FROM `books` WHERE id=$id";
        $mysqli->query($query);
 });



?>