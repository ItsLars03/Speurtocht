<?php
include("../../utils/api.php");

var_dump($_POST);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update-scavengerhunt'])) {
        // $type = $question->type;
        echo "test1";
        $type = "";

        if ((isset($_POST['text']) && isset($_POST['photo'])) || (!isset($_POST['text']) && !isset($_POST['photo']))) {
            //TODO: handle error both are selected.
            echo "this.1";
            return;
        }

        if (isset($_POST['text'])) {
            $type = "PHOTO";
        }

        if (isset($_POST['photo'])) {
            $type = "TEXT";
        }

        //updating.
        $updateResponse = API::put("/scavengerhunt/questions/" . $_POST['id'], [
            "question" => $_POST['question'],
            "type" => $type
        ]);

        if (!isset($updateResponse) || !isset($updateResponse->success) || !$updateResponse->success) {
            //TODO handle error...
            echo $response->message;
            return;
        }

        header('Location: speurtochtpaneel?id=' . $response->data->scavengerHuntId);
    }
}
