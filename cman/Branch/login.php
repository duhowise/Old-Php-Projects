<?php
        include('lib/dbcon.php');
		dbcon(); 
		session_start();	
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		/*................................................ admin .....................................................*/
			$query = "SELECT * FROm admin WHERE username='$username' AND password='$password'";
			$result = $mysqli->query($query) ;
			$row =   ->fetch_assoc()($result);
			$num_row =  ->fetch_assoc()result);
			
		/*...................................................student ..............................................*/
		$query_student = $mysqli->query("SELECT * FROm student WHERE username='$username' AND password='$password'") ;
		$num_row_student =  ->fetch_assoc()query_student);
		$row_student =   ->fetch_assoc()($query_student);
		
		if( $num_row > 0 ) { 
		$_SESSION['id']=$row['admin_id'];
		echo 'true_admin';
		
		$mysqli->query("insert into user_log (username,login_date,admin_id)values('$username',NOW(),".$row['admin_id'].")") ;
		
		}else if ($num_row_student > 0){
		$_SESSION['student']=$row_student["student_id"];
		echo 'true';
		
		$mysqli->query("insert into user_log (username,login_date,student_id)values('$username',NOW(),".$row_student["student_id"].")") ;
	
		 }else{ 
				echo 'false';
		}	
				
		?>