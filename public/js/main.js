var listID = [];
var tempsBlindTest = 20000;
var tempsDeLaSolution = 5000;
var difficulte = 0000;
var theme = [];
var soustheme = [];

var numMusiqueActuel = 0 ;

var pauseAndPlay = 0;
var pauseActive = 0;


function loadVideoYoutube(){
    player.loadVideoById({
        videoId: videoActuel,
        startSeconds: startVideo,
        endSeconds: endVideo
    });
}

function fairePause(){
    if(pauseAndPlay == pauseActive){
        if(pauseAndPlay == 0){
            pauseAndPlay = 1;
            $("#pause").html("<div class='buttonPlay'><i class='far fa-play-circle'></i></div>");
            $("#pause").css({"display" : "none"});
            $(".messagePause").css({"display" : "block"});
        }else{
            pauseAndPlay = 0;
            pauseActive = 0;
            startGame();
            $("#pause").html("<div class='buttonPause'><i class='far fa-pause-circle'></i></div>");
            $(".messagePause").css({"display" : "none"});
        }
    }
}

// Fonction de lancement du jeu
$(document).ready(function() {
    $( "#button-start" ).click(function() {
        initConfig();
        //Recuperation de la liste des ID des musiques du blind test
        getJson();

        //Lancement du blind test
        startGame();
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

        //Sous Theme
        if($('#checkThemeAutre').is(':checked')){
            soustheme.push("autre");
        }
        if($('#checkThemeFrancais').is(':checked')){
            soustheme.push("francais");
        }
        if($('#checkThemePopulaire').is(':checked')){
            soustheme.push("populaire");
        }
        if($('#checkThemerap').is(':checked')){
            soustheme.push("rap");
        }
        if($('#checkThemeRock').is(':checked')){
            soustheme.push("rock");
        }
        if($('#checkThemePunk').is(':checked')){
            soustheme.push("punk");
        }
        if($('#checkThemeMetal').is(':checked')){
            soustheme.push("metal");
        }
        if($('#checkThemeReggae').is(':checked')){
            soustheme.push("reggae");
        }
        if($('#checkThemeElectro').is(':checked')){
            soustheme.push("electro");
        }
        if($('#checkThemeJazz').is(':checked')){
            soustheme.push("jazz");
        }
        if($('#checkThemeContry').is(':checked')){
            soustheme.push("contry");
        }
        if($('#checkThemeNewwave').is(':checked')){
            soustheme.push("newwave");
        }


        //Apparation button play Pause
        $("#pause").css({"display" : "flex"});


        $(".formulaire").hide();
        $("#button-start").hide();

    }


    function startGame(){
        boucle();
        var tempsBoucle = 0;
        function boucle(){
            setTimeout(function(){
                tempsBoucle = tempsBlindTest;
                if(pauseAndPlay == 1){
                    $("#pause").css({"display" : "flex"});
                    $(".messagePause").css({"display" : "none"});
                    pauseActive = 1;
                    return;
                }
                else{
                    runSong();
                }
            }, tempsBoucle);
        }

        function runSong(){
            console.log("playMusique");

            idmusique = listID[numMusiqueActuel];
            oneMusique = getOneMusique(idmusique['id']);
            lancementVideo(oneMusique);
            numMusiqueActuel ++;
            boucle();
        }
    }

    //Ancienne fonction pas ouf, mais je la garde sous la main... On sait jamais
    /*function startGame(){
        var oneMusique;

        var timer = 0;
        listID.forEach(id => {
                setTimeout(function(){
                    oneMusique = getOneMusique(id['id']);
                    lancementVideo(oneMusique);
                }, timer);
                timer = timer + tempsBlindTest;
            sleep(1000);
        });

    }*/

    function sleep(milliseconds) {
        var start = new Date().getTime();
        for (var i = 0; i < 1e7; i++) {
        if ((new Date().getTime() - start) > milliseconds){
            break;
        }
        }
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
        $("#reponse").html(" <span class='oeuvre'>"+oneMusique['oeuvre']+"</span><span class='titre'>"+oneMusique['titre']+"</span><span class='description'>"+oneMusique['description']+"</span>");
        //$("#reponse").html(" <span class='oeuvre'>"+oneMusique['oeuvre']+"</span><span class='titre'>Sophie, tu bois 10 gorgées</span>");

        setTimeout(function(){
            $("#reponse").html("...");
        },tempsDeLaSolution )
    }




