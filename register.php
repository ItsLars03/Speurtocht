<html>
<?php include('header.php'); ?>
<div class="content">
    <div class="titleBox">
        <h2 class="pageTitle"> Registreren </h2>
    </div>
    <?php

    ?>
    <form action="/server/register.php">
        <input class="login-register-form" name="email" type="text" id="email" placeholder="E-mailadres"><br><br>
        <input class="login-register-form" name="password" type="password" id="password" placeholder="Wachtwoord"><br><br>
        <input class="login-register-btn" type="submit" value="REGISTREREN">
        <h4> </h4>
        <a class="elseLogin" href="/login.php">Al een account? Log hier in</a>
    </form>
</div>

</body>

</html>