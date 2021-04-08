$(function(){ 

    var playerIsOpened = false;
    
    //////DEPLOY TCHAT WINDOW/////
    $(".musics").click(function() {   

        playerIsOpened = true;
        if (playerIsOpened === true) {
            $('.player_musics').css('display', 'block');
        }
       
        musicsAudio = $(this).data('musicsAudio');        
        musicsImage = $(this).data('musicsImage');

        //changer le src des balises audio
        $('#tchat h5').text($(this).data('friendPseudo'));
        $('.tchat_menu_info img').attr('src', $(this).data('friendImage'));
        loadMessages();  
        console.log(tchatIsOpened);
         

    });

    // //////CONTACT ADMIN MEMBER///////
    // $('.admin_contact').click(function() {
    //     tchatIsOpened = true;
    //     //recuperer * role admin 
    //     getMessageUrl = $(this).data('getMessageUrl');        
    //     sendMessageUrl = $(this).data('sendMessageUrl');        
    //     //afficher donnees dans menu du tchat
    //     $('#tchat h5').text($(this).data('admindPseudo'));
    //     $('.tchat_menu_info img').attr('src', $(this).data('adminImage'));
    //     loadMessages();  
    //     console.log(tchatIsOpened);
    //     if (tchatIsOpened === true) {
    //         $('.tchat').css('display', 'block');
    //     }
    // });

    ////////CLOSE PLAYER//////  
    $('.player_musics_menu_close').on('click', function() { 
        $('.player_musics').css('display', 'none'); 
        playerIsOpened = false;
    });

    ////////SHOW TCHAT WHEN CLICK///////   
        $('.friends').on('click', function() {
            if (tchatIsHide === true) {
                $( ".tchat" ).animate({
                    bottom: "+=312",            
                    }, 600, function() {
                        //animation complete
                    tchatIsHide = false;
                });  
            }
        })   

    //////ACTUALISATION OF MESSAGES/////
    setInterval(function(){                
        if( tchatIsOpened === true) {
            loadMessages();
        }
    }, 10000);    


    //////FUNCTION////////
    function sendMessage(message) {
        $.ajax({        
            url : sendMessageUrl,  
            type : 'POST',     
            dataType : 'json',
            data : {                
                message : message
            },
            success : function(statut){           
                loadMessages();
            }, 
        })
    }

    function loadMessages() {
        $.ajax({
            url : getMessageUrl,
            type : 'GET',
            dataType : 'json',
            success : function(messages, statut){           
                viewMessages(messages);                
            },    
            error : function(resultat, statut, erreur){    
            }    
         }); 
    }
    
    function viewMessages(messages) {
        var html = '';
        messages.forEach(message => {
            html += "<div>"+message.message+"</div>";
        });        
        $('.conversation_output').html(html); 
        ///scroll bottom of tchat
        $('.conversation_output').scrollTop(1000); 
    } 

    function slideTchat() {
        $('.tchat_slide i').toggleClass('fa-chevron-down'); 
        $('.tchat_slide i').toggleClass('fa-chevron-up');
        
        if (tchatIsHide === false ) {            
            $( ".tchat" ).animate({  
                bottom: "-=312",            
                }, 600, function() {
                //animation complete
                tchatIsHide = true;
            });                
        } 
        else if(tchatIsHide === true) {                                     
            $( ".tchat" ).animate({
                bottom: "+=312",            
                }, 600, function() {
                    //animation complete
                tchatIsHide = false;
            });    
        }      
    }
    
    //////ADD MESSAGE//////
    $(".conversation_input_icon_btn").click(function(){
        var inpt = $.trim($("#inpt_message").val());
        if(inpt !== '') {
            sendMessage(inpt);   
            loadMessages();      
            $('#inpt_message').val('');     
        } 
    });

    
    /////////HIDE TCHAT///////
    $('.tchat_slide').on('click', function() {  
        slideTchat(); 
    });  

})//jquery






})//jquery