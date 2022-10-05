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

?>

<div class="content">
    <div class="titleBox">
        <h2 class="pageTitle"> Eindstand </h2>
    </div>

    <html>
    <div id="wrapper">
        <div id="sc1">
            <?php

            foreach ($response->data as $player) {

                $answers = (array) $player->answers;

                // var_dump($answers);
                // echo "<br>";
                // echo "<br>";
                // echo "<br>";
                function compare_weights($a, $b)
                {
                    echo "TEST!!!";

                    $countA = count(array_filter($a, function ($v, $k) {
                        return $k == "correct" && $v;
                    }, ARRAY_FILTER_USE_BOTH));
                    $countB = count(array_filter($b, function ($v, $k) {
                        return $k == "correct" && $v;
                    }, ARRAY_FILTER_USE_BOTH));
                    if ($countA == $countB) {
                        return 0;
                    }

                    return $countA < $countB ? -1 : 1;
                }

                $answers2 = usort($answers, "compare_weights");

                var_dump($answers2);

                // echo $player->name;
                // foreach ($answers as $answer) {


                //     $filter = array_filter((array) $answer, function ($v, $k) {
                //         return $k == "correct" && $v;
                //     }, ARRAY_FILTER_USE_BOTH);
                //     echo count($filter);
                // }
                // echo "<br>";
                // echo "<br>";
                // echo "<br>";


                // var_dump($answers2);
            }




            return;



            //sort by most answers correct

            // 1th winner
            echo '<div class="scoreboard 1th">' . $row["tn_1th"] . "</div>";


            // 2th winner
            echo '<div class="scoreboard 2th">' . $row["tn_2th"] . "</div>";

            // 3th winner
            echo '<div class="scoreboard 3th">' . $row["tn_3th"] . "</div>";

            // losers
            echo '<div class="scoreboard losers">' . $row["tn_losers"] . "</div>";
            ?>
        </div>
        <div id="sc2">
            <?php
            // 1th winner
            $query = "SELECT teamname , MAX(points) AS 1th FROM `results` WHERE speurtocht_id = '0'";
            $query_result = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_assoc($query_result)) {
                echo '<div class="scoreboard 1th">' . $row["1th"] . "</div>";
            }

            // 2th winner
            $query =
                "SELECT teamname , points AS 2th FROM results WHERE speurtocht_id = '0' GROUP by points ORDER BY  points DESC LIMIT 1 , 1";
            $query_result = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_assoc($query_result)) {
                echo '<div class="scoreboard 2th">' . $row["2th"] . "</div>";
            }

            // 3th winner
            $query =
                "SELECT teamname , points AS 3th FROM results WHERE speurtocht_id = '0' GROUP by points ORDER BY  points DESC LIMIT 2 , 1";
            $query_result = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_assoc($query_result)) {
                echo '<div class="scoreboard 3th">' . $row["3th"] . "</div>";
            }

            // losers
            $query =
                "SELECT teamname , points AS losers FROM results WHERE speurtocht_id = '0' GROUP by points ORDER BY  points DESC LIMIT 3 , 10";
            $query_result = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_assoc($query_result)) {
                echo '<div class="scoreboard losers">' . $row["losers"] . "</div>";
            }
            ?>
        </div>
    </div>

    </html>
    <?php // $sql = "SELECT * FROM results ORDER BY points DESC limit 10";
    // $result = $conn->query($sql);

    $conn->close(); ?>
    <html>