<?php
// if (!empty($_SESSION['UID'])) {
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/speurtocht.css">
    <link rel="stylesheet" href="/ques.css">
    <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.0.7/css/all.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link href='https://fonts.googleapis.com/css?family=Black Han Sans' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Source Sans Pro' rel='stylesheet'>
    <script src="https://cdn.socket.io/4.5.2/socket.io.js"></script>
    <script src="/scripts/init.js"></script>
    <script src="/scripts/speurtocht.js"></script>
    <title>Speurtocht</title>
</head>

<body>
    <div class="headerBox">
        <h1 class="headerTitle"> Speurtocht </h1>
    </div>
    <?php
    // $db = mysqli_connect('p11k3t3.lesonline.nu', 'deb85590_p11k3t3', 'e7mUNBssyG', 'deb85590_p11k3t3');
    // $db = mysqli_connect('localhost', 'root', '', 'speurtocht');
    // } else {
    // header('Location: index');
    // }
    ?>
    <?php
    if (!isset($_COOKIE["user-id"]) && str_starts_with($_SERVER['REQUEST_URI'], "/admin/")) {
        header("location: /login.php");
        return;
    }

    if (!isset($_COOKIE['player-id']) && str_starts_with($_SERVER['REQUEST_URI'], "/questions")) {
        header("location: /");
        return;
    }

    ?>


</body>

</html>