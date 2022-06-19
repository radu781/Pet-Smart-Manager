<?php
 // Include config file
 require_once "utils/dbmanager.php";
 require_once "utils/ValidateInput.php";
 require_once "utils/configuration.php";
 
// Check if the user is not logged in, if yes then redirect him to login
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false) {
    header("location: login.php");
    exit;
}

$my_pets = DBManager::getInstance()->getPets($_SESSION["id"]);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/global.css">
    <link rel="stylesheet" href="styles/hazi.css">
    <link rel="icon" href="../resources/icon.png" type="image/x-icon">
    <script src="scripts/hazi.js"></script>
    <title>Group</title>
</head>

<body>
    <?php include "shared/header.php" ?>

    <hr>
    <div class="main-content">
        <p class="default-title">Create new group</p>
        <form class="hazi-form">
            <div class="hazi-center-left-align">
                <label for="pets">Select pets:</label>
                <select name="pets" class="hazi-selector" multiple>
                    <?php 
                        for ($i = 0; $i < sizeof($my_pets); $i++) {
                            $pet_id = $my_pets[$i];
                            $pet_name = DBManager::getInstance()->getPetName($pet_id["pet_id"]);
                            echo "<option value=\"" . $my_pets[$i]["pet_id"] . "\">" . $pet_name .  "</option>\n";
                        }
                    ?>
                </select>
            </div>
            <div class="hazi-center-left-align">
                <label for="name">Group name:</label>
                <input type="text" name="name" id="name" required>
            </div>
            <input class="default-button" type="submit" value="Create group">
        </form>
        <p class="default-title hazi-padding-top">Join group</p>
    </div>
    <?php include "shared/footer.php" ?>
</body>

</html>
