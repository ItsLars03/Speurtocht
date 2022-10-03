<?php
include('../../utils/api.php');
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

    //
    if (isset($_POST['addquestion'])) {
        $db = mysqli_connect('localhost', 'root', '', 'speurtocht');
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

        $query = "INSERT INTO questions (questionId, scavengerHuntId, question, type) VALUES ('', '$id', '$question', '$type')";
        $send = mysqli_query($db, $query);
        header('Location: /admin/speurtochtpaneel.php?id='.$id.'');

    }
}