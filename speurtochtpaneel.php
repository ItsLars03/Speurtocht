<?php include('header.php'); ?>
<div class="content">
    <div class="titleBox">
        <h2 class="pageTitle"> </h2>
    </div>

    <?php
    // Get ID of the selected 'speurtocht'
    // and the ID of the user

$speurtocht_id = $_GET['id'];
$query = "SELECT * FROM scavengerhunt WHERE scavengerHuntId='$speurtocht_id'";
$result = mysqli_query($db, $query);
$check = false;
// Check for url manipulation;
if(isset($_GET['id']) && $result->num_rows == 1) {
    $check = true;
} else {
    header('Location: beheerderpaneel');
}

if ($check = true) {

    $query = "SELECT * FROM scavengerhunt WHERE scavengerHuntId='$speurtocht_id'";
    $result = mysqli_query($db, $query);
    $row = $result->fetch_assoc();
    // Go back button
    echo '<div class="backButton">';
        echo '<i class="fas fa-arrow-left"></i>';
    echo '</div>';
    echo '<h2 class="speurtochtTitel"> '. $row['name'] .' </h2>';

    echo '<div class="speurtochtenBoxMenu">';
        if ($row['status'] == 'CLOSED') {
            echo '<a class="speurtocht startMenu">Speurtocht starten</a>';
            echo '<a class="speurtocht AanpassenMenu">Speurtocht aanpassen</a>';
        }
        echo '<a class="speurtocht">Resultaten nakijken</a>';
        echo '<a class="speurtocht">Eindresultaten bekijken</a>';
        echo '<a class="speurtocht">Deelnemers verwijderen</a>';
        echo '<a class="speurtocht">Speurtocht verwijderen</a>';
        echo '</div>';

    // SPEURTOCHT STARTEN //
    echo '<div class="speurtochtStarten">';

        echo '<h2>Starten</h2>';
        echo '<p>Vul hieronder de e-mail adressen van de spelers in.</p>';
        echo '<form id="createForm" action="speurtochtpaneel" method="POST">';
            echo '<input type="hidden" name="test" value="'.$_GET['id'].'">';
            echo '<input class="inputField" type="text" name="emails" placeholder="bijv; test@gmail.com, bob@gmail.com" required><br />';
            echo '<button class="buttonForm" type="submit" name="startSpeurtochtt1">Start Speurtocht</button>';
        echo '</form>';

        if (isset($_POST['startSpeurtochtt1'])) {
            // $speurtocht_id = $_GET['id'];
            $speurtocht_id = mysqli_real_escape_string($db, $_POST['test']);
            $query12 = "UPDATE scavengerhunt SET status = 'OPENED' WHERE scavengerHuntId='$speurtocht_id'";
            //$query = "UPDATE questions SET question = '$question_text', type = '$typee' WHERE questionId = '".$question_id."'";
            $result = mysqli_query($db, $query12);

            // $email_string = mysqli_real_escape_string($db, $_POST['emails']);
            // $emails = explode(", ", $email_string);
            // foreach($emails as $i =>$key) {
            //     $to = $key;
            //     send_mail($to);
            //     // echo $key .'</br>';
            // }
        }
    echo '</div>';

    // SPEURTOCHT AANPASSEN //
    echo '<div class="speurtochtAanpassen">';
        echo '<h2>Vragen</h2>';

        // $db = mysqli_connect('localhost', 'root', '', 'speurtocht');
        $query = "SELECT * FROM questions WHERE scavengerHuntId='$speurtocht_id'";
        $result = mysqli_query($db, $query);
        while ($row = $result->fetch_assoc()) {
            $is_checked = '';
            $is_checked_two = '';
            if (($row['type']) == 'TEXT') {
                $is_checked = 'checked';
            } elseif (($row['type']) == 'PHOTO') {
                $is_checked_two = 'checked';
            }
            echo '<form id="editQuestion" action="speurtochtpaneel.php" method="POST">';
                echo '<input type="hidden" name="id" value="'. $row['questionId'] .'">';
                echo '<input name="open" class="one1" type="checkbox" '.$is_checked.'>';
                echo '<label for="one1">Open vraag</label>';
                echo '<input name="photo" class="two1" type="checkbox" '.$is_checked_two.'>';
                echo '<label for="two1">Foto vraag</label></br>';
                echo '<textarea name="speurtochtText" placeholder="'.$row['question'].'" id="'.$row['scavengerHuntId'].'" class="editSpeurtocht"></textarea>';
                echo '<button class="update" type="submit" name="updateQ">Bewerken</button>';
            echo '</form>';
            if (isset($_POST['updateQ'])) {
                // $speurtocht_id = $row['scavengerHuntId'];
                // $question_id = mysqli_real_escape_string($db, $_POST['id']);
                // //$question_text = mysqli_real_escape_string($db, $_POST['speurtochtText']);
                // $question_text = 'abc';

                // $question_type1 = mysqli_real_escape_string($db, $_POST['open']);
                // $question_type2 = mysqli_real_escape_string($db, $_POST['photo']);
                // $typee = '';
                // if (!empty($question_type1)) {
                //     $typee = 'TEXT';
                // } elseif(!empty($question_type2)) {
                //     $typee = 'PHOTO';
                // }
                $query = "UPDATE questions SET question = 'abc', type = 'TEXT' WHERE questionId = '34df'";
                $result = mysqli_query($db, $query);

                //header('Location: speurtochtpaneel?id=' . $speurtocht_id . '');
                echo 'TEST';
            }
        }
        echo '<h2 class="extraQuestions"> Extra vragen toevoegen </h2>';
        echo '<form id="createForm" action="speurtochtpaneel" method="POST">';
        echo '<input class="one1" type="checkbox">';
        echo '<label for="one1">Open vraag</label>';
        echo '<input class="two1" type="checkbox">';
        echo '<label for="two1">Foto vraag</label></br>';
        echo '<textarea class="inputField1" id="inputField1" name="inputField1" placeholder="Vul hier uw vraag in" required></textarea>';
        echo '</form>';
        echo '<a class="extraField">Extra vraag toevoegen</a><br/>';
        echo '</div>';
    }

    ?>

</div>