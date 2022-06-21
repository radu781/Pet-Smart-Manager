<?php
require_once "utils/dbmanager.php";
require_once "utils/configuration.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false) {
    header("location: login.php");
    exit;
}

$user_groups = DBManager::getInstance()->getGroups($_SESSION["id"]);
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
    <title>Petbook | Groups</title>
</head>

<body>
    <?php include "shared/header.php" ?>


    <div class="main-content">
        <div class="panel">
            <h3 class="subtitle">Groups</h3>
            <p class="details">Here are all the groups, exclusively created by you.</p>
            <p class="details">You can create new groups or delete the existing ones.</p>
            <p class="details">You can join groups created by others using the key of their group.</p>
            <a class="join_group" href="joingroup.php">
                <p class="join_group">Join group</p>
            </a>
        </div>
        <div class="groups">
            <?php
            for ($i = 0; $i < sizeof($user_groups); $i++) {
                $group_id = $user_groups[$i];
                $group_info = DBManager::getInstance()->getPetNameAndBreed($group_id["id"]);
                echo '<div class="group">';
                echo    '<h3 class="group_name">'. $user_groups[$i]["name"].'</h3>';
                echo    '<section class="group_links">';
                echo        '<p class="group_field">Access key:</p>';
                echo        '<p class="group_field join_key"><i>'. $user_groups[$i]["invite_hash"].'</i></p>';
                echo        '<p class="group_field delete">Delete</p>';
                echo    '</section>';
                echo '</div>';
            }
            ?>
            <div class="new_group">
                <a class="new_group" href="new_group.php">
                    <img class="plus" src="resources/add_icon.png">
                </a>
            </div>
        </div>
    </div>

    <?php include "shared/footer.php" ?>

</body>

</html>
