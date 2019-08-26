<?php include('header.php'); ?>
<?php include('session.php'); ?>
    <body>
		<?php include('navbar.php'); ?>
        <div class="container-fluid">
            <div class="row-fluid">
				<?php include('sidebar.php'); ?>
				<div class="span3" id="addmembers">
				<?php include('addss.php'); ?>		   			
				</div>
                <div class="span6" id="">
                     <div class="row-fluid">
                        <!-- block -->
						
				<div class="empty">
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                         <i class="icon-info-sign"></i>  <strong>Note!:</strong> Select the checkbox if you want to delete?
                    </div>
               </div>
			   								
				<?php	
	             $count_members=$mysqli->query("select  count(*) as '0' from sundays");
	             $count = $count_members->fetch_assoc();
                 ?>	 
                        <div id="block_bg" class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left"></i><i class="icon-members"></i> Church Sunday School(s) List</div>
								<div class="muted pull-right">
								Number of Sunday School Kids: <span class="badge badge-info"><?php  echo $count[0]; ?></span>
							 </div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
								<form action="delete_memberss.php" method="post">
  									<table cellpadding="0" cellspacing="0" border="0" class="table" id="example">
									<a data-placement="right" title="Click to Delete check item"  data-toggle="modal" href="#members_delete" id="delete"  class="btn btn-danger" name=""><i class="icon-trash icon-large"> Delete</i></a>
									<script type="text/javascript">
									 $(document).ready(function(){
									 $('#delete').tooltip('show');
									 $('#delete').tooltip('hide');
									 });
									</script>
									<?php include('modal_delete.php'); ?>
										<thead>
										  <tr>
												<th></th>
												<th>Name</th>
												<th>mobile</th>
                                                <th>Residence</th>
												<th></th>
										   </tr>
										</thead>
										<tbody>
													<?php
													$members_query = $mysqli->query("select * from sundays");
													while($row = $members_query->fetch_assoc()){
													$id = $row['id'];
													?>
									
												<tr>
												<td width="30">
												<input id="optionsCheckbox" class="uniform_on" name="selector[]" type="checkbox" value="<?php echo $id; ?>">
												</td>
												<td><?php echo $row['fname']." ".$row['lname']; ?> </td>
	
												<td><?php echo $row['mobile']; ?></td>
                                                <td><?php echo $row['Residence']; ?></td>
											
												<?php include('toolttip_edit_delete.php'); ?>															
												<td width="120">
												<a rel="tooltip"  title="Edit member" id="e<?php echo $id; ?>" href="edit_members.php<?php echo '?id='.$id; ?>"  data-toggle="modal" class="btn btn-success"><i class="icon-pencil icon-large"> Edit member</i></a>
												</td>
		
									
												</tr>
												<?php } ?>
										</tbody>
									</table>
									</form>
                                </div>
                            </div>
                        </div>
                        <!-- /block -->
                    </div>


                </div>
            </div>
		<?php include('footer.php'); ?>
        </div>
		<?php include('script.php'); ?>
    </body>

</html>