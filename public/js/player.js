$(function(){ 

    var playerIsOpened = false;
    
    //////DEPLOY TCHAT WINDOW/////
    $(".musics").click(function() {   

        playerIsOpened = true;
        if (playerIsOpened === true) {
            $('.player_musics').css('display', 'flex');
        }

        
        musicsAudio = $(this).data('musicsAudio');        
        musicsImage = $(this).data('musicsImage');
        musicsArtist = $(this).data('musicsArtist');
        musicsTitle = $(this).data('musicsTitle');

        //changer le src des balises audio et image
        $('.player_musics_audio source').attr('src', musicsAudio);
        $('.player_musics_img img').attr('src', musicsImage);        
        $('.player_musics_title_artist p').text(musicsArtist+' - '+musicsTitle);  
        
        $('.player_musics_audio audio').load();
    
    });

    ////////CLOSE PLAYER//////  
    $('.player_musics_menu_close').on('click', function() { 
        $('.player_musics').css('display', 'none'); 
        playerIsOpened = false;
    });

})//jquery