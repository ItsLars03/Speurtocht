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
$dbname = "resulta";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT MAX(points) AS ids FROM `results`"; 
$query_result = mysqli_query($conn , $query);

while($row = mysqli_fetch_assoc($query_result)){
  echo "max value is"." ".$row['ids'];
}

$sql = "SELECT * FROM results ORDER BY points DESC limit 10";
$result = $conn->query($sql);

if ($result->num_rows > 1) {
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
echo "Fout! Neem contact op met de beheerder";
}
$conn->close();
?> 
<html>

