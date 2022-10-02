<html>
<?php include('header.php'); ?>
<div class="content">
    <div class="titleBox">
        <h2 class="pageTitle">  </h2>
    </div>


<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "results";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT all FROM results ORDER BY points DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
?>
<div class="Points">Punten: <?php echo $row["points"]; ?> 
<?php
if($row["points"] = 12) {
    echo "Goed gedaan!";
} else {
    echo "Jammer, probeer het nog een keer!";
}
?>


<?php
}
} else {
echo "0 results";
}
$conn->close();
?> 
<html>

