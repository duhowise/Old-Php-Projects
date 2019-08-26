 <?php
 include('./lib/dbcon.php'); 
 dbcon(); 
 include('session.php');
 $new_password  = $_POST['new_password'];
 $mysqli->query("update admin set password = '$new_password' where admin_id = '$session_id'") ;
 ?>