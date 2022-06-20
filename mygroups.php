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
    <?php include "shared/header.php" ?>


    <div class="main-content">
        <div class="panel">
            <h3 class="subtitle">Groups</h3>
            <p class="details">Here are all of your groups.</p>
            <p class="details">You can create new groups or delete the ones created by you.</p>
            <p class="details">You can join groups created by others using the key of the group.</p>
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

    <?php include "shared/footer.php" ?>

</body>

</html>