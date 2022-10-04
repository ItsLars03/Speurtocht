<?php
include('./header.php');
include('./utils/api.php');


//check valid uri
// - if not redirect to root.
if (!isset($_GET['id'])) {
    echo "no id?";
    // header("Location: /");
    return;
}

$response = API::get('/mail/' . $_GET['id'], array());

//invalid id
//TODO: Maybe make an error message instead of redirecting.
if (!isset($response) || !isset($response->success) || !$response->success) {
    if (isset($response->message)) echo $response->message;
    // else header("Location: /");
    var_dump($response);
    return;
}

$email = $response->data->email;
$scavengerHuntId = $response->data->scavengerHuntId;
?>

<div class="content">
    <div class="titleBox">
        <h2 class="pageTitle"> Login </h2>
    </div>

    <form action="/server/join.php">
        <input class="login-register-form" name="name" type="text" id="name" placeholder="Naam">
        <br />
        <input class="login-register-form" type="hidden" name="email" value="<?php echo $email ?>">
        <input class="login-register-form" type="hidden" name="scavengerhuntid" value="<?php echo $scavengerHuntId ?>">
        <br />
        <input class="login-register-btn" type="submit" value="login">
    </form>

</div>