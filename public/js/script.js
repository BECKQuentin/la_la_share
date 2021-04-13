
$(function(){  
  
    
    /////////HIDE MUSICS BOX///////
    $('.musics_slide').on('click', function() {
        $('.main').removeClass('col-10')   
        $('.musics_slide i').toggleClass('fa-chevron-left'); 
        $('.musics_slide i').toggleClass('fa-chevron-right'); 
        $('.musics_box').toggleClass('show');
        $('.musics_box').toggleClass('hide');         
        $('.main').toggleClass('offset-lg-2'); 
        $('.main').toggleClass('offset-lg-1');            
        $('.main').toggleClass('col-9'); 
        $('.main').toggleClass('col-8');
        ////////HIDE MUSICS BOX && FRIENDS BOX////////
        if( ($('.friends_box').hasClass('hide')) && ($('.musics_box').hasClass('hide')) ) {            
            $('.main').addClass('col-10');            
        }               
    });

    /////////HIDE FRIENDS BOX///////
    $('.friends_slide').on('click', function() {
        $('.main').removeClass('col-10')   
        $('.friends_slide i').toggleClass('fa-chevron-left'); 
        $('.friends_slide i').toggleClass('fa-chevron-right'); 
        $('.friends_box').toggleClass('show'); 
        $('.friends_box').toggleClass('hide');        
        $('.main').toggleClass('col-9');
        $('.main').toggleClass('col-8');         
        ////////HIDE MUSICS BOX && FRIENDS BOX////////
        if( ($('.friends_box').hasClass('hide')) && ($('.musics_box').hasClass('hide')) ) {            
            $('.main').addClass('col-10');                        
        }             
    });

    ////////CLOSE AUDIO///////////
    $('.player_musics_menu_close').on('click', function() {
        $('.player_musics').css('display', 'none');
    })   

})//jquery