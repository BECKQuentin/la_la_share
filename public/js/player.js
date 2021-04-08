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
        $('.player_musics_img img').attr('src', musicsImage);        
        $('.player_musics_audio audio').attr('src', musicsAudio);        
        $('.player_musics_title_artist p').text(musicsArtist+' - '+musicsTitle); 

        $('#player')[0].load();
        setTimeout(() => {
            $('#player')[0].play();
            $('#player').prop('volume', 0.3);
        }, 800);

        // var html = `<audio controls preload="auto" id="player">
        //                 <source src="${musicsAudio}" type="audio/mp3">
        //             </audio>`;
        // $('.player_musics_audio').html(html);

        // setTimeout(() => {            
        //     $('#player')[0].play();
        //     $('.audio').prop(volume, 0.5);
        // }, 500);
    });

    ////////CLOSE PLAYER//////  
    $('.player_musics_menu_close').on('click', function() { 
        $('.player_musics').css('display', 'none'); 
        playerIsOpened = false;
    });

})//jquery