<?php include('../header.php'); ?>
<?php include('../utils/api.php'); ?>

<div class="content">
    <div class="titleBox">
        <h2 class="pageTitle"> </h2>
    </div>

    <?php
    // Get ID of the selected 'speurtocht'
    // and the ID of the user

    if (!isset($_GET['id'])) {
        //TODO maybe add error message?
        // header("location: /admin/beheerderpaneel.php");
        echo '0';
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
    echo '<a class="speurtocht">Resultaten nakijken</a>';
    echo '<a class="speurtocht">Eindresultaten bekijken</a>';
    echo '<a class="speurtocht">Deelnemers verwijderen</a>';
    echo '<a class="speurtocht">Speurtocht verwijderen</a>';
    echo '</div>';

    // SPEURTOCHT STARTEN //



    // SPEURTOCHT AANPASSEN //
    echo '<div class="speurtochtAanpassen">';
    echo '<h2>Vragen</h2>';

    $questions = (array) $response->data->questions;

    foreach ($questions as $_question) {
        $question = $_question;
        echo '<form id="editQuestion" action="speurtochtpaneel.php" method="POST">';
        echo '<input type="hidden" name="id" value="' . $question->questionId . '">';
        echo '<input name="text" class="one1" type="checkbox" ' . $question->type == "TEXT" ? "checked" : "" . '>';
        echo '<label for="one1">Open vraag</label>';
        echo '<input name="photo" class="two1" type="checkbox" ' . $question->type == "PHOTO" ? "checked" : "" . '>';
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
    echo '<form id="createForm" action="beheerderpaneel" method="POST">';
    echo '<input class="one1" type="checkbox" name="open">';
    echo '<label for="one1">Open vraag</label>';
    echo '<input class="two1" type="checkbox" name="photo">';
    echo '<label for="two1">Foto vraag</label></br>';
    echo '<textarea class="inputField1" id="inputField1" name="question" placeholder="Vul hier uw vraag in" required></textarea>';
    echo '<button class="buttonForm" type="submit" name="addQuestion">Extra vraag toevoegen</button>';
    echo '</form>';
    echo '</div>'; 
    

    if (isset($_POST['addQuestion'])) {
        $question = mysqli_real_escape_string($db, $_POST['question']);

        $type = '';
        if (!empty(mysqli_real_escape_string($db, $_POST['open']))) {

        }

    }

    ?>

</div>