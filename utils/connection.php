<?php

$dbServer = "localhost";
$dbUsername = "root";
$dbPassword = "password";
$dbName = "db";

$con = mysqli_connect($dbServer, $dbUsername, $dbPassword, $dbName) or trigger_error("Failed to connect to the database.");
