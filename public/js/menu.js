



$(document).ready(function() {
    $( "#checkThemeMusiques" ).click(function() {
        if( $('#checkThemeMusiques').is(':checked') ){
            $(".sousTheme").css({"display" : "block"});
            
            

        } else {
            $(".sousTheme").css({"display" : "none"});

            $(".sousTheme input[type=checkbox]").prop("checked", true);
        }
    });


    $( ".opensetting" ).click(function() {
        $(".formulaire").css({"display" : "block" , "opacity" : "1" , "animation" : "openForm 0.5s"});
    });

    $( ".closeSetting" ).click(function() {
        $(".formulaire").css({"opacity" : "0", "animation" : "closeForm 0.5s"});
        setTimeout(function(){
            $(".formulaire").css({"display" : "none"});
        }, 500)
        
    });

    



});


