<html>
<?php include('header.php'); ?>
<div class="content">
    <div class="titleBox">
        <h2 class="pageTitle"> Aanmelden </h2>
    </div>
    <?php

    ?>
    <form action="./server/login.php">
        <input class="login-register-form" name="email" type="text" id="email" placeholder="E-mailadres"><br><br>
        <input class="login-register-form" name="password" type="password" id="password"
            placeholder="Wachtwoord"><br><br>
        <input class="login-register-btn" name="submit" type="submit" value="AANMELDEN">
        <h4> </h4>
        <a class="elseRegister" href="/register">Nog geen account account? Maak er een</a>
    </form>
</div>

</body>

</html>