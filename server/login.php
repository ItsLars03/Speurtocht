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

$email = $_GET['email'];
$password = $_GET['password'];

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

if (!isset($response) || !isset($response->success) || !$response->success) {
    //handle error - (server error OR wrong password.)
    return;
}


setcookie("user-id", $response->data->userId, time() + 60 * 60 * 24 * 14, "/");
header("location: ../admin/beheerderpaneel.php");


// echo $response->data->userId;