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

    <div class="main-content">
        <div class="panel">
            <h3 class="subtitle">Groups</h3>
            <p class="details">Here are all of your groups.</p>
            <p class="details">You can create new groups or delete the ones created by you.</p>
        </div>
        <div class="groups">
            <div class="group">
                <h3 class="group_name">1st group</h3>
                <section class="group_links">
                    <p class="group_field delete">Delete</p>
                </section>
            </div>
            <div class="group">
                <h3 class="group_name">2nd group</h3>
                <section class="group_links">
                    <p class="group_field delete">Delete</p>
                </section>
            </div>
            <div class="group">
                <h3 class="group_name">3rd group</h3>
                <section class="group_links">
                    <p class="group_field delete">Delete</p>
                </section>
            </div>
            <div class="new_group">
                <a class="new_group" href="new_group.php">
                    <img class="plus" src="resources/add_icon.png">
                </a>
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