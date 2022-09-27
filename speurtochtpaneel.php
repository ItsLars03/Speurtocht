<?php include('header.php'); ?>
<div class="content">
    <div class="titleBox">
        <h2 class="pageTitle">  </h2>
    </div>

<?php
// Get ID of the selected 'speurtocht'
// and the ID of the user

$db = mysqli_connect('localhost', 'root', '', 'speurtocht');
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
    echo '<h2 class="speurtochtTitel"> '. $row['name'] .' </h2>';

    echo '<div class="speurtochtenBoxMenu">';
        echo '<a class="speurtocht">Speurtocht starten</a>';
        echo '<a class="speurtocht AanpassenMenu">Speurtocht aanpassen</a>';
        echo '<a class="speurtocht">Resultaten nakijken</a>';
        echo '<a class="speurtocht">Eindresultaten bekijken</a>';
        echo '<a class="speurtocht">Deelnemers verwijderen</a>';
        echo '<a class="speurtocht">Speurtocht verwijderen</a>';
    echo '</div>';

    // SPEURTOCHT AANPASSEN //
    echo '<div class="speurtochtAanpassen">';
        echo '<h2>Vragen</h2>';

        $db = mysqli_connect('localhost', 'root', '', 'speurtocht');
        $query = "SELECT * FROM questions WHERE scavengerHuntId='1'";
        $result = mysqli_query($db, $query);
        while($row = $result->fetch_assoc()) {
            $is_checked = '';
            $is_checked_two = '';
            if (($row['type']) == 'OPEN') {
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
                echo '<textarea name="speurtochtText" id="'.$row['scavengerHuntId'].'" class="editSpeurtocht">'.$row['question'].'</textarea>';
                echo '<button class="update" name="update">Opslaan</button>';
            echo '</form>';
            if (isset($_POST['update'])) {
                $speurtocht_id = $row['scavengerHuntId'];
                $question_id = mysqli_real_escape_string($db, $_POST['id']);
                $question_text = mysqli_real_escape_string($db, $_POST['speurtochtText']);

                $question_type1 = mysqli_real_escape_string($db, $_POST['open']);
                $question_type2 = mysqli_real_escape_string($db, $_POST['photo']);

                echo $question_id;
                $query = "UPDATE questions SET question = '$question_text', type = 'aaa' WHERE questionId = '".$question_id."'";
                $result = mysqli_query($db, $query);

                header('Location: speurtochtpaneel?id='.$speurtocht_id.'');
            }
        }
        echo '<h2 class="extraQuestions"> Extra vragen maken </h2>';
        echo '<form id="createForm" action="beheerderpaneel" method="POST">';
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