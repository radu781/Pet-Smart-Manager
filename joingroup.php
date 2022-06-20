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
    <?php include "shared/header.php" ?>

    <hr>
    <div class="main-content">
        <p class="default-title">Join group</p>

        <div class="hazi-center-left-align">
            <label for="name">Group id:</label>
            <input type="text" name="name" id="name" required>
        </div>
        <input class="default-button" type="submit" value="Join group">
    </div>

    <?php include "shared/footer.php" ?>
</body>

</html>