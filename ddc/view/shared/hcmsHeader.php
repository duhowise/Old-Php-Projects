<header id="hcms-header">
    <div id="logo"><span class="cala1">H</span><span class="cala2">C</span><span class="cala3">M</span><span class="cala4">S</span>DASHBOARD</div>

    <?
    if(session::get("logged_in")){
    ?>
    <div class="col-4 admin-menu">
        <div class="col-2 handle">
            <div class="handle-icon icon">

            </div>
        </div>
        <div class="col-2 settings">
            <div class="settings-icon glyph icon">
                &#106;
            </div>
            <div class="menu-items">
                <ul class="menu-list">
                    <li>Edit Account</li>
                    <li>Add Admin</li>
                    <li>Delete Admin</li>
                    <li>Delete Content</li>
                    <li><?=$this->htmlAnchor("/hcmsdashboard/logout","Logout")?></li>
                </ul>
            </div>
        </div>
        <div class="col-8">
            <div class="col-9 log">
                Logged in as: <?=session::get("first_name")?>
            </div>

            <div class="col-3 admin">
                <div class="admin-icon glyph icon">
                    &#112;
                </div>
            </div>
        </div>


    </div>
    <?
    }else{

        ?>
        <div id="powered-by">Please Login</div>
    <?
    }
    ?>
    <!---->
</header>