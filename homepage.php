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
            <li class="normal option_my_pets"><a class="link_for_menu " href="mypets.html">Pets</a></li>
            <li class="normal option_my_groups"><a class="link_for_menu " href="mygroups.html">Groups</a></li>

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

    <div class="main-content">
        <div class="panel">
            <h3 class="subtitle">User's profile</h3>
        </div>
        <div class="user_profile">
            <p class="user-details">Username:</p>
            <p class="user-details">Password:</p>
            <p class="user-details">E-mail:</p>
            <p class="user-details">Pets number:</p>
            <p class="user-details">Groups number:</p>
        </div>
    </div>

    <footer>
        <p class="p_footer">Idea 1</p>
        <p class="p_footer">Idea 2</p>
        <p class="p_footer copyright">© Copyright 2022 Petbook</p>
    </footer>

</body>

</html>