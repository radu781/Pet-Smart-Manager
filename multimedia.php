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
        <div class="site_name"><a class="site_name" href="homepage.html"><strong>Petbook</strong></a></div>
        <ul class="header_options">
            <div class="display_mode">Light/Dark mode</div>
            <div class="log_out"><img class="log_out" src="resources/logout.png"></div>
        </ul>
    </header>
    <nav>
        <ul class="menu">
            <li class="normal option_my_profile"><a class="link_for_menu " href="homepage.html">My profile</a></li>
            <li class="normal option_my_pets"><a class="link_for_menu " href="mypets.html">My pets</a></li>
            <li class="normal option_my_groups"><a class="link_for_menu " href="mygroups.html">My groups</a></li>

            <!-- responsive design -->
            <li class="phone option_my_profile">
                <a class="link_for_menu" href="homepage.html">
                    <img src="resources/user.png">
                </a>
            </li>
            <li class="phone option_my_pets">
                <a class="link_for_menu " href="mypets.html">
                    <img src="resources/pets.png">
                </a>
            </li>
            <li class="phone option_my_groups">
                <a class="link_for_menu " href="mygroups.html">
                    <img src="resources/groups.png">
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
            <?php foreach ($meals as $meal) {
                echo '<div class="cell">';
                echo '<img src="multimedia/' . $meal["pet_id"] . "/" . $meal["filename"] . '">';
                echo '<p>' . $meal["description"] . '</p>';
                echo '<button class="default-button">Details</button>';
                echo '</div>';
            } ?>
        </div>
    </div>
    <script src="scripts/multimedia.js"></script>
</body>

</html>
