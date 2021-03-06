<header>
    <div class="site_logo">
        <img src="resources/icon.png" alt="Logo">
    </div>
    <div class="site_name"><a class="site_name" href="homepage.php"><strong>Petbook</strong></a></div>
    <ul class="header_options">
        <div class="display_mode">Light/Dark mode</div>
        <div class="log_out"><a href="logout.php"><img class="log_out" src="resources/logout.png" alt="log out"></a></div>
    </ul>
</header>
<nav>
    <ul class="menu">
        <?php if (!session_id()) {
            session_start();
        }
        if (!isset($_SESSION["id"]) || (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"])) {
            echo '<script>window.location="login.php"</script>';
        }
        ?>
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