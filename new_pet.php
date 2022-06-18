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
    <title>Pet</title>
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
        <form class="hazi-form">
            <p class="default-title">Add new pet</p>
            <div class="hazi-center-left-align">
                <label for="petname">Pet name: <i>(required)</i></label>
                <input type="text" id="petname" name="petname" required>
            </div>
            <div>
                <label for="meals">Meals per day: <i>(optional)</i></label>
                <input type="number" name="meals" id="meals" min="1" max="4" onclick="addFields()">
            </div>
            <div id="hazi-dynamic-fields">
            </div>
            <div class="hazi-center-left-align">
                <label for="restrictions">Restrictions: <i>(optional)</i></label>
                <textarea class="hazi-input-width" name="restrictions" id="restrictions" rows="5"></textarea>
            </div>
            <div class="hazi-center-left-align">
                <label for="media">Media: <i>(optional)</i></label>
                <input type="file" name="media" id="media" multiple>
            </div>
            <div class="hazi-center-left-align">
                <label for="medical-history">Medical history: <i>(optional)</i></label>
                <textarea class="hazi-input-width" name="medical-history" id="medical-history" rows="5"></textarea>
            </div>
            <div class="hazi-center-left-align">
                <label for="relationship">Relationships: <i>(optional)</i></label>
                <textarea class="hazi-input-width" name="relationship" id="relationship" rows="3"></textarea>
            </div>
            <input class="default-button" type="submit" value="Register now!">
        </form>
    </div>
</body>

</html>