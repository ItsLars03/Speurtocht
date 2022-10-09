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
    // back button
    $(".backButton").click(function(){
        $('.speurtochtenBoxMenu').css("display", "flex");
        $('.speurtochtAanpassen').css("display", "none");
        $('.speurtochtStart').css("display", "none");
        $('.speurtochtDelete').css("display", "none");
        $('.speurtochtControle').css("display", "none");
        $('.speurtochtDeelnemer').css("display", "none");
        $('.backButton2').css("display", "block");
        $('.backButton').css("display", "none");
    });
    $(".backButton2").click(function(){
        window.location.href = '/admin/beheerderpaneel.php';
        // $('.backButton').css("display", "none");
    });
    

    // START //
    $(".startMenu").click(function(){
        $('.speurtochtenBoxMenu').css("display", "none");
        $('.speurtochtStart').css("display", "block");
        $('.backButton').css("display", "block");
        $('.backButton2').css("display", "none");
    });
    // AANPASSEN //
    $(".AanpassenMenu").click(function(){
        $('.speurtochtenBoxMenu').css("display", "none");
        $('.speurtochtAanpassen').css("display", "block");
        $('.backButton2').css("display", "none");
        $('.backButton').css("display", "block");
    });
    // CONTROLEREN //
    $(".resultMenu").click(function(){
        $('.speurtochtenBoxMenu').css("display", "none");
        $('.speurtochtControle').css("display", "block");
        $('.backButton2').css("display", "none");
        $('.backButton').css("display", "block");
    });
    // DEELNEMER
    $(".deelnemerMenu").click(function(){
        $('.speurtochtenBoxMenu').css("display", "none");
        $('.speurtochtDeelnemer').css("display", "block");
        $('.backButton').css("display", "block");
        $('.backButton2').css("display", "none");
    });
    // DELETE //
    $(".deleteMenu").click(function(){
        $('.speurtochtenBoxMenu').css("display", "none");
        $('.speurtochtDelete').css("display", "block");
        $('.backButton').css("display", "block");
        $('.backButton2').css("display", "none");
    });

    // Prevent both options being selected
    $('.one1').click(function(){
        if($(this).prop("checked") == true){
            //$(this).closest( ".two1" ).prop( "checked", false );
            $(this).closest('#editQuestion').find('.two1').prop( "checked", false );
            $('#createForm .two1').prop( "checked", false );
        }
    });
    $('.two1').click(function(){
        if($(this).prop("checked") == true){
            //$(this).closest( ".one1" ).prop( "checked", false );
            $(this).closest('#editQuestion').find('.one1').prop( "checked", false );
            $('#createForm .one1').prop( "checked", false );
        }
    });
});

// function get_speurtochten() {
//     makeRequest(`${BACKEND}/speurtochten/`, "GET", null).then(data => {
        
//     })
// };