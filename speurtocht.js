$(document).ready(function(){

    /*======================================================================== #
      Beheerderpaneel
    /*=======================================================================*/

    $(".createSPT").click(function(){
        $('.speurtochtenBox').css("display", "none");
        $('.creatingBox').css("display", "block");
    });

    $('.one').click(function(){
        if($(this).prop("checked") == true){
            $( ".two" ).prop( "checked", false );
        }
    });
    $('.two').click(function(){
        if($(this).prop("checked") == true){
            $( ".one" ).prop( "checked", false );
        }
    });
    
});