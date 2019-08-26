(function($){
    $(function(){
        Controller.create("hcmsdashboardLoginCntrl",{
            elements:{login_form:"#login-form",body:"body"},
            events:{},
            init: function(){
                this.form_validate(this.login_form);
            }
        });
    });
})(window.jQuery);




