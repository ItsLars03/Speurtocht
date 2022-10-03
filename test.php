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
    $data = API::delete("/scavengerhunt", array(
        // "ownerId" => "078a0d33-eb8f-4153-830a-a186f73dd4e5",
        "id" => "0b0aab24-0509-4f63-a8a8-d85f1f745f5c"
    ));
    if ($data == null) {
        echo "There is no data.";
    } else {
        var_dump($data);
    }
    ?>
</body>

</html>