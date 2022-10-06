<html>
<?php include("header.php") ?>
<?php include("./utils/api.php") ?>

<?php
if (!isset($_GET["id"])) {
    header("Location: /");
    return;
}

$response = API::get("/scavengerhunt/answers/getbyplayer/" . $_GET["id"], array());

if (!isset($response) || !isset($response->success) || !$response->success) {
    //TODO: handle error.
    return;
}

$players = $response->data;

if (count($players) == 0) {
    echo '<div class="scoreboard noResults"> Er zijn op dit moment nog geen resultaten.</div>';
    echo '<a class="buttonForm resultsButton" href="/admin/speurtochtpaneel.php?id='. $_GET["id"] .'">Terug naar overzicht</a>';
    return;
}

usort($players, function ($a, $b) {
    $countA = isset($a) && isset($a->answers) ? count(array_filter($a->answers, function ($v) {
        return isset($v) && isset($v->correct) && $v->correct;
    })) : 0;
    $countB = isset($b) && isset($b->answers) ? count(array_filter($b->answers, function ($v) {
        return isset($v) && isset($v->correct) && $v->correct;
    })) : 0;
    if ($countA == $countB) {
        return 0;
    }

    return $countA < $countB ? 1 : -1;
});

?>

<div class="content">
    <div class="titleBox">
        <h2 class="pageTitle"> Eindstand </h2>
    </div>

    <html>
    <div id="wrapper">
        <div id="sc1">
            <?php
            foreach ($players as $index => $player) {
                switch ($index) {
                    case 0:
                        echo '<div class="scoreboard 1th">' . $player->name . "</div>";
                        break;
                    case 1:
                        echo '<div class="scoreboard 2th">' . $player->name . "</div>";
                        break;
                    case 2:
                        echo '<div class="scoreboard 3th">' . $player->name . "</div>";
                        break;
                    default:
                        echo '<div class="scoreboard losers">' . $player->name . "</div>";
                }
            }
            ?>
        </div>
        <div id="sc2">
            <?php
            foreach ($players as $index => $player) {
                $points = isset($player->answers) ? count(array_filter($player->answers, function ($v) {
                    return isset($v) && isset($v->correct) && $v->correct;
                })) : 0;
                switch ($index) {
                    case 0:
                        echo '<div class="scoreboard 1th">' . $points . "</div>";
                        break;
                    case 1:
                        echo '<div class="scoreboard 2th">' . $points . "</div>";
                        break;
                    case 2:
                        echo '<div class="scoreboard 3th">' . $points . "</div>";
                        break;
                    default:
                        echo '<div class="scoreboard losers">' . $points . "</div>";
                }
            }
            ?>
        </div>
    </div>

    </html>
    <html>