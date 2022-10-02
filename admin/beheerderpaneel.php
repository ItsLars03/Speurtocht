<?php include('../header.php'); ?>
<?php include('../utils/api.php'); ?>

<div class="content">
    <div class="titleBox">
        <h2 class="pageTitle"> Beheerderspaneel </h2>
    </div>

    <?php
    echo '<div class="speurtochtenBox">';
    $ownerId = $_COOKIE['user-id'];

    $response = API::get("/scavengerhunt/owner/" . $ownerId, array());

    if (!isset($response) || !isset($response->success) || !$response->success || !isset($response->data)) {
        //something failed.
        //TODO: handle error.
        return;
    }

    $data = (array) $response->data;

    foreach ($data as $scavengerHunt) {
        echo '<a href="speurtochtpaneel?id=' . $scavengerHunt->scavengerHuntId . '" class="speurtocht">' . $scavengerHunt->name . '</a>';
    }

    echo '</div>';

    echo '<div class="creatingBox">';
    echo '<h2>Speurtocht Aanmaken</h2>';
    echo '<form id="createForm" action="/server/scavengerHunt/create.php" method="POST">';
    echo '<input class="inputField" type="text" name="name" placeholder="Speurtocht naam" required><br />';
    echo '<button class="buttonForm" type="submit" name="createSpeurtocht">Speurtocht Aanmaken</button>';
    echo '</form>';


    echo '</div>';

    echo '<div class="createBox">';

    echo '<a class="createSPT">Speurtocht Aanmaken</a>';

    echo '</div>';

    //
    //  Create question row with default text, all fields filled in, then able to edit it. 
    //
    ?>

</div>


</body>

</html>