!function ($) {
    $(function(){        
        //side bar affixing declaration     
        affix.check('#side-bar-container',{top: 179, bottom: 150})     
        search_engine.find('#searchtextfield', '#search-button', '#admission-list table') 
        
        // page slideshow start
        $('.carousel').carousel({interval: 6000}) 
        
        //content caption animation
        $('.content-pod').hover(
            function(){
                var caption = $(this).find('.caption')
                $(caption).stop(true).animate({ bottom: '14em' },600)
            },//mouse in
            function(){
                var caption = $(this).find('.caption')
                $(caption).stop(true).animate({bottom: '4.1em' },600)
            }) //mouse out        
    })
}(window.jQuery)
    
var affix = {
    check :function(element,offset){
        $(window).scroll(function(){
            var scrolltop = $(window).scrollTop(),
            scrollhieght = $(document).height(),
            height = $(element).height()
            if(scrolltop >= offset.top ) {                   
                $(element).addClass('pinned')
            }else if(scrolltop < offset.top ){
                $(element).removeClass('pinned tops')
            }           
            if(scrolltop + height >= scrollhieght-offset.bottom){
                $(element).addClass('bottoms')
            }else if(scrolltop + height < scrollhieght-offset.bottom){
                $(element).removeClass('bottoms')
            }                  
            return false;
        })
    }
}

var search_engine = {
    find : function(textbx,btn,field) {
        var $textbx =  $(textbx),$btn = $(btn) ,$field = $(field),found=false
        $btn.click(function(){ 
            if($textbx.val() != '' &&$textbx.val() != ' '){
                $field.find('tr').children('td:first-child').each(function(){
                    $(this).parent().removeClass('found')
                    if($(this).text() == $textbx.val()){
                        $(this).parent().addClass('found')                
                        $(window).scrollTop($(this).offset().top - 300)
                        found = true
                    }
                })//end of loop
                if(found == false){
                    $('body').append('<div id="no-name">Sorry, your name could not be found in the list</div>')            
                    $('#no-name').fadeIn(1000)
                    setTimeout("$('#no-name').fadeOut(1000,function(){$(this).remove()})",7000)
                }
                $textbx.attr('placeholder','please enter your name')
            }else{
                $textbx.attr('placeholder','you havn\'t entered your name')
            }           
            found = false
            return false
        });//end of click  
    } 
}


!function($){
    $(function(){
        // Iterate over an array (typically a jQuery object, but can
        // be any array) and call a callback function for each
        // element, with a time delay between each of the callbacks.
        // The callback receives the same arguments as an ordinary
        // jQuery.each() callback.
        $.slowEach = function( array, interval, callback ) {
            if( ! array.length ) return;
            var i = 0;
            next();
            function next() {
                if( callback.call( array[i], i, array[i] ) !== false )
                    if( ++i < array.length )
                        setTimeout( next(), interval );
            }
            return array;
        };
        // Iterate over "this" (a jQuery object) and call a callback
        // function for each element, with a time delay between each
        // of the callbacks.
        // The callback receives the same arguments as an ordinary
        // jQuery(...).each() callback.
        $.fn.slowEach = function( interval, callback ) {
            return $.slowEach( this, interval, callback );
        };
    })
}(window.jQuery)
