<html>
<?php include ('header.php'); ?>
<div class="content">
    <div class="titleBox">
        <h2 class="pageTitle"> Scoreboard </h2>
    </div>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "resulta";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
}

?>

<html>
<div id="wrapper">
    <div id="div1">
<?php
// 1th winner
$query = "SELECT teamname AS tn_1th FROM results GROUP by points ORDER BY  points DESC LIMIT 0 , 1";
$query_result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($query_result))
{
    echo '<div class="scoreboard 1th">' . $row['tn_1th'] . '</div>';
}

// 2th winner
$query = "SELECT teamname AS tn_2th FROM results GROUP by points ORDER BY  points DESC LIMIT 1 , 1";
$query_result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($query_result))
{
    echo '<div class="scoreboard 2th">' . $row['tn_2th'] . '</div>';
}

// 3th winner
$query = "SELECT teamname AS tn_3th FROM results GROUP by points ORDER BY  points DESC LIMIT 2 , 1";
$query_result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($query_result))
{
    echo '<div class="scoreboard 3th">' . $row['tn_3th'] . '</div>';
}

// losers
$query = "SELECT teamname AS tn_losers FROM results GROUP by points ORDER BY  points DESC LIMIT 3 , 10";
$query_result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($query_result))
{
    echo '<div class="scoreboard losers">' . $row['tn_losers'] . '</div>';
}
?>
</div>

<div id="div2">

<?php
// 1th winner
$query = "SELECT teamname , MAX(points) AS 1th FROM `results`";
$query_result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($query_result))
{
    echo '<div class="scoreboard 1th">' . $row['1th'] . '</div>';
}

// 2th winner
$query = "SELECT teamname , points AS 2th FROM results GROUP by points ORDER BY  points DESC LIMIT 1 , 1";
$query_result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($query_result))
{
    echo '<div class="scoreboard 2th">' . $row['2th'] . '</div>';
}

// 3th winner
$query = "SELECT teamname , points AS 3th FROM results GROUP by points ORDER BY  points DESC LIMIT 2 , 1";
$query_result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($query_result))
{
    echo '<div class="scoreboard 3th">' . $row['3th'] . '</div>';
}

// losers
$query = "SELECT teamname , points AS losers FROM results GROUP by points ORDER BY  points DESC LIMIT 3 , 10";
$query_result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($query_result))
{
    echo '<div class="scoreboard losers">' . $row['losers'] . '</div>';
}

?>
</div>
</div>
</html>
<?php

// $sql = "SELECT * FROM results ORDER BY points DESC limit 10";
// $result = $conn->query($sql);


$conn->close();
?> 
<html>