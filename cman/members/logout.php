<?php
include('lib/dbcon.php'); 
dbcon(); 
include('session.php');

$oras = strtotime("now");
$ora = date("Y-m-d",$oras);										
$mysqli->query("update user_log set
logout_Date = '$ora'												
where student_id = '$session_id' ") ;

session_destroy();
header('location: ../'); 
?>