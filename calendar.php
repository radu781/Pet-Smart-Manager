<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/calendar.css">
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
        <div class="display_mode">Light/Dark mode</div>
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
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Suscipit quo voluptatum provident accusamus at.
            Porro fugiat quisquam possimus esse accusamus facere, obcaecati tenetur neque saepe, non dicta, et totam
            hic?</p>
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
        <?php
        set_include_path("utils");
        include "dbmanager.php";
        $result = DBManager::getInstance()->getFeedingTime();
        ?>

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


        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Dolorum ea commodi deserunt laboriosam assumenda
            iste expedita quos provident saepe? Voluptatibus molestias inventore minima voluptatum accusantium, rerum
            accusamus expedita ad aliquam.
            Excepturi nemo natus reprehenderit dolore hic unde fugiat doloribus, ducimus sunt nulla. Nisi quod
            consequuntur numquam, atque odit dicta. Similique minus laudantium excepturi, tempore culpa atque obcaecati.
            Aperiam, ad vero!</p>
    </div>
    <script src="scripts/calendar.js"></script>
</body>

</html>
