<div class="container-fluid  text-center pagination-centered col-sm-6 col-sm-offset-3">
    <div class="row-fluid">
        <div class="panel panel-primary centering " >
            <div class="panel-heading">
                <h3 class="panel-title">Administrators login</h3>
            </div>
            <div class="panel-body">
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
        </div>

    </div>
</div>