<?php include('header.php'); ?>
<?php include('./utils/api.php'); ?>

<div class="content">
    <div class="titleBox">
        <h2 class="pageTitle">TEST</h2>
    </div>
    <img src="<?php echo API::$_url . '/scavengerhunt/answers/image/' . '1690a4a7-1431-43a8-a9e6-1b9bbe42c68f/' . 'ad847192-a055-4e12-bcf0-5f4a0478c98c' ?>"
        crossorigin="anonymous">

    <?php

    echo '<form id="createForm" action="tests.php" method="POST" enctype="multipart/form-data">';
    echo '<input type="file" name="image" value="" accept="image/png, image/jpeg"><br />';
    echo '<button type="submit" class="buttonForm" name="submit">Upload</button>';
    echo '</form>';

    if (isset($_FILES['image'])) {
        $response = API::postFile("/scavengerhunt/answers/image", [
            "questionId" => "1690a4a7-1431-43a8-a9e6-1b9bbe42c68f",
            "playerId" => "ad847192-a055-4e12-bcf0-5f4a0478c98c",
            "correct" => true,
        ], $_FILES['image']['tmp_name'], $_FILES['image']['type'], $_FILES['image']['name']);

        unset($_FILES);
        var_dump($response);
    }
    ?>
</div>