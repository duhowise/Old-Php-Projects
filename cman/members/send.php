<?php
 	 include('./lib/dbcon.php'); 
     dbcon();
	include('session.php');
	$id=$_POST['selector'];
 	$stdev_id  = $_POST['stdev_id'];


	if ($id == '' ){ 
	header("location: device_location.php");
	?>
	

	<?php }else{
	
	$query = $mysqli->query("select * from location_details order by ld_id DESC");
	$row = $query->fetch_assoc();
	$ld_id  = $row['ld_id'];
	

    $N = count($id);
    for($i=0; $i < $N; $i++)
    {
	$oras = strtotime("now");
	$ora = date("Y-m-d",$oras);
	
    $mysqli->query("insert location_details (id,stdev_id,date_deployment) values('$id[$i]','$stdev_id','$ora')");
	$mysqli->query("insert into activity_log (date,username,action) values(NOW(),'$admin_username','Assign Device id $id[$i] to location id $stdev_id')");		
    }
   
	
	
	
	header("location: device_location.php");
	}  
	







?>
	
	

	
	