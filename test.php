<?php
include('./utils/api.php')

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    $data = API::post("/scavengerhunt", array(
        "ownerId" => "7386d262-4519-482a-9260-9190d97066f3",
        "name" => "Mijn 3e speurtocht."
    ));
    if ($data == null) {
        echo "There is no data.";
    } else {
        var_dump($data);
    }
    ?>
</body>

</html>