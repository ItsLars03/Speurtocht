<?php
include('../../utils/api.php');
include('../../header.php');
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
        $type = '';
        if (isset($_POST['open'])) {
            $type = 'TEXT';
        }
        if (isset($_POST['photo'])) {
            $type = 'PHOTO';
        }

        $response = API::post("/scavengerhunt/questions", [
            "scavengerHuntId" => $_POST['Spid'],
            "question" => $_POST['question'],
            "type" => $type
        ]);

        if (!isset($response) || !isset($response->success) || !$response->success) {
            //TODO handle error.
            return;
        }


        header('Location: /admin/speurtochtpaneel.php?id=' . $response->data->scavengerHuntId.'&cssevent=3');
    }

    // Check answer
    if (isset($_POST['correcting-answer-good']) || isset($_POST['correcting-answer-wrong'])) {
        $id = $_POST['scavengerHuntId'];
        $correctingRes = API::put("/scavengerhunt/answers/" . $_POST['answerId'], [
            "correct" => isset($_POST["correcting-answer-good"])
        ]);

        if (!isset($correctingRes) || !isset($correctingRes->success) || !$correctingRes->success) {
            //TODO handle error.
            return;
        }

        header('Location: /admin/speurtochtpaneel.php?id=' . $id.'&cssevent=2');
    }

    // Start Speurtocht
    if (isset($_POST['startSpeurtocht'])) {
        $db = mysqli_connect('localhost', 'root', '', 'speurtocht');
        $to = mysqli_real_escape_string($db, $_POST['emails']);
        $id = $_POST["id"];
        // Set speurtocht to OPEN
        $query = "UPDATE scavengerhunt SET status='OPENED' WHERE scavengerHuntId='$id'";
        $result = mysqli_query($db, $query);

        $emails = explode(", ", $to);
        // For each email that was submitted.
        foreach($emails as $i =>$key) {
            // Send e-mails to submitted e-mailadresses
            $link = 'localhost/join.php?id={emailId}';
            $mailRes = API::post("/mail/send", [
                "html" => "<html>Neem via deze link deel aan van de speurtocht! " . $link . "</html>",
                "text" => "Hello World",
                "subject" => "Uitnodiging speurtocht",
                "to" => "$key",
                "scavengerHuntId" => $_POST["id"]
            ]);


            if (!isset($mailRes) || !isset($mailRes->success) || !$mailRes->success) {
                //Error!
                return;
            }
            $mailId = $mailRes->data->mailId;
        }

        header('Location: /admin/speurtochtpaneel.php?id='.$_POST["id"]);
    }
    // Delete deelnemer
    if (isset($_POST['deleteDeelnemer'])) {
        $db = mysqli_connect('localhost', 'root', '', 'speurtocht');
        $player_id = mysqli_real_escape_string($db, $_POST['playerId']);
        $id = mysqli_real_escape_string($db, $_POST['id']);
        // Delete query
        $query = "DELETE FROM players WHERE playerId='$player_id'";
        $result = mysqli_query($db, $query);

        header('Location: /admin/speurtochtpaneel.php?id='.$id.'&cssevent=1');
    }
    // Delete speurtocht
    if (isset($_POST['deleteSpeurtocht'])) {
        $db = mysqli_connect('localhost', 'root', '', 'speurtocht');
        $scavengerHuntId = mysqli_real_escape_string($db, $_POST['id']);
        // Delete query.
        $query = "DELETE FROM scavengerhunt WHERE scavengerHuntId='$scavengerHuntId'";
        $result = mysqli_query($db, $query);

        header('Location: /admin/beheerderpaneel.php');
    }

    
}
