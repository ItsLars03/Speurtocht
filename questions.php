<?php
include("./header.php");
include("./utils/api.php");
//get random question


//Random vraag ophalen.
$getQuestionRes = API::get("/scavengerhunt/questions/random/" . $_COOKIE['player-id'], array());
if (!isset($getQuestionRes) || !isset($getQuestionRes->success) || !$getQuestionRes->success) {
    //error.
    echo "error!";
    return;
}

$question = $getQuestionRes->data;
// var_dump($question);

if (!isset($question)) {
    //handled all questions.
    //TODO: send to next page?

    header("Location: /");
}


function buildTextInputField($questionId) {
    echo "<form action='/server/scavengerHunt/questions/textQuestion.php' method='POST'>";
    echo "<legend>Antwoord:</legend>";
    echo "<textarea name='text-answer'></textarea>";
    echo "<br>";
    echo "<input hidden value='" . $questionId . "' required name='question-id'>";
    echo "<button type='submit' class='login-register-btn' name='submit'>Inleveren</button>";
    echo "</form>";
}

function buildPhotoInputField($questionId) {
    echo "<form action='/server/scavengerHunt/questions/photoQuestion.php' method='POST' enctype='multipart/form-data'>";
    echo "<input type='file' name='image-answer' accept='image/png, image/jpeg'>";
    echo "<br>";
    echo "<input hidden value='" . $questionId . "' required name='question-id'>";
    echo "<button type='submit' name='submit'>Inleveren</button>";
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