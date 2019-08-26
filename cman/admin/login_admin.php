<?php
include('..\dbconnect.php');
?>
	
	<form id="login_form1" class="form-signin" method="post">
				<h3 class="form-signin-heading">
					<i class="icon-lock"></i> Administrator Login
				</h3>
				<input type="text"      class="input-block-level"   id="username" name="username" placeholder="Username" required>
				<input type="password"  class="input-block-level"   id="password" name="password" placeholder="Password" required>
				
				<button data-placement="right" title="Click Here to Sign In" id="signin" name="login" class="btn btn-info" type="submit"><i class="icon-signin icon-large"></i> Sign in</button>
				<script type="text/javascript">
				$(document).ready(function(){
				$('#signin').tooltip('show');
				$('#signin').tooltip('hide');
				});
				</script>		
			</form>
	</br>
	<div class="error">
	<?php

if (isset($_POST['login'])){

$username=$_POST['username'];
$password=$_POST['password'];

$query="select * from admin where username='$username' and password='$password'";
$result=$mysqli->query($query);
$row=$result->fetch_assoc();


if ($row > 0){
session_start();
$_SESSION['id']=$row['admin_id'];
header('location:dashboard.php');
}else{
	header('location:index.php');
}
}
?>
   


</div>
