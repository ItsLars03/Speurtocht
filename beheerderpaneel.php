<?php include('header.php'); ?>
<div class="content">
    <div class="titleBox">
        <h2 class="pageTitle"> Beheerderspaneel </h2>
    </div>

    <?php
    echo '<div class="speurtochtenBox">';
    // Database connection values.
        // $db = mysqli_connect('localhost', 'root', '', 'speurtocht');
        $query = "SELECT * FROM scavengerhunt WHERE ownerId='d8865c57-d448-4129-8064-e39a6e2cd905'";
        $result = mysqli_query($db, $query);
        // Display all created 'speurtochten'
        while($row = $result->fetch_assoc()) {
            echo '<a href="speurtochtpaneel?id='.$row['scavengerHuntId'].'" class="speurtocht">'.$row['name'].'</a>';
        }
    echo '</div>';

    echo '<div class="creatingBox">';
        echo '<h2>Speurtocht Aanmaken</h2>';
        echo '<form id="createForm" action="beheerderpaneel.php" method="POST">';
            echo '<input class="inputField" type="text" name="name" placeholder="Speurtocht naam" required><br />';
            echo '<button class="buttonForm" type="submit" name="createSpeurtocht">Speurtocht Aanmaken</button>';
        echo '</form>';

        if (isset($_POST['createSpeurtocht'])) {
            $user_id = 1;
            $name = mysqli_real_escape_string($db, $_POST['name']);
            $query = "INSERT INTO scavengerhunt (scavengerHuntId, ownerId, name, status) VALUES ('', '$user_id', '$name', 'INACTIVE')";
            $send = mysqli_query($db, $query);
        }

        // if (isset($_POST['createSpeurtocht'])) {
        //     foreach ($_POST['inputField1'] as $question) {
        //         echo $question;
        //     }
        // };

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