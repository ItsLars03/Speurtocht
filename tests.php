<?php include('header.php'); ?>
<!-- <?php include('../utils/api.php'); ?> -->

<div class="content">
    <div class="titleBox">
        <h2 class="pageTitle">TEST</h2>
    </div>

    <?php

    echo '<form id="createForm" action="/server/scavengerHunt/create.php" method="POST">';
    echo '<input type="file" name="images" value=""/><br />';
    echo '<button type="submit" class="buttonForm" name="uploadImg">Upload</button>';
    echo '</form>';
    ?>

</div>