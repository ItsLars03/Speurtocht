$(document).ready(function(){

    /*======================================================================== #
      Beheerderpaneel
    /*=======================================================================*/

    $(".createSPT").click(function(){
        $('.speurtochtenBox').css("display", "none");
        $('.creatingBox').css("display", "block");
        $('.createSPT').css("display", "none");
    });

    // Add another "Vraag toevoegen" field.
    $( document ).on( "click", ".extraField", function() {

        var inputs = $("#createForm > textarea").length;
        console.log(inputs);
        var newIputNumber = inputs + 1;
        console.log($("#createForm > #inputField" + inputs));
        $("#createForm > #inputField" + inputs).after('<textarea class="inputField1" id="inputField' + newIputNumber + '" name="inputField1"></textarea>');

    });
    
    /*======================================================================== #
      Speurtochtpaneel
    /*=======================================================================*/
    // AANPASSEN //
    $(".AanpassenMenu").click(function(){
        $('.speurtochtenBoxMenu').css("display", "none");
        $('.speurtochtAanpassen').css("display", "block");
    });
    // Prevent both options being selected
    $('.one1').click(function(){
        if($(this).prop("checked") == true){
            $( ".two1" ).prop( "checked", false );
        }
    });
    $('.two1').click(function(){
        if($(this).prop("checked") == true){
            $( ".one1" ).prop( "checked", false );
        }
    });
});

// function get_speurtochten() {
//     makeRequest(`${BACKEND}/speurtochten/`, "GET", null).then(data => {
        
//     })
// };