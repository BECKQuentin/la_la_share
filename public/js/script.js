$(function(){ 

    /////////HIDE CHAT///////
    $('.tchat_slide').on('click', function() {   
        $('.tchat_slide i').toggleClass('fa-chevron-down'); 
        $('.tchat_slide i').toggleClass('fa-chevron-up'); 
        $('.tchat_slide').toggleClass('tchat_up'); 
        
        if ($('.tchat_slide').hasClass('tchat_up') ) {            
            $( ".tchat" ).animate({  
                bottom: "-=312",            
                }, 600, function() {
                // Animation complete.
            });    
        } 
        else if(!$('.tchat_slide').hasClass('tchat_up')) {                                     
            $( ".tchat" ).animate({
                bottom: "+=312",            
                }, 600, function() {
                // Animation complete.
            });    
        }        
    });
    ////////CLOSE CHAT//////  
    $('.musics_close').on('click', function() {     
        $('.tchat').css('display', 'none'); 
    });

    /////////HIDE MUSICS///////
    $('.musics_slide').on('click', function() {   
        $('.musics_slide i').toggleClass('fa-chevron-left'); 
        $('.musics_slide i').toggleClass('fa-chevron-right'); 
        $('.musics_box').toggleClass('show');               
    });
    /////////HIDE MUSICS///////
    $('.friends_slide').on('click', function() {   
        $('.friends_slide i').toggleClass('fa-chevron-left'); 
        $('.friends_slide i').toggleClass('fa-chevron-right'); 
        $('.friends_box').toggleClass('show');               
    });
    

})//jquery