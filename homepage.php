<?php
require_once "utils/configuration.php";
require_once "utils/filemanager.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false) {
    header("location: login.php");
    exit;
}

$user_data = DBManager::getInstance()->returnUserData($_SESSION["id"]);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="styles/global.css" rel="stylesheet">
    <link href="styles/sofron.css" rel="stylesheet">
    <link rel="icon" href="../resources/icon.png" type="image/x-icon">
    <title>Petbook | My profile</title>
</head>

<body>
    <?php include "shared/header.php" ?>

    <div class="main-content">
        <div class="panel">
            <h3 class="subtitle">User's profile</h3>
            <p class="details">Here is your profile.</p>
        </div>
        <div class="user_profile">
            <p class="user-details">First name: </p>
            <p class="data"><i><?php echo $user_data["firstname"]; ?></i></p>
            <p class="user-details">Last name: </p>
            <p class="data"><i><?php echo $user_data["lastname"]; ?></i></p>
            <p class="user-details">Middle name: </p>
            <p class="data"><i><?php echo $user_data["middlename"]; ?></i></p>
            <p class="user-details">E-mail:</p>
            <p class="data"><i><?php echo $user_data["email"]; ?></i></p>

            <p class="user-details">Export data</p>
            <form action="" method="post">
                <input type="submit" name="export-csv" value="CSV">
                <input type="submit" name="export-pretty" value="Pretty">
            </form>
            <?php
            if (isset($_POST["export-csv"])) {
                $file = new FileManager();
                $file->exportCSV();
            } else if (isset($_POST["export-pretty"])) {
                $file = new FileManager();
                $file->exportPretty();
            }
            ?>
        </div>
    </div>

    <?php
    include "shared/footer.php"
    ?>
</body>

</html>