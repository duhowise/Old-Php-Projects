<div class="container-fluid" id="modal-parent">
    <div class="modal fade in" id="mymodal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Adminsitrator login</h3>
                </div>
                <div class="modal-body">
                    <?-form_open('/pages/home')?>
                    <div class="form-group">
                        <!--                    <label for="exampleInputEmail1">Email address</label>-->
                        <input type="email" class="form-control" id="" placeholder="Enter Username">
                    </div>
                    <div class="form-group">
                        <!--                    <label for="">Password</label>-->
                        <input type="password" class="form-control" id="" placeholder="Enter Password">
                    </div>

                    <button type="submit" class="btn btn-default pull-right">login</button>
                    <?=form_close()?>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>
</div>

</div>
