var idMusiqueEnCour;



$(document).ready(function() {

    $( "#report" ).click(function() {

        console.log(idMusiqueEnCour);

            $.ajax({
                type: "GET",
                dataType: "json",
                url: "/report/"+idMusiqueEnCour,
                complete: function(data) {
                    console.log("Report : "+ idMusiqueEnCour );
                }
            });

        $("#msgReport").css({"display" : "block"});

        setTimeout(function(){
            $("#msgReport").css({"display" : "none"});
        }, 2000);
        
    });
});