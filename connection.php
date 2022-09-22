<?php

$dbServer = "localhost";
$dbUsername = "root";
$dbPassword = "password";
$dbName = "db";

$con = mysqli_connect($dbServer, $dbUsername, $dbPassword, $dbName) or trigger_error("Het is niet gelukt om verbinding te maken met de database probeer het later opnieuw");

?>