<?php
require_once "utils/dbmanager.php";
require_once "utils/configuration.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false) {
    header("location: login.php");
    exit;
}

$user_pets = DBManager::getInstance()->getPets($_SESSION["id"]);
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
    <title>Petbook | Pets</title>
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
            <li class="normal option_my_pets"><a class="link_for_menu " href="mypets.php">Pets</a></li>
            <li class="normal option_my_groups"><a class="link_for_menu " href="mygroups.php">Groups</a></li>

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

    <div class="main-content">
        <div class="panel">
            <h3 class="subtitle">User's pets</h3>
            <p class="details">Here are your pets.</p>
            <p class="details">You can add new pets, edit the existing ones or delete them.</p>
        </div>
        <div class="pets">
            <?php
            for ($i = 0; $i < sizeof($user_pets); $i++) {
                echo '<div class="pet">';
                echo '<h3 class="pet_name">1st pet</h3>';
                echo '<div class="photo_container">';
                echo '<img class="pet_photo" src="resources/nopicture.png" alt="no picture">';
                echo '</div>';
                echo '<p class="pet_field">Name:</p>';
                echo '<p class="pet_field_output"><i>lorem</i></p>';
                echo '<p class="pet_field">Breed:</p>';
                echo '<p class="pet_field_output"><i>lorem</i></p>';
                echo '<p class="pet_field">Meals / day:</p>';
                echo '<p class="pet_field_output"><i>lorem</i></p>';
                echo '<p class="pet_field">Relationship with animals:</p>';
                echo '<p class="pet_field_output"><i>lorem</i></p>';
                echo '<section class="pet_links">';
                echo '<p class="pet_field with_link"><a href="calendar.php" class="link for_pet">Calendar</a><img class="new_page" src="resources/newpage.png"></p>';
                echo '<p class="pet_field with_link"><a href="multimedia.php" class="link for_pet">Multimedia</a><img class="new_page" src="resources/newpage.png"></p>';
                echo  '<p class="pet_field delete">Delete</p>';
                echo '</section>';
                echo '</div>';
            }
            ?>
            <div class="new_pet">
                <a class="new_pet" href="new_pet.php">
                    <img class="plus" src="resources/add_icon.png">
                </a>
            </div>
        </div>
        <div class="space">
        </div>
        <!-- friends' pets-->
        <div class="panel friends">
            <h3 class="subtitle">Friends' pets</h3>
            <p class="details">Here are your friend's pets.</p>
            <p class="details">You don't have permissions to add, edit or delete their pets.</p>
        </div>
        <div class="pets">
            <div class="pet friends">
                <h3 class="pet_name">1st pet</h3>
                <div class="photo_container">
                    <img class="pet_photo" src="resources/nopicture.png">
                </div>
                <p class="pet_field">Name:</p>
                <p class="pet_field_output"><i>lorem</i></p>
                <p class="pet_field">Breed:</p>
                <p class="pet_field_output"><i>lorem</i></p>
                <p class="pet_field">Meals / day:</p>
                <p class="pet_field_output"><i>lorem</i></p>
                <p class="pet_field">Relationship with animals:</p>
                <p class="pet_field_output"><i>lorem</i></p>
                <section class="pet_links">
                    <p class="pet_field with_link"><a href="calendar.php" class="link for_pet">Calendar</a><img class="new_page" src="resources/newpage.png"></p>
                    <p class="pet_field with_link"><a href="multimedia.php" class="link for_pet">Multimedia</a><img class="new_page" src="resources/newpage.png"></p>
                </section>
            </div>
            <div class="pet friends">
                <h3 class="pet_name">2nd pet</h3>
                <div class="photo_container">
                    <img class="pet_photo" src="resources/nopicture.png">
                </div>
                <p class="pet_field">Name:</p>
                <p class="pet_field_output"><i>lorem</i></p>
                <p class="pet_field">Breed:</p>
                <p class="pet_field_output"><i>lorem</i></p>
                <p class="pet_field">Meals / day:</p>
                <p class="pet_field_output"><i>lorem</i></p>
                <p class="pet_field">Relationship with animals:</p>
                <p class="pet_field_output"><i>lorem</i></p>
                <section class="pet_links">
                    <p class="pet_field with_link"><a href="calendar.php" class="link for_pet">Calendar</a><img class="new_page" src="resources/newpage.png"></p>
                    <p class="pet_field with_link"><a href="multimedia.php" class="link for_pet">Multimedia</a><img class="new_page" src="resources/newpage.png"></p>
                </section>
            </div>
            <div class="pet friends">
                <h3 class="pet_name">3rd pet</h3>
                <div class="photo_container">
                    <img class="pet_photo" src="resources/nopicture.png">
                </div>
                <p class="pet_field">Name:</p>
                <p class="pet_field_output"><i>lorem</i></p>
                <p class="pet_field">Breed:</p>
                <p class="pet_field_output"><i>lorem</i></p>
                <p class="pet_field">Meals / day:</p>
                <p class="pet_field_output"><i>lorem</i></p>
                <p class="pet_field">Relationship with animals:</p>
                <p class="pet_field_output"><i>lorem</i></p>
                <section class="pet_links">
                    <p class="pet_field with_link"><a href="calendar.php" class="link for_pet">Calendar</a><img class="new_page" src="resources/newpage.png"></p>
                    <p class="pet_field with_link"><a href="multimedia.php" class="link for_pet">Multimedia</a><img class="new_page" src="resources/newpage.png"></p>
                </section>
            </div>
            <div class="pet friends">
                <h3 class="pet_name">4th pet</h3>
                <div class="photo_container">
                    <img class="pet_photo" src="resources/nopicture.png">
                </div>
                <p class="pet_field">Name:</p>
                <p class="pet_field_output"><i>lorem</i></p>
                <p class="pet_field">Breed:</p>
                <p class="pet_field_output"><i>lorem</i></p>
                <p class="pet_field">Meals / day:</p>
                <p class="pet_field_output"><i>lorem</i></p>
                <p class="pet_field">Relationship with animals:</p>
                <p class="pet_field_output"><i>lorem</i></p>
                <section class="pet_links">
                    <p class="pet_field with_link"><a href="calendar.php" class="link for_pet">Calendar</a><img class="new_page" src="resources/newpage.png"></p>
                    <p class="pet_field with_link"><a href="multimedia.php" class="link for_pet">Multimedia</a><img class="new_page" src="resources/newpage.png"></p>
                </section>
            </div>
        </div>
    </div>

    <footer>
        <p class="p_footer">Idea 1</p>
        <p class="p_footer">Idea 2</p>
        <p class="p_footer copyright">© Copyright 2022 PetBook</p>
    </footer>

</body>

</html>