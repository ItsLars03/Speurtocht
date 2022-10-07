<?php
include("../../../utils/api.php");

if ($_SERVER["REQUEST_METHOD"] != "POST") return;

if (!isset($_POST['submit']) || !isset($_POST['question-id']) || !isset($_FILES['image-answer'])) {
    //invalid request.
    //TODO: handle error.
    return;
}

$response = API::postFile("/scavengerhunt/answers/image", [
    "questionId" => $_POST['question-id'],
    "playerId" => $_COOKIE['player-id'],
], $_FILES['image-answer']['tmp_name'], $_FILES['image-answer']['type'], $_FILES['image-answer']['name']);

// $response = API::postFile("/scavengerhunt/answers/image", [
//     "questionId" => "1690a4a7-1431-43a8-a9e6-1b9bbe42c68f",
//     "playerId" => "ad847192-a055-4e12-bcf0-5f4a0478c98c",
//     "correct" => true,
// ], $_FILES['image']['tmp_name'], $_FILES['image']['type'], $_FILES['image']['name']);

if (!isset($response) || !isset($response->success) || !$response->success) {
    //TODO: handle error.

    return;
}


header("Location: /questions.php");