<?php
set_include_path("utils");
include "dbmanager.php";
$result = DBManager::getInstance()->getFeedingTime();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/calendar.css">
    <link rel="stylesheet" href="styles/hazi.css">
    <link rel="stylesheet" href="styles/global.css">
    <link rel="icon" href="../resources/icon.png" type="image/x-icon">
    <title>Calendar</title>
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
    <div class="main-content">
        <p class="default-title">Calendar</p>
        <div class="center">
            <div id="calendar">
                <div id="header">
                    <div id="prev-month-button" class="clickable">&lt;&lt;&lt;</div>
                    <div id="header-date" class="clickable">Today</div>
                    <div id="next-month-button" class="clickable">&gt;&gt;&gt;</div>
                </div>
                <div id="days"></div>
                <div id="calendar-body"></div>
            </div>
        </div>
        <form class="hazi-form">
            <fieldset>
                <legend>Filter by pets</legend>
                <?php
                foreach ($result as $pet) {
                    echo '<input type="checkbox" onclick="onPetFilterChanged()" name="pet-filter" value="' . $pet["pet_id"] . '" id="' . $pet["pet_id"] . '" checked>' . '</input>';
                    echo '<label for="' . $pet["pet_id"] . '">' . $pet["name"] . '</label>';
                }
                ?>
            </fieldset>
        </form>

        <table id="feed-values">
            <tr>
                <th>id</th>
                <th>pet_id</th>
                <th>feed_time</th>
            </tr>
            <?php
            foreach ($result as $line) {
                echo "<tr>";
                foreach ($line as $column) { ?>
                    <td class="feed-time-cell">
                        <?php echo $column; ?>
                    </td>
            <?php }
                echo "</tr>";
            }
            ?>
        </table>
    </div>
    <script src="scripts/calendar.js"></script>
</body>

</html>