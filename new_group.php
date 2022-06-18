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
    <div class="main-content">
        <p class="default-title">Create new group</p>
        <form class="hazi-form">
            <div class="hazi-center-left-align">
                <label for="pets">Select pets:</label>
                <select name="pets" id="pet-selector" multiple>
                    <option value="pet1">Pet 1</option>
                    <option value="pet2">Pet 2</option>
                    <option value="pet3">Pet 3</option>
                    <option value="pet4">Pet 4</option>
                    <option value="pet5">Pet 5</option>
                </select>
            </div>
            <div class="hazi-center-left-align">
                <label for="name">Group name:</label>
                <input type="text" name="name" id="name" required>
            </div>
            <input class="default-button" type="submit" value="Create group">
        </form>
        <p class="default-title hazi-padding-top">Join group</p>
        <form class="hazi-form">
            <div class="hazi-center-left-align">
                <label for="groupid">Group ID:</label>
                <input type="text" name="groupid" id="groupid" required>
            </div>
            <input class="default-button" type="submit" value="Join now!">
        </form>
    </div>
</body>

</html>
