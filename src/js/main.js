
function shorten(url){

    $.ajax({
        url: 'shorten.php',
        data: {"url" : url},
        success: function (response) {//response is value returned from php (for your example it's "bye bye"

            if(response.includes("Error")){
                showError(response);
            }else{
                showNormal(response);
            }


        }
    });

}

function showNormal(msg){
    $("#url").val(msg);
    $("#url").css("color","black");
    $("#url").prop( "disabled",false);
}

function showError(msg){

    $("#url").val(msg);
    $("#url").css("color","red");
    $("#url").prop( "disabled",true);

    setTimeout(function (){

        $("#url").val("");
        $("#url").css("color","black");
        $("#url").prop( "disabled",false);

    },1500);
}

function validateUrlAndShorten(){

    var url = $("#url").val();

    if(url.length > 0 && url.includes(".") && url.includes("https://") || url.includes("http://")){

        $("#url").val("Converting...");
        $("#url").css("color","#25d985");
        $("#url").prop( "disabled",true);

        setTimeout(function (){

            shorten(url);

        },500);


    }else{
        showError("Please enter a valid url");
    }
}


$("#shortenButton").click(function (){

    validateUrlAndShorten();

});

$("#url").keyup(function(e){
    if(e.keyCode == 13)
    {
        validateUrlAndShorten();
    }
});