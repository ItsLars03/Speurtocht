<?php
include('../utils/api.php');


//TODO
if (!isset($_GET["email"]) || !isset($_GET['name']) || !isset($_GET['scavengerhuntid'])) {
    //TODO: handle error
    return;
}

$response = API::post("/scavengerhunt/players/", [
    "scavengerHuntId" => $_GET['scavengerhuntid'],
    "name" => $_GET['name'],
    "email" => $_GET['email']
]);

if (!isset($response) || !isset($response->success) || !$response->success) {
    //TODO: handle error.. not found!
    return;
}

setcookie("player-id", $response->data->playerId, time() + 60 * 60 * 24 * 14, "/");
header("Location: /questions.php");
