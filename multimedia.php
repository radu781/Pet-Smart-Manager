<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/multimedia.css">
    <link rel="stylesheet" href="styles/global.css">
    <link rel="stylesheet" href="styles/hazi.css">
    <link rel="icon" href="../resources/icon.png" type="image/x-icon">
    <title>Multimedia</title>
</head>

<body>
    <?php include "shared/header.php" ?>
    <hr>
    <?php
    include 'utils/dbmanager.php';
    include "utils/ValidateInput.php";
    if (!session_id()) {
        session_start();
    }
    $media = DBManager::getInstance()->getPetMedia($_SESSION["id"]);
    ?>
    <div class="main-content">
        <p class="default-title">Multimedia resources</p>
        <div class="main">
            <?php
            if (sizeof($media) > 0) {
                $prevMedia = $media[0];
                echo '<div class="cell-group">';
                for ($i = 0; $i < sizeof($media); $i++) {
                    $currentMedia = $media[$i];

                    if ($prevMedia["pet_id"] !== $currentMedia["pet_id"]) {
                        echo '</div>';
                        echo '<div class="cell-group">';
                    }

                    echo '<div class="cell">';
                    echo '<p>' . $currentMedia["name"] . '</p>';
                    echo '<img class="pet_photo" src="multimedia/' . $currentMedia["pet_id"] . "/" . $currentMedia["filename"] . '" width="200" height="200" alt="user provided image">';
                    echo '<p>' . $currentMedia["description"] . '</p>';
                    echo '<a href="petdetails.php?id=' . $media[$i]["pet_id"] . '"><button class="default-button">Details</button></a>';
                    echo '</div>';

                    $prevMedia = $currentMedia;
                }
            }
            ?>
        </div>
        <div id="form-div">
            <form method="POST">
                <label for="upload-new">Upload a new photo for your pet!</label>
                <input type="image" id="upload-new" src="resources/add_icon.png" alt="Add new photo" name="add" onclick="window.location='multimedia.php#form'">
            </form>
            <?php
            if (isset($_POST["add_x"])) {
                unset($_POST["add_x"]);
                unset($_POST["add_y"]);
                $media = DBManager::getInstance()->getPets($_SESSION["id"]);
            ?>
                <form method="POST" class="inline-form" enctype="multipart/form-data" id="form">
                    <label for="pet-id">Choose pet:</label>
                    <select name="pet-id" id="pet-id">
                        <?php
                        $prevMedia = $media[0];
                        echo '<option value="' . $prevMedia["pet_id"] . '">' . $prevMedia["name"] . '</option>';
    
                        for ($i = 1; $i < sizeof($media); $i++) {
                            $currentMedia = $media[$i];
                            if ($prevMedia["name"] != $currentMedia["name"]) {
                                echo '<option value="' . $currentMedia["pet_id"] . '">' . $currentMedia["name"] . '</option>';
                            }
                            $prevMedia = $currentMedia;
                        }
                        ?>
                    </select>
                    <label for="file">Choose a file to upload:</label>
                    <input type="file" name="file" id="file" accept="image/*" required>
                    <label for="post-description">Add a description:</label>
                    <textarea name="post-description" id="post-description"></textarea>
                    <input type="submit" value="Create">
                </form>
                <form action="multimedia.php#form-div" method="post">
                    <input type="submit" value="Cancel" name="cancel">
                </form>
            <?php
            }
            if (isset($_POST["cancel"])) {
                unset($_POST["add_x"]);
                unset($_POST["add_y"]);
                unset($_POST["cancel"]);
            }
            if (isset($_FILES["file"])) {
                $pedId = $_POST["pet-id"];
                $description = ValidateInput::work($_POST["post-description"]);
                $filename = str_replace(" ", "_", $_FILES["file"]["name"]);
                $tempName = str_replace(" ", "_", $_FILES["file"]["tmp_name"]);
                @mkdir("multimedia/" . $_POST["pet-id"]);
                move_uploaded_file($tempName, "multimedia/" . $_POST["pet-id"] . "/" . $filename);
                DBManager::getInstance()->insertPetMedia($pedId, $filename, $description);
                echo '<script>window.location="multimedia.php"</script>';
            }
            ?>
        </div>
    </div>
    </div>
    <script src="scripts/multimedia.js"></script>
    <?php include "shared/footer.php" ?>
</body>

</html>
