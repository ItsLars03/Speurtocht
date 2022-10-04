<?php
include('../../utils/api.php');
$db = mysqli_connect('localhost', 'root', '', 'speurtocht');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['createSpeurtocht'])) {
        if (!isset($_POST["name"]) || $_POST["name"] == "") {
            //TODO handle error no name.
            echo "erorr. 1";
            return;
        }

        $postRes = API::post("/scavengerhunt", [
            "ownerId" => $_COOKIE["user-id"],
            "name" => $_POST["name"]
        ]);


        if (!isset($postRes) || !isset($postRes->success) || !$postRes->success) {
            //TODO: handle error.
            echo "error. 2";
            return;
        }
        unset($_POST);
        header("location: " . $_SERVER['HTTP_REFERER']);
    }

    // Add new question
    if (isset($_POST['addquestion'])) {
        $question = mysqli_real_escape_string($db, $_POST['question']);
        $id = mysqli_real_escape_string($db, $_POST['Spid']);
        // $question = 'tdt';
        $type = '';
        if (isset($_POST['open'])) {
            $type = 'TEXT';
        }
        if (isset($_POST['photo'])) {
            $type = 'PHOTO';
        }
        $uid = uniqid();
        $query = "INSERT INTO questions (questionId, scavengerHuntId, question, type) VALUES ('$uid', '$id', '$question', '$type')";
        $send = mysqli_query($db, $query);
        header('Location: /admin/speurtochtpaneel.php?id='.$id.'');

    }

    // Check answer
    if (isset($_POST['Good']) || isset($_POST['Wrong'])) {
        $db = mysqli_connect('localhost', 'root', '', 'speurtocht');
        $id = mysqli_real_escape_string($db, $_POST['id']);
        $player_id = mysqli_real_escape_string($db, $_POST['playerId']);
        $question_id = mysqli_real_escape_string($db, $_POST['questionId']);
        
        $type = '';
        if (isset($_POST['Good'])) {
            $type = '1';
        }
        if (isset($_POST['Wrong'])) {
            $type = '0';
        }
        $query = "UPDATE answers SET correct='$type' WHERE playerId='$player_id' AND questionId='$question_id'";
        $send = mysqli_query($db, $query);
        header('Location: /admin/speurtochtpaneel.php?id='.$id);
    }
}