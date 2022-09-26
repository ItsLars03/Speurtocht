<?php include('header.php'); ?>
<div class="content">
    <div class="titleBox">
        <h2 class="pageTitle"> Beheerderspaneel </h2>
    </div>

    <?php
    echo '<div class="speurtochtenBox">';
        echo '<p>Speurtocht</p>';
    echo '</div>';

    echo '<div class="creatingBox">';
        echo '<h2>Speurtocht Aanmaken</h2>';
        echo '<form action="beheerderpaneel.php" method="POST">';
            echo '<input class="inputField" type="text" name="name" placeholder="Speurtocht naam" required>';
            echo '<h2>Vragen</h2>';
            
            echo '<input class="one" type="checkbox">';
            echo '<label for="one">Open vraag</label>';
            echo '<input class="two" type="checkbox">';
            echo '<label for="one">Foto vraag</label></br>';
            echo '<textarea class="inputField" name="vraagText" placeholder="Vul hier uw vraag in" required></textarea>';
            echo '<a class="extra">Extra vraag toevoegen</a><br/>';

            echo '<button class="buttonForm" type="submit" name="login">Speurtocht Aanmaken</button>';
        echo '</form>';
    echo '</div>';

    echo '<div class="createBox">';

        echo '<a class="createSPT">Speurtocht Aanmaken</a>';

    echo '</div>';
    ?>

</div>

</body>
</html>