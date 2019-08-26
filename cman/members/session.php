<?php
require_once('..\dbconnect.php');
//Start session
session_start();
//Check whether the session variable SESS_mEmBER_ID is present or not
if (!isset($_SESSION['id']) ||(trim ($_SESSION['id']) == '')) {
	header("location:".host()."../index.php");
    exit();
}
$session_id=$_SESSION['id'];

$query="select * from members where id = '$session_id'";
$result=$mysqli->query($query);
$user_row=$result->fetch_assoc();

$admin_username = $user_row['mobile'];
?>