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

    // Get image type (image/jpg, image/png ect).
    $image_type = $_FILES['image']['type'];
    // Use explode to extract the type to use in renaming.
    $type_image = explode('/', $image_type);
    // Temporary image storage
    $imagetemp = $_FILES['image']['tmp_name'];
    // Rename image and add image type.
    //            \/ Variable here to name file.
    $imagename = 'abc.'.$type_image[1];
    // Image path to save image in 
    $image_path = "images/";
    if(is_uploaded_file($imagetemp)) {
        if(move_uploaded_file($imagetemp, $image_path . $imagename)) {
            echo "Foto upload succesvol";
            // Path to the image we reuse to display image.
            $database_path = $image_path.$imagename;
            $answer_id = uniqid();
            // Then save path to image(and question information) in database
            $query_img = "INSERT INTO answers (answerId, questionId, playerId, answer) VALUES ('$answer_id', '3', '0134', '$database_path')";
            $resultA = mysqli_query($db, $query_img);
        }
    }
    ?>

</div>