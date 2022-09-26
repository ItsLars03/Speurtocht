<html>
<?php include('header.php'); ?>
<div class="content">
    <div class="titleBox">
        <h2 class="pageTitle"> Aanmelden </h2>
    </div>
    <?php

    ?>
    <form id="loginForm">
        <input class="login-register-form" type="text" id="email" placeholder="E-mailadres"><br><br>
        <input class="login-register-form" type="password" id="password" placeholder="Wachtwoord"><br><br>
        <input class="login-register-btn" type="submit" value="AANMELDEN">
        <h4> </h4>
        <a class="elseRegister" href="/register">Nog geen account account? Maak er een</a>
    </form>
</div>

<script>
    const form = document.querySelector("#loginForm")
    form.onsubmit = (event) => {
        event.preventDefault()

        const data = {}
        for (const element of event.target.elements) {
            data[element.name] = element.value
        }

        makeRequest(`${BACKEND}/login`, "POST", data)
            .then((res) => {
                console.log(res)
            }).catch((e) => {
                console.error("this!", e.message)
            })
    }
</script>

</body>

</html>