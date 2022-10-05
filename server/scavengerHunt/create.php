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


        header('Location: /admin/speurtochtpaneel.php?id=' . $response->data->scavengerHuntId);
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

        header('Location: /admin/speurtochtpaneel.php?id=' . $id);
    }
    // Upload Image
    // if (isset($_POST['uploadImg'])) {
    // $filename = $_FILES["images"]["1116586"];

    // $tempname = $_FILES["images"]["1116586"];    

    // $folder = "images/".$filename;   
    // if (move_uploaded_file($tempname, $folder)) {

    //     $msg = "Image uploaded successfully";

    // }
    // move_uploaded_file($image["htdocs"], __DIR__ . "/images/" . $image["test"]);
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    if (isset($_POST["uploadImg"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }
    // }
}
