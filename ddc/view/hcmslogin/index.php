<div class="grid-container">
    <div class="col-12">
        <div class="col-4"></div>
        <div class="col-4">
            <div id="login-form-cont">
                <div id="login-banner">
                    <H2><span>
                        <span class="cala1">H</span><span class="cala2">C</span><span class="cala3">M</span><span class="cala4">S</span> LOGIN </span></H2>
                </div>
                <form id="login-form" action="<?=DOMAIN_NAME?>/hcmsdashboard/login" method="post">
                    <div class="form-field">
                        <input type="text" name ="username" placeholder ="Username" data-field ="Please enter your Username"/>
                    </div>
                    <div class="form-field">
                        <input type="password" name ="password-text" placeholder="Password" data-field ="Please enter your Password (more than 6 chars)"/>
                        <input type="hidden" name="password" value=""/>
                    </div>
                    <div class="form-field">
                        <button class="btn" type="submit" name="login-submit">Login</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-4"></div>
    </div>

</div>

<?php $this->htmlScript('controllers/hcmsdashboard_login.controller.js','text/javascript')?>