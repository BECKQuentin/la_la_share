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
        $('.main').removeClass('col-10')   
        $('.musics_slide i').toggleClass('fa-chevron-left'); 
        $('.musics_slide i').toggleClass('fa-chevron-right'); 
        $('.musics_box').toggleClass('show');
        $('.musics_box').toggleClass('hide'); 
        window.setTimeout(function() {
            $('.main').toggleClass('offset-lg-2') 
            $('.main').toggleClass('offset-lg-1')
            $('.main').toggleClass('col-8')
            $('.main').toggleClass('col-9') 
        }, 100);
        ////////HIDE MUSICS && FRIENDS////////
        if( ($('.friends_box').hasClass('hide')) && ($('.musics_box').hasClass('hide')) ) {
            $('.main').addClass('col-10')
            $('.main').removeClass('col-8') 
        }   
                       
    });
    /////////HIDE FRIENDS///////
    $('.friends_slide').on('click', function() {
        $('.main').removeClass('col-10')   
        $('.friends_slide i').toggleClass('fa-chevron-left'); 
        $('.friends_slide i').toggleClass('fa-chevron-right'); 
        $('.friends_box').toggleClass('show'); 
        $('.friends_box').toggleClass('hide'); 
        window.setTimeout(function() {
            $('.main').toggleClass('col-8')
            $('.main').toggleClass('col-9') 
        }, 100); 
        ////////HIDE MUSICS && FRIENDS////////
        if( ($('.friends_box').hasClass('hide')) && ($('.musics_box').hasClass('hide')) ) {
            $('.main').addClass('col-10')
            $('.main').removeClass('col-8')            
        }
             
    });
   

    

})//jquery