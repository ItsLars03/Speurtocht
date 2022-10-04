<?php include('../header.php'); ?>
<?php include('../utils/api.php'); ?>

<div class="content">
    <div class="titleBox">
        <h2 class="pageTitle"> </h2>
    </div>

    <?php
    echo '<div class="backButton2">';
    echo '<i class="fas fa-arrow-left"></i>';
    echo '</div>';
    // Get ID of the selected 'speurtocht'
    // and the ID of the user

    if (!isset($_GET['id'])) {
        //TODO maybe add error message?
        header("location: /admin/beheerderpaneel.php");
        return;
    }


    $response = API::get("/scavengerhunt/" . $_GET['id'], [
        "ownerId" => $_COOKIE['user-id'],
    ]);

    if (!isset($response) || !isset($response->success) || !$response->success || !isset($response->data)) {
        //TODO maybe add error message?
        header("location: /admin/beheerderpaneel.php");
        return;
    }

    $speurtocht_id = $_GET['id'];
    // $query = "SELECT * FROM scavengerhunt WHERE scavengerHuntId='$speurtocht_id'";
    // $result = mysqli_query($db, $query);
    // $row = $result->fetch_assoc();
    // Go back button
    echo '<div class="backButton">';
    echo '<i class="fas fa-arrow-left"></i>';
    echo '</div>';
    echo '<h2 class="speurtochtTitel"> ' . $response->data->name . ' </h2>';

    echo '<div class="speurtochtenBoxMenu">';
    if ($response->data->status == 'CLOSED') {
        echo '<a class="speurtocht">Speurtocht starten</a>';
        echo '<a class="speurtocht AanpassenMenu">Speurtocht aanpassen</a>';
    }
    echo '<a class="speurtocht resultMenu">Resultaten nakijken</a>';
    echo '<a class="speurtocht">Eindresultaten bekijken</a>';
    echo '<a class="speurtocht">Deelnemers verwijderen</a>';
    echo '<a class="speurtocht">Speurtocht verwijderen</a>';
    echo '</div>';



    // SPEURTOCHT AANPASSEN //
    echo '<div class="speurtochtAanpassen">';
    echo '<h2>Vragen</h2>';

    $questions = (array) $response->data->questions;

    foreach ($questions as $_question) {
        $question = $_question;
        echo '<form id="editQuestion" action="speurtochtpaneel.php" method="POST">';
        echo '<input type="hidden" name="id" value="' . $question->questionId . '">';
        echo '<input name="text" class="one1" type="checkbox" ' . ($question->type == "TEXT" ? "checked" : "") . '>';
        echo '<label for="one1">Open vraag</label>';
        echo '<input name="photo" class="two1" type="checkbox" ' . ($question->type == "PHOTO" ? "checked" : "") . '>';
        echo '<label for="two1">Foto vraag</label></br>';
        echo '<textarea name="question" id="' . $response->data->scavengerHuntId . '" class="editSpeurtocht">' . $question->question . '</textarea>';
        echo '<button class="update" name="update">Bewerken</button>';
        echo '</form>';
        if (isset($_POST['update'])) {
            $type = $question->type;
            if (isset($_POST['text']) && $type != "PHOTO") {
                $type = "PHOTO";
            }

            if (isset($_POST['photo']) && $type != "TEXT") {
                $type = "TEXT";
            }

            //updating.
            $updateResponse = API::put("/scavengerhunt/questions/" . $_POST['id'], [
                "question" => $_POST['question'],
                "type" => $type
            ]);

            if (!isset($updateResponse) || !isset($updateResponse->success) || !$updateResponse->success) {
                //TODO handle error...
                return;
            }

            header('Location: speurtochtpaneel?id=' . $response->data->scavengerHuntId . '');
        }
    }


    echo '<h2 class="extraQuestions"> Extra vragen toevoegen </h2>';
    echo '<form id="createForm" action="/server/scavengerHunt/create.php" method="POST">';
    echo '<input type="hidden" name="Spid" value="' . $speurtocht_id . '">';
    echo '<input class="one1" type="checkbox" name="open">';
    echo '<label for="one1">Open vraag</label>';
    echo '<input class="two1" type="checkbox" name="photo">';
    echo '<label for="two1">Foto vraag</label></br>';
    echo '<textarea class="inputField1" id="inputField1" name="question" placeholder="Vul hier uw vraag in" required></textarea>';
    echo '<button class="buttonForm" type="submit" name="addquestion">Extra vraag toevoegen</button>';
    echo '</form>';
    echo '</div>';


    // SPEURTOCHT VRAGEN CONTROLEREN //
    echo '<div class="speurtochtControle">';
    echo '<h2>Controleer vragen</h2>';

    echo '<div class="questionBox">';
    $queryNr0 = "SELECT * FROM questions WHERE scavengerHuntId='$speurtocht_id'";
    $resultNr0 = mysqli_query($db, $queryNr0);
    while ($row = $resultNr0->fetch_assoc()) {
        echo '<div class="singleQuestion">';
        $question_id = $row['questionId'];
        echo '<p class="item question"><span>Vraag:<br></span> '.$row['question'].'</p>';

        $queryNr1 = "SELECT * FROM answers WHERE questionId='$question_id'";
        $resultNr1 = mysqli_query($db, $queryNr1);
        while ($row = $resultNr1->fetch_assoc()) {
            // $question_id = $row['questionId'];
            $player_id = $row['playerId'];
            
            echo '<form id="checkForm" action="/server/scavengerHunt/create.php" method="POST">';
            echo '<input type="hidden" value="'.$speurtocht_id.'" name="id">';
            echo '<input type="hidden" value="'.$player_id.'" name="playerId">';
            echo '<input type="hidden" value="'.$question_id.'" name="questionId">';
            echo '<p class="item player"><span>Speler/Groep:</span> '.$row['playerId'].'</p>';
            echo '<textarea class="item awnser" readonly>'.$row['answer'].'</textarea>';

            echo '<button class="check good" type="submit" name="Good"> Goed </button>';
            echo '<button class="check wrong" type="submit" name="Wrong"> Fout </button>';
            echo '</form>';
        }
        echo '</div>';
    }
    echo '</div>';

    echo '</div>';

    ?>

</div>