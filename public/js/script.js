$(function(){ 

    /////////HIDE CHAT///////
    $('.tchat_slide').on('click', function() {   
        $('.tchat_slide i').toggleClass('fa-chevron-down'); 
        $('.tchat_slide i').toggleClass('fa-chevron-up'); 
        $('.tchat_slide').toggleClass('tchat_up'); 
        
        if ($('.tchat_slide').hasClass('tchat_up') ) {            
            $( ".tchat" ).animate({  
                bottom: "-=312",            
                }, 1000, function() {
                // Animation complete.
            });    
        } 
        else if(!$('.tchat_slide').hasClass('tchat_up')) {                                     
            $( ".tchat" ).animate({
                bottom: "+=312",            
                }, 1000, function() {
                // Animation complete.
            });    
        }        
    });
   

   
    
    
    ////////CLOSE CHAT//////  
    $('.tchat_close').on('click', function() {     
        $('.tchat').css('display', 'none'); 
    });

})//jquery