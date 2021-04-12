
$(function(){      

    var playerIsOpened = false;

   
    //////DEPLOY TCHAT WINDOW/////
    $(".musics").click(function() {   

        $('.area_player').css('display', 'none');

        playerIsOpened = true;
        if (playerIsOpened === true) {  
            $('.player_musics').css('display', 'flex');
        }

        musicsAudio = $(this).data('musicsAudio');        
        musicsImage = $(this).data('musicsImage');
        musicsArtist = $(this).data('musicsArtist');
        musicsTitle = $(this).data('musicsTitle');

        //changer le src des balises audio et image
        $('.player_musics_img img').attr('src', musicsImage);        
        $('.player_musics_audio audio').attr('src', musicsAudio);        
        $('.player_musics_title_artist p').text(musicsArtist+' - '+musicsTitle); 

        $('#player')[0].load();
        setTimeout(() => {
            $('#player')[0].play();
            $('#player').prop('volume', 0.3);
        }, 800);
    });

    ////////CLOSE PLAYER//////  
    $('.player_musics_menu_close').on('click', function() { 
        $('#player').trigger('pause');
        $('.player_musics').css('display', 'none'); 
        playerIsOpened = false;

        $('.area_player').css('display', 'flex');
        
    });

})//jquery