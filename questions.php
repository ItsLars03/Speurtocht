<?php
include("./header.php");
include("./utils/api.php");

//get random question


$getQuestionRes = API::get("/scavengerhunt/questions/random/" . $_COOKIE['player-id'], array());

var_dump($getQuestionRes);
