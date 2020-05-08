



$(document).ready(function() {
    $( "#checkThemeMusiques" ).click(function() {
        if( $('#checkThemeMusiques').is(':checked') ){
            $(".sousTheme").css({"display" : "block"});
            
            

        } else {
            $(".sousTheme").css({"display" : "none"});

            $(".sousTheme input[type=checkbox]").prop("checked", true);
        }
    });


    /*=====================Boutton Setting=======================*/
    $( ".opensetting" ).click(function() {
        $(".formulaire").css({"display" : "block" , "opacity" : "1" , "animation" : "openForm 0.5s"});
    });

    $( ".closeSetting" ).click(function() {
        $(".formulaire").css({"opacity" : "0", "animation" : "closeForm 0.5s"});
        setTimeout(function(){
            $(".formulaire").css({"display" : "none"});
        }, 500)
        
    });

    /*=====================Boutton Info=======================*/
    $( "#openInfo" ).click(function() {
        $("#barreInfo").css({"display" : "block"});
        $("#openInfo").css({"display" : "none"});
    });

    $( "#closeInfo" ).click(function() {
        $("#barreInfo").css({"display" : "none"});
        $("#openInfo").css({"display" : "block"});
    });

    /*=====================Signalement=======================*/
    



});


