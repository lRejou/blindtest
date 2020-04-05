var listID = [];
var tempsBlindTest = 20000;
var tempsDeLaSolution = 5000;




// Fonction de lancement du jeu
$(document).ready(function() {
    $( "#button-start" ).click(function() {
        
        //Recuperation de la liste des ID des musiques du blind test
        getJson( 20 , ['film']);

        //Lancement du blind test
        StartGame();
        

    });
});






function StartGame(){
    var oneMusique;

    var timer = 0;
    listID.forEach(id => {
            setTimeout(function(){
                oneMusique = getOneMusique(id['id']);
                lancementVideo(oneMusique);
            }, timer);
            timer = timer + tempsBlindTest;
    });
}

function lancementVideo(oneMusique){

    var startVideo = 0;
    var endVideo = startVideo + 50;

    videoActuel = oneMusique['link'];
    player.loadVideoById({
        videoId: videoActuel,
        startSeconds: startVideo,
        endSeconds: endVideo
    });
    decompte(oneMusique);
}

function decompte(oneMusique){
    var time = tempsBlindTest - tempsDeLaSolution;
    time = time/1000;
    timer();
    function timer(){
        setTimeout(function(){
            if(time == 0){
                affichageReponse(oneMusique);
                return;
            }else{
                time = time - 1;
                affichageTimer();
            }
        }, 1000 )
    }

    function affichageTimer(){
        $("#compteur").html(time +'s')
        timer();
    }
}
function affichageReponse(oneMusique){
    console.log(oneMusique);
    $("#reponse").html("<span>"+oneMusique['titre']+"</span> <span>"+oneMusique['oeuvre']+"</span>");

    setTimeout(function(){
        $("#reponse").html("...");
    },tempsDeLaSolution )


}



function getJson(time, tag){
    $.ajaxSetup({async: false});
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "/listsound",
        data: "action=loadall&id=1",
        complete: function(data) {
            listID = JSON.parse(data.responseText);
            console.log("recuperation des ID des musiques...")
        }
    });
    $.ajaxSetup({async: true});
}
function getOneMusique(id){
    console.log('recuperation de la musique' + id);
    var oneMusique;
    $.ajaxSetup({async: false});
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "/onemusique/"+id,
        async: false, 
        complete: function(data) {
            oneMusique = JSON.parse(data.responseText);
        }
    });
    $.ajaxSetup({async: true});
    return oneMusique;
}





