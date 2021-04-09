$(function(){  
    
    var getMessageUrl;
    var sendMessageUrl;    
    var tchatIsOpened = false;
    var tchatIsHide = false;

    //////DEPLOY TCHAT WINDOW/////
    $(".friends").click(function() {        
        tchatIsOpened = true;
        //recuper id/friend
        getMessageUrl = $(this).data('getMessageUrl');        
        sendMessageUrl = $(this).data('sendMessageUrl');
        //afficher donnees id dans menu du tchat
        $('#tchat h5').text($(this).data('friendPseudo'));        
        $('.tchat_menu_info img').attr('src', $(this).data('friendImage'));
        loadMessages(); 
        if (tchatIsOpened === true) {
            $('.tchat').css('display', 'block');
        }      
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

    ////////CLOSE TCHAT//////  
    $('.tchat_close').on('click', function() { 
        $('.tchat').css('display', 'none'); 
        tchatIsOpened = false;
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
        var timeMessage = '';       
        messages.forEach(message => {            
            if (message.mySend === true) {
                html += `<div class='myMessage'>
                            <div>`+message.message+`</div>
                        </div>`;                                
            }
            else if (message.mySend === false) {
                html += `<div class='friendMessage'>
                            <div>`+message.message+`</div>                            
                        </div>`;
            }  
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