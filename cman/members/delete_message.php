<?php
include('./lib/dbcon.php');
dbcon();
if (isset($_POST['delete_message'])){
$id=$_POST['selector'];
$N = count($id);
for($i=0; $i < $N; $i++)
{
	$result = $mysqli->query("DELETE FROm message where msg_id='$id[$i]'");
}
header("location: messages.php");
}
?>