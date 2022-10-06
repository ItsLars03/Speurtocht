<?php
include("./header.php");
include("./utils/api.php");

//get random question


$getQuestionRes = API::get("/scavengerhunt/questions/random/" . $_COOKIE['player-id'], array());

if (!isset($getQuestionRes) || isset($getQuestionRes->success) || !$getQuestionRes->success) {
    //error.
    return;
}

var_dump($getQuestionRes);
