<?php
include("./header.php");
include("./utils/api.php");
//get random question


//Random vraag ophalen.
$getQuestionRes = API::get("/scavengerhunt/questions/random/" . $_COOKIE['player-id'], array());
if (!isset($getQuestionRes) || !isset($getQuestionRes->success) || !$getQuestionRes->success) {
    //error.
    return;
}

$question = $getQuestionRes->data;
// var_dump($question);

if (!isset($question)) {
    //handled all questions.
    //TODO: send to next page?

    $playerRes = API::get("/scavengerhunt/players/player/" . $_COOKIE['player-id'], array());
    if (!isset($playerRes) || !isset($playerRes->success) || !$playerRes->success) {
        //error.
        return;
    }


    header('Location: results.php?id=' . $playerRes->data->scavengerHuntId);
    return;
}


function buildTextInputField($questionId)
{
    echo "<form action='/server/scavengerHunt/questions/textQuestion.php' method='POST'>";
    echo "<legend>Antwoord:</legend>";
    echo "<textarea class='text-answer' name='text-answer'></textarea>";
    echo "<br>";
    echo "<input hidden value='" . $questionId . "' required name='question-id'>";
    echo "<button type='submit' class='login-register-btn deliver' name='submit'>Inleveren</button>";
    echo "</form>";
}

function buildPhotoInputField($questionId)
{
    echo '
    <img class="img-question" src="/upload-an-image.png" id="output"/>
    <script>
      var loadFile = function(event) {
        var output = document.getElementById("output");
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
          URL.revokeObjectURL(output.src) // free memory
        }
      };
    </script>';
    echo "<form action='/server/scavengerHunt/questions/photoQuestion.php' method='POST' enctype='multipart/form-data'>";
    echo "<input type='file' onchange='loadFile(event)' name='image-answer' accept='image/png, image/jpeg'>";
    echo "<br>";
    echo "<input hidden value='" . $questionId . "' required name='question-id'>";
    echo "<button class='login-register-btn deliver' type='submit' name='submit'>Inleveren</button>";
    echo "</form>";
}

?>

<div class="content">
    <div class="titleBox">
        <h2 class="pageTitle">
            <?php echo $question->question ?>
        </h2>
    </div>


    <?php $question->type == "TEXT" ? buildTextInputField($question->questionId) : buildPhotoInputField($question->questionId) ?>

</div>