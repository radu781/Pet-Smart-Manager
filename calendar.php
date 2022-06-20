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
    <?php include "shared/header.php" ?>
    <hr>
    <div class="main-content">
        <p class="default-title">Calendar</p>
        <div class="center">
            <?php
            set_include_path("utils");
            include "dbmanager.php";
            if (!session_id()) {
                session_start();
            }
            $result = DBManager::getInstance()->getFeedingTime($_SESSION["id"]);
            if (sizeof($result) > 0) {
            ?>
                <div id="calendar">
                    <div id="header">
                        <div id="prev-month-button" class="clickable">&lt;&lt;&lt;</div>
                        <div id="header-date" class="clickable">Today</div>
                        <div id="next-month-button" class="clickable">&gt;&gt;&gt;</div>
                    </div>
                    <div id="days"></div>
                    <div id="calendar-body">
                    <?php
                    $backgroundColors = ["#025DF5", "#03A3FF", "#0ED2E8", "#03FFD3", "#02F586"];
                    for ($i = 0; $i < 6; $i++) {
                        echo '<div class="row">';
                        for ($j = 0; $j < 7; $j++) {
                            echo '<div class="cell" style="background: var(--yellow)">';
                            echo '<div class="calendar-day">' . "1" . '</div>';
                            foreach ($result as $pet) {
                                $color = $backgroundColors[(int)sha1($pet["name"]) % sizeof($backgroundColors)];
                                $currentId = random_int(0, 1000000) . "-" . $pet["id"] . "-" . $pet["pet_id"];
                                echo "<div class=\"feed\" style=\"background-color:$color\" onclick=\"onFeedCellClicked('$currentId')\" id=\"$currentId\">";
                                echo substr($pet["feed_time"], 0, 5) . "-" . $pet["name"];
                                echo '</div>';
                            }
                            echo '</div>';
                        }
                        echo "</div>";
                    }
                } else {
                echo '<div>Add a pet to use the feeding calendar</div>';}
                    ?></div>
                </div>
        </div>
        <?php if (sizeof($result) > 0) { ?>

            <form class="hazi-form">
                <fieldset>
                    <legend>Filter by pets</legend>
                    <?php
                    $prevPet = $result[0];
                    echo '<input type="checkbox" onclick="onPetFilterChanged()" name="pet-filter" value="' . $prevPet["name"] . '" id="' . $prevPet["id"] . "-" . $prevPet["pet_id"]  . '" checked>' . '</input>';
                    echo '<label class="pet-name" for="' . $prevPet["id"] . "-" . $prevPet["pet_id"] . '">' . $prevPet["name"] . '</label>';

                    for ($i = 1; $i < sizeof($result); $i++) {
                        $currentPet = $result[$i];
                        if ($prevPet["name"] !== $currentPet["name"]) {
                            echo '<input type="checkbox" onclick="onPetFilterChanged()" name="pet-filter" value="' . $currentPet["name"] . '" id="' . $prevPet["id"] . "-" . $currentPet["pet_id"] . '" checked>' . '</input>';
                            echo '<label class="pet-name" for="' . $prevPet["id"] . "-" . $currentPet["pet_id"] . '">' . $currentPet["name"] . '</label>';
                        }
                        $prevPet = $currentPet;
                    }
                    ?>
                </fieldset>
            <?php } ?>
            </form>
            <?php
            foreach ($_POST as $item => $e) {
                if (strpos($item, "update") !== false) {
                    $item = explode("-", $item);
                    DBManager::getInstance()->updateFeedingTime($item[1], $item[2], $e);
                    unset($item);
                    echo '<script>window.location="calendar.php"</script>';
                    break;
                }
            }
            ?>

            <?php if (sizeof($result) > 0) { ?>
                <table id="feed-values">
                    <tr>
                        <th>id</th>
                        <th>pet_id</th>
                        <th>feed_time</th>
                    </tr>
                    <?php
                    $show = true;
                    foreach ($result as $line) {
                        echo "<tr>";
                        foreach ($line as $column) {
                            if ($show) {
                                echo '<td class="feed-time-cell">';
                                echo $column;
                            }
                            echo '</td>';
                            $show = !$show;
                        }
                        echo '</tr>';
                    }
                    ?>
                </table>
            <?php } ?>
    </div>
    <script src="scripts/calendar.js"></script>
    <?php include "shared/footer.php" ?>
</body>

</html>
