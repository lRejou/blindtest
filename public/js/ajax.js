/*function getJson(time, tag){
    $.ajaxSetup({async: false});
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "/listsound/"+difficulte+"/"+theme,
        complete: function(data) {
            listID = JSON.parse(data.responseText);
            console.log("recuperation des ID des musiques...")
        }
    });
    $.ajaxSetup({async: true});
}*/

function getJson(){

    var dataPage = 'diff=' + difficulte + '&theme=' + theme + '&soustheme=' + soustheme  ;

    //var dataPage = $(dataPage).serialize();


    $.ajaxSetup({async: false});
    $.ajax({
        type: "POST",
        dataType: "json",
        data : dataPage,
        url: "/listsound",
        complete: function(data) {
            listID = JSON.parse(data.responseText);
            nbMusique = listID.length;
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