<?php
include('../utils/api.php');

/**
 * Error codes:
 * 0 = Unknown.
 * 1 = invalid email.
 * 2 = email and password fields are required.
 * 3 = wrong credentials.
 */

if (!isset($_GET['email']) || !isset($_GET['password'])) {
    header('Location: ../login.php');
}

// $existingHashFromDb = '$2y$10$dM55BFS8Ln8mHx.wMFAgqe7sr';
// $email = 'lars@lars.com';
$email = $_GET['email'];
$password = $_GET['password'];
//$isPasswordCorrect = password_verify($_POST['password'], $existingHashFromDb);
// if (password_verify($_POST['password'], $existingHashFromDb)) {
//     echo 'Password is valid!';
//     $erroCode = 2;
// } else {
//     echo 'Invalid password.';
//     $erroCode = 2;
// };

$response = API::get("/users/login", [
    "email" => $email,
    "password" => $password
]);

if (!isset($response) || !isset($response->success) || !isset($response->data) || !$response->success) {
    if (!isset($response) || !isset($response->message)) {
        header("location: ../login.php");
        return;
    }

    $message = $response->message;

    $erroCode = 0;

    if ($message == "Not a valid email.") {
        echo "1";
        $erroCode = 1;
    } else if ($message == "Email and password are required fields.") {
        echo "2";
        $erroCode = 2;
    } else if ($message == "Could not find the user with these credentials.") {
        echo "3";
        $erroCode = 3;
    }

    header("location: ../login.php?errorCode=" . $erroCode);
}


setcookie("user-id", $response->data->userId, time() + 60 * 60 * 24 * 14, "/");

header("location: ../admin/beheerderpaneel.php");



// echo $response->data->userId;