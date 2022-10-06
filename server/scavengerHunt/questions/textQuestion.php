<?php
include("../../../utils/api.php");

if ($_SERVER["REQUEST_METHOD"] != "POST") return;

if (!isset($_POST['submit']) || !isset($_POST['text-answer']) || !isset($_POST['question-id'])) {
    //invalid request.
    //TODO: handle error.
    return;
}

$response = API::post("/scavengerhunt/answers/", [
    "questionId" => $_POST['question-id'],
    "playerId" => $_COOKIE['player-id'],
    "answer" => $_POST['text-answer'],
]);

if (!isset($response) || !isset($response->success) || !$response->success) {
    //TODO: handle error.

    return;
}


header("Location: /questions.php");