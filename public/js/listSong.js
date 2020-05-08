var listMusique;

$(document).ready(function() {

        $.ajaxSetup({async: false});
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "/listsong",
            complete: function(data) {
                console.log("blabla");
                listMusique = JSON.parse(data.responseText);
            }
        });
        $.ajaxSetup({async: true});


        listMusique.forEach(element => {
            $(".proposeListeMusique").prepend("<div><div>"+element['titre']+"</div><div>"+element['oeuvre']+"</div><div>"+element['theme']+"</div><div>"+element['sousCat']+"</div><div>"+element['annee']+"</div><div>date</div></div>");
        });


});


function testURL() {
    var str = $('#lien').val();
    var url = new URL(str);
    var name = url.searchParams.get("v");
    $("#urlvideo").val(name);
    $("#videoyoutube").html('<iframe src="https://www.youtube.com/embed/'+name+'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>');
    $(".buttonValideAdd").css({"display" : "block"});
}


