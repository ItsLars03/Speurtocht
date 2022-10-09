<?php
include("../../utils/api.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update-scavengerhunt'])) {
        $type = "";

        if ((isset($_POST['text']) && isset($_POST['photo'])) || (!isset($_POST['text']) && !isset($_POST['photo']))) {
            //TODO: handle error both are selected.
            echo "this.1";
            return;
        }

        if (isset($_POST['text'])) {
            $type = "TEXT";
        }

        if (isset($_POST['photo'])) {
            $type = "PHOTO";
        }

        //updating.
        $updateResponse = API::put("/scavengerhunt/questions/" . $_POST['id'], [
            "question" => $_POST['question'],
            "type" => $type
        ]);

        if (!isset($updateResponse) || !isset($updateResponse->success) || !$updateResponse->success) {
            //TODO handle error...
            echo $updateResponse->message;
            return;
        }

        header('Location: /admin/speurtochtpaneel.php?id=' . $updateResponse->data->scavengerHuntId.'&cssevent=3');
    }
}
