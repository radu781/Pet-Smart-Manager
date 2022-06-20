<?php
require_once "utils/dbmanager.php";
require_once "utils/configuration.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false) {
    header("location: login.php");
    exit;
}

/* take pet_id */
$pet_id = $_GET["id"];

/* return data about pet */
$pet_info = DBManager::getInstance()->getPetData($pet_id);
$pet_meals = DBManager::getInstance()->getPetNoOfMeals($pet_id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="styles/global.css" rel="stylesheet">
    <link href="styles/sofron.css" rel="stylesheet">
    <link href="styles/petdetails.css" rel="stylesheet">
    <link rel="icon" href="../resources/icon.png" type="image/x-icon">
    <title>Petbook | Pet Details</title>
</head>

<body>
    <?php include "shared/header.php" ?>

    <div class="main-content">
        <div class="panel">
            <?php
            echo '<h3 class=\"subtitle\">' . $pet_info["name"] . '</h3>';
            ?>
            <p class="details">Here you can see more things regarding your pet.</p>
        </div>
        <section class="pet_details">
            <div class="pet_detail breed border-right">
                <h5 class="pet_detail_title">Breed</h5>
                <?php
                echo '<p class="content"><i>' . $pet_info["breed"] . '</i></p>';
                ?>
            </div>
            <div class="pet_detail meals  border-right">
                <h5 class="pet_detail_title">Meals / day</h5>
                <?php
                echo '<p class="content"><i>' . $pet_meals . '</i></p>';
                ?>
            </div>
            <div class="pet_detail restrictions border-right">
                <h5 class="pet_detail_title">Restrictions</h5>
                <?php
                echo '<p class="content"><i>' . $pet_info["restrictions"] . '</i></p>';
                ?>
            </div>
            <div class="pet_detail medical_history border-right">
                <h5 class="pet_detail_title">Medical history</h5>
                <?php
                echo '<p class="content"><i>' . $pet_info["medical_history"] . '</i></p>';
                ?>
            </div>
            <div class="pet_detail relationships">
                <h5 class="pet_detail_title">Relationships</h5>
                <?php
                echo '<p class="content"><i>' . $pet_info["relationships"] . '</i></p>';
                ?>
            </div>
        </section>
        <section class="pet_links">
            <a href="calendar.php" class="link_for_pet">
                <p class="pet_link left">Calendar</p>
            </a>
            <a href="multimedia.php" class="link_for_pet">
                <p class="pet_link right">Multimedia</p>
            </a>
        </section>
    </div>

    <?php
    include "shared/footer.php"
    ?>

</body>

</html>