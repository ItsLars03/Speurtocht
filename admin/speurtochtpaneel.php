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

    $scavengerHuntId = $_GET['id'];
    // $query = "SELECT * FROM scavengerhunt WHERE scavengerHuntId='$scavengerHuntId'";
    // $result = mysqli_query($db, $query);
    // $row = $result->fetch_assoc();
    // Go back button
    echo '<div class="backButton">';
    echo '<i class="fas fa-arrow-left"></i>';
    echo '</div>';
    echo '<h2 class="speurtochtTitel"> ' . $response->data->name . ' </h2>';

    echo '<div class="speurtochtenBoxMenu">';
    if ($response->data->status == 'CLOSED') {
        echo '<a class="speurtocht startMenu">Speurtocht starten</a>';
        echo '<a class="speurtocht AanpassenMenu">Speurtocht aanpassen</a>';
    }

    $unAnsweredRes = API::get("/scavengerhunt/answers/getall/" . $scavengerHuntId, array());

    $unReadAnswers = 0;

    if (!isset($unAnsweredRes) || !isset($unAnsweredRes->success) || !$unAnsweredRes->success || !isset($unAnsweredRes->data)) {
        //TODO: handle error.
    } else {
        $answers = $unAnsweredRes->data;
        $unReadAnswers = count(array_filter((array) $answers, function ($v) {
            return !isset($v->correct);
        }, ARRAY_FILTER_USE_BOTH));
    }


    // $queryA = "SELECT COUNT(*) FROM answers LEFT JOIN questions USING (questionId) WHERE scavengerHuntId='$scavengerHuntId' AND correct IS NULL";
    // $resultA = mysqli_query($db, $queryA);
    // $count = mysqli_fetch_array($resultA);

    // while ($row = $resultA->fetch_assoc()) {

    echo '<a class="speurtocht resultMenu">Resultaten nakijken (' . $unReadAnswers . ')</a>';
    echo '<a class="speurtocht" href="/results.php?id=' . $scavengerHuntId . '" >Eindresultaten bekijken</a>';
    if ($response->data->status == 'OPENED') {
        echo '<a class="speurtocht deelnemerMenu">Deelnemers verwijderen</a>';
    }
    echo '<a class="speurtocht deleteMenu">Speurtocht verwijderen</a>';
    echo '</div>';

    // SPEURTOCHT START //
    echo '<div class="speurtochtStart">';
    echo '<h2>Start speurtocht</h2>';
    echo '<p class="startText">Vul hieronder de e-mailadressen van de verschillende spelers in.</p>';

    echo '<form id="startForm" action="/server/scavengerHunt/create.php" method="POST">';
        echo '<input type="hidden" name="id" value="'.$scavengerHuntId.'">';
        echo '<input class="emailList" type="textarea" name="emails" placeholder="bijv; bob@gmail.com, bart@gmail.com">';
        echo '<button class="submitStart" type="submit" name="startSpeurtocht">Starten</button>';
    echo '</form>';

    echo '</div>';

    // SPEURTOCHT AANPASSEN //
    echo '<div class="speurtochtAanpassen">';
    echo '<h2>Vragen</h2>';

    $questions = (array) $response->data->questions;

    foreach ($questions as $_question) {
        $question = $_question;
        echo '<form id="editQuestion" action="/server/scavengerHunt/update.php" method="POST">';
        echo '<input type="hidden" name="id" value="' . $question->questionId . '">';
        echo '<input name="text" class="one1" type="checkbox" ' . ($question->type == "TEXT" ? "checked" : "") . '>';
        echo '<label for="one1">Open vraag</label>';
        echo '<input name="photo" class="two1" type="checkbox" ' . ($question->type == "PHOTO" ? "checked" : "") . '>';
        echo '<label for="two1">Foto vraag</label></br>';
        echo '<textarea name="question" id="' . $response->data->scavengerHuntId . '" class="editSpeurtocht">' . $question->question . '</textarea>';
        echo '<button class="update" name="update-scavengerhunt">Bewerken</button>';
        echo '</form>';
    }


    echo '<h2 class="extraQuestions"> Extra vragen toevoegen </h2>';
    echo '<form id="createForm" action="/server/scavengerHunt/create.php" method="POST">';
    echo '<input type="hidden" name="Spid" value="' . $scavengerHuntId . '">';
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

    $questionRes = API::get("/scavengerhunt/answers/getbyquestion/" . $scavengerHuntId, array());

    if (!isset($questionRes) || !isset($questionRes->success) || !$questionRes->success || !isset($questionRes->data)) {
        //Handle error.
    } else {
        foreach ((array) $questionRes->data as $_question) {
            $question = $_question;
            echo '<div class="singleQuestion">';
            echo '<p class="item question"><span>Vraag:<br></span> ' . $question->question . '</p>';

            foreach ($question->answers as $_answer) {
                $answer = $_answer;
                if (isset($answer->correct)) continue;
                // $question_id = $row['questionId'];

                echo '<form id="checkForm" action="/server/scavengerHunt/create.php" method="POST">';
                echo '<input type="hidden" value="' . $question->scavengerHuntId . '" name="scavengerHuntId">';
                // echo '<input type="hidden" value="' . $answer->playerId . '" name="playerId">';
                echo '<input type="hidden" value="' . $answer->answerId . '" name="answerId">';
                echo '<p class="item player"><span>Speler/Groep:</span> ' . $answer->playerId . '</p>';
                echo '<textarea class="item awnser" readonly>' . $answer->answer . '</textarea>';

                echo '<button class="check good" type="submit" name="correcting-answer-good"> Goed </button>';
                echo '<button class="check wrong" type="submit" name="correcting-answer-wrong"> Fout </button>';
                echo '</form>';
            }
            echo '</div>';
        }
    }
    echo '</div>';

    echo '</div>';

    // DEELNEMER DELETE
    echo '<div class="speurtochtDeelnemer">';
    echo '<h2>Deelnemers verwijderen</h2>';

    $query = "SELECT * FROM players WHERE scavengerHuntId='$scavengerHuntId'";
    $result = mysqli_query($db, $query);
    while ($row = $result->fetch_assoc()) {
        echo '<div class="deelnemer">';
            echo '<form id="deleteForm" action="/server/scavengerHunt/create.php" method="POST">';
            echo '<input type="hidden" name="id" value="'.$scavengerHuntId.'">';
            echo '<input type="hidden" name="playerId" value="'.$row['playerId'].'">';
                echo '<p>'.$row['name'].' | '.$row['email'].'<button type="submit" class="deleteDeelnemer" name="deleteDeelnemer"> Verwijder </button></p>';
            echo '</form>';
        echo '</div>';
    }


    echo '</div>';

    // SPEURTOCHT DELETE //
    echo '<div class="speurtochtDelete">';
    echo '<p>Weet je zeker dat je deze speurtocht wilt verwijderen?</p>';
    
    echo '<form id="startForm" action="/server/scavengerHunt/create.php" method="POST">';
    echo '<input type="hidden" name="id" value="'.$scavengerHuntId.'">';
    echo '<button class="submitStart" type="submit" name="deleteSpeurtocht">Verwijderen</button>';
    echo '</form>';

    echo '</div>';

    // When returning from external php documents to execute forms, reopen the tabs the user left of at.
    if (isset($_GET['cssevent'])) {

    if (str_contains('1', $_GET['cssevent'])) {
        echo '<script>
        $(".speurtochtenBoxMenu").css("display", "none");
        $(".speurtochtDeelnemer").css("display", "block");
        $(".backButton").css("display", "block");
        $(".backButton2").css("display", "none");';
        echo '</script>';
    }
    if (str_contains('2', $_GET['cssevent'])) {
        echo '<script>
        $(".speurtochtenBoxMenu").css("display", "none");
        $(".speurtochtControle").css("display", "block");
        $(".backButton").css("display", "block");
        $(".backButton2").css("display", "none");';
        echo '</script>';
    }
    if (str_contains('3', $_GET['cssevent'])) {
        echo '<script>
        $(".speurtochtenBoxMenu").css("display", "none");
        $(".speurtochtAanpassen").css("display", "block");
        $(".backButton").css("display", "block");
        $(".backButton2").css("display", "none");';
        echo '</script>';
    }
    }
    ?>

</div>