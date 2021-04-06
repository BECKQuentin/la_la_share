$(function(){    

    var getMessageUrl;
    var sendMessageUrl;
    var tchatIsOpened = false;

    //////DEPLOY TCHAT WINDOW/////
    $(".friends").click(function() { 
        tchatIsOpened = true;
        //recuper id/friend et afficher dans titre du tchat
        getMessageUrl = $(this).data('getMessageUrl');
        sendMessageUrl = $(this).data('sendMessageUrl');
        $('#tchat h5').text($(this).data('friendPseudo'));
        loadMessages();  
        console.log(tchatIsOpened);
        if (tchatIsOpened === true) {
            $('.tchat').css('display', 'block');
        }      
    });
    //////ACTUALISATION OF MESSAGES/////
    setInterval(function(){                
        if( tchatIsOpened === true) {
            loadMessages();
        }
    }, 10000);    


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
    } 
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
    
    //////ADD MESSAGE//////
    $(".conversation_input_icon_btn").click(function(){
        var inpt = $.trim($("#inpt_message").val()); 
        sendMessage(inpt);   
        loadMessages();      
        $('#inpt_message').val('');        
    });

    /////////HIDE TCHAT///////
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
    ////////CLOSE TCHAT//////  
    $('.tchat_close').on('click', function() { 
        $('.tchat').css('display', 'none'); 
        tchatIsOpened = false;
    });
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