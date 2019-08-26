<?php
 require_once('dbconnect.php');

if (isset($_POST['login'])){

$username=$_POST['username'];
$password=$_POST['password'];

$query="select * from members where mobile='$username' and password='$password'";
$result=$mysqli->query($query);
$row=$result->fetch_assoc();


if ($row > 0){
session_start();
$_SESSION['id']=$row['id'];
header('location:members/dashboard.php');

}else{
	header('location:index.php');
}
}
?>