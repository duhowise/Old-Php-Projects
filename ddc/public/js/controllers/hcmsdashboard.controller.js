

(function($){
    $(function(){
        Controller.create("hcmsdashboardCntrl",{
            elements:{page:"aside ul li", container_wrp:".container-wrapper", forms:"form",body:"body"},
            events:{
                click:[{target:"page", handler:"page_click"}],
                submit:[{target:"forms", handler:"upload"}]
            },
            init: function(){
                this.hide();

            },
            page_click: function(e){
                var that = e.data.that;
                if(!$(this).hasClass("current")){
                    var pagename = $(this).attr("data-page");
                    that.page.each(function(){
                        $(this).removeClass("current");
                    });
                    $(this).addClass("current");
                    that.container_wrp.each(function(){
                        $(this).fadeOut(0);
                    });
                    that.container_wrp.each(function(){
                        if($(this).attr("data-page") == pagename)
                            $(this).fadeIn(600)
                    });
                }
            },
            hide: function(){
                var pagename='';
                this.page.each(function(){
                    if($(this).hasClass("current")){
                        pagename = $(this).attr("data-page");
                    }
                });
                this.container_wrp.each(function(){
                    if($(this).attr("data-page") != pagename){
                        $(this).fadeOut(0);
                    }
                });
            },
            upload: function(e){
                var that = e.data.that,
                count = 0,
                pod_check= 0,
                    double_check = 0;

                $(this).find(".container-pod").each(function(){
                    var num_fields = $(this).find("input,textarea").not("input[type=hidden]").length;
                    if (num_fields == 2){
                        //the container pod has two fields
                        $(this).find("input,textarea").each(function(){
                            if(this.value == ""){
                                ++count
                            }
                        });
                        //one of the two fields is empty
                        if(count == 1){
                            ++double_check;
                        }
                    }else if(num_fields == 1){
                        //the container pod has only one field
                        $(this).find("input,textarea").each(function(){
                            if(this.value == ""){
                                ++count
                            }
                        });
                    }

                    if(count > 0){
                        ++pod_check;
                        count = 0;
                    }
                });
                return (pod_check != $(this).find(".container-pod").length && double_check == 0);

            }
        });
    });
})(window.jQuery);
