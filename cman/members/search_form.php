
<!-----------------------------------------------Advance Search Form modal --------------------------------------------------->
<div id="mymodal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="mymodalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
<h3 id="mymodalLabel">Advance Search Form</h3>
</div>

<div class="modal-body">
    <form class="form-horizontal" method="post" action="search.php">
	
	          <div class="control-group">
		      <label class="control-label" for="inputEmail">mobile Number</label>
			  <div class="controls">
			  <input class="input focused" name="username" id="focusedInput" type="text" placeholder = "mobile Number" required>
			  <?php

			  require_once('..\dbconnect.php');
			  $query="select * from members";
			  $result=$mysqli->query($query);
			 while($user_row=$result->fetch_assoc()){			
				?>
			  			  <?php } ?>
			  </select>
		      </div>
	          </div>
							
			
			  			  			
			  
												
                <div class="control-group">
                <div class="controls">
                <button type="submit" id="search" data-placement="left" title="Click to Search" class="btn btn-primary"><i class="icon-search"></i> Search</button>
				 <script type="text/javascript">
		        $(document).ready(function(){
		        $('#search').tooltip('show');
		        $('#search').tooltip('hide');
		        });
		        </script> 
                </div>
                </div>
				
    </form>
</div>

<div class="modal-footer">
<button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i> Close</button>
</div>
</div>