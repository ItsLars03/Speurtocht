<?php
include("./header.php");
include("./utils/api.php");

//get random question


//Random vraag ophalen.
$getQuestionRes = API::get("/scavengerhunt/questions/random/" . $_COOKIE['player-id'], array());
if (!isset($getQuestionRes) || isset($getQuestionRes->success) || !$getQuestionRes->success) {
    //error.
    return;
}

$question = $getQuestionRes->data;

var_dump($getQuestionRes);


//Text vraag beantwoorden
$answerRes = API::post("/scavengerhunt/answers/", [
    "questionId" => $question->questionId,
    "playerId" => $_COOKIE['player-id'],
    "answer" => "answer here.",
]);

if (!isset($answerRes) || isset($answerRes->success) || !$answerRes->success) {
    //error.
    return;
}

$answer = $answerRes->data;

//Foto vraag beantwoorden
$photoAnswerRes = API::postFile("/scavengerhunt/answer/photo", [], "", "", "");
