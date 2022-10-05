<?php include('header.php'); ?>
<!-- <?php include('../utils/api.php'); ?> -->

<div class="content">
    <div class="titleBox">
        <h2 class="pageTitle">TEST</h2>
    </div>

    <?php

    echo '<form id="createForm" action="tests.php" method="POST" enctype="multipart/form-data">';
    echo '<input type="file" name="image" value="" accept="image/*"><br />';
    echo '<button type="submit" class="buttonForm" name="submit">Upload</button>';
    echo '</form>';

    // $imagename = $_FILES['image']['name'];

    // $filename   = 'abc'; // 5dab1961e93a7-1571494241
    // $extension  = pathinfo( $_FILES["file"]["name"], PATHINFO_EXTENSION ); // jpg
    // $basename   = $filename . "." . $extension; // 5dab1961e93a7_1571494241.jpg

    echo '<pre>';
    var_dump($_FILES);
    echo '</pre>';

    $imagename = $_FILES['image']['name'];
    $image_type = $imagename = $_FILES['image']['type'];
    echo $image_type;
    // $type = strval($image_type);
    $headers = explode('/', $image_type);
    var_dump( $headers[1]);

    $imagetemp = $_FILES['image']['tmp_name'];

    // Image path to save in 
    $imagePath = "images/";
    if(is_uploaded_file($imagetemp)) {
        if(move_uploaded_file($imagetemp, $imagePath . $imagename)) {
            echo "Foto upload succesvol";
        }
    }

    // $target_dir = "images/";
    // $target_file = $target_dir . basename($_FILES["1116586"]["name"]);
    // $uploadOk = 1;
    // $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    // // Check if image file is a actual image or fake image
    // if(isset($_POST["submit"])) {
    //     $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    //     if($check !== false) {
    //         echo "File is an image - " . $check["mime"] . ".";
    //         $uploadOk = 1;
    //     } else {
    //         echo "File is not an image.";
    //         $uploadOk = 0;
    //     }
    // }
    ?>

</div>