var listID = [];
var tempsBlindTest = 20000;
var tempsDeLaSolution = 5000;
var difficulte = 0000;
var theme = [];




// Fonction de lancement du jeu
$(document).ready(function() {
    $( "#button-start" ).click(function() {
        
        initConfig();

        //Recuperation de la liste des ID des musiques du blind test
        getJson( 20 , ['film']);

        //Lancement du blind test
        StartGame();
        

    });
});

function initConfig(){
    //Temps du blind test
    valDureeMusique = $("#dureeMusique").val();
    tempsBlindTest = parseInt(valDureeMusique) * 1000;

    //Temps pour trouver les réponses
    valDureeReponse = $("#dureeReponse").val();
    tempsDeLaSolution = parseInt(valDureeReponse) * 1000;

    //Difficulté
    if($('#checkDiff1').is(':checked')){
        difficulte = difficulte + 1;
    }
    if($('#checkDiff2').is(':checked')){
        difficulte = difficulte + 10;
    }
    if($('#checkDiff3').is(':checked')){
        difficulte = difficulte + 100;
    }
    if($('#checkDiff4').is(':checked')){
        difficulte = difficulte + 1000;
    }


    //Theme
    if($('#checkThemeFilms').is(':checked')){
        theme.push("film");
    }
    if($('#checkThemeMusiques').is(':checked')){
        theme.push("musique");
    }
    theme = theme.join('!');



    $(".formulaire").hide();
    $("#button-start").hide();

}




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

    var startVideo = oneMusique['timeur'];
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
        $("#compteur").html(time)
        timer();
    }
}
function affichageReponse(oneMusique){
    console.log(oneMusique);
    $("#reponse").html(" <span class='oeuvre'>"+oneMusique['oeuvre']+"</span><span class='titre'>"+oneMusique['titre']+"</span>");
    //$("#reponse").html(" <span class='oeuvre'>"+oneMusique['oeuvre']+"</span><span class='titre'>Sophie, tu bois 10 gorgées</span>");

    setTimeout(function(){
        $("#reponse").html("...");
    },tempsDeLaSolution )


}

