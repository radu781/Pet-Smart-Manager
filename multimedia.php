<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/multimedia.css">
    <link rel="stylesheet" href="styles/global.css">
    <link rel="icon" href="../resources/icon.png" type="image/x-icon">
    <title>Multimedia</title>
</head>

<body>
    <header>
        <div class="site_logo">
            <img src="resources/icon.png" alt="Logo">
        </div>
        <div class="site_name"><a class="site_name" href="homepage.php"><strong>Petbook</strong></a></div>
        <ul class="header_options">
            <div class="display_mode">Light/Dark mode</div>
            <div class="log_out"><img class="log_out" src="resources/logout.png" alt="log out"></div>
        </ul>
    </header>
    <nav>
        <ul class="menu">
            <li class="normal option_my_profile"><a class="link_for_menu " href="homepage.php">My profile</a></li>
            <li class="normal option_my_pets"><a class="link_for_menu " href="mypets.php">My pets</a></li>
            <li class="normal option_my_groups"><a class="link_for_menu " href="mygroups.php">My groups</a></li>

            <!-- responsive design -->
            <li class="phone option_my_profile">
                <a class="link_for_menu" href="homepage.php">
                    <img src="resources/user.png" alt="user">
                </a>
            </li>
            <li class="phone option_my_pets">
                <a class="link_for_menu " href="mypets.php">
                    <img src="resources/pets.png" alt="pets">
                </a>
            </li>
            <li class="phone option_my_groups">
                <a class="link_for_menu " href="mygroups.php">
                    <img src="resources/groups.png" alt="groups">
                </a>
            </li>
        </ul>
    </nav>
    <hr>
    <?php
    include 'utils/dbmanager.php';
    $meals = DBManager::getInstance()->getPetMeals();
    ?>
    <div class="main-content">
        <p class="default-title">Multimedia resources</p>
        <div class="main">
            <?php
            $prevMeal = $meals[0];
            if (sizeof($meals) > 0) {
                echo '<div class="cell-group">';
            }
            for ($i = 0; $i < sizeof($meals); $i++) {
                $currentMeal = $meals[$i];

                if ($prevMeal["pet_id"] !== $currentMeal["pet_id"]) {
                    echo '</div>';
                    echo '<div class="cell-group">';
                }

                echo '<div class="cell">';
                echo '<p>' . $currentMeal["name"] . '</p>';
                echo '<img src="multimedia/' . $currentMeal["pet_id"] . "/" . $currentMeal["filename"] . '" width="200" height="200" alt="user provided image">';
                echo '<p>' . $currentMeal["description"] . '</p>';
                echo '<button class="default-button">Details</button>';
                echo '</div>';

                $prevMeal = $currentMeal;
            }
            if (sizeof($meals) > 0) {
                echo '</div>';
            } ?>
        </div>
    </div>
    <script src="scripts/multimedia.js"></script>
</body>

</html>
