



$(document).ready(function() {
    $( "#checkThemeMusiques" ).click(function() {
        if( $('#checkThemeMusiques').is(':checked') ){
            $(".sousTheme").css({"display" : "block"});
            
            

        } else {
            $(".sousTheme").css({"display" : "none"});

            $(".sousTheme input[type=checkbox]").prop("checked", true);
        }
    });
});