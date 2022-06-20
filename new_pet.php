<?php
 // Include config file
 require_once "utils/dbmanager.php";
 require_once "utils/ValidateInput.php";
 require_once "utils/configuration.php";
 
// Check if the user is not logged in, if yes then redirect him to login
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false) {
    header("location: login.php");
    exit;
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $breed_arr = array("cat", "dog", "chicken");

    $petname            = ValidateInput::work($_POST["petname"]);
    $breed              = ValidateInput::work($_POST["breed"]);
    $meals              = ValidateInput::work($_POST["meals"]);
    $restrictions       = ValidateInput::work($_POST["restrictions"]);
    $medical_history    = ValidateInput::work($_POST["medical-history"]);
    $relationships      = ValidateInput::work($_POST["relationships"]);
    
    $meal_arr = array("", "", "", "");

    $petname_err = $breed_err = $meals_err = $restrictions_err = $medical_history_err = $relationships_err = $successMsg = "";

    // Validate pet name
    if (empty($petname)) {
        $petname_err = "Pet name is required <br>";
    } else if (strlen($petname) > 32 || preg_match('/[^A-Za-z0-9]/i', $petname)) {
        $petname_err = "Invalid pet name <br>";
    }

    // Validate breed
    if (empty($breed)) {
        $breed_err = "Breed is required <br>";
    } else if (strlen($breed) > 32 || preg_match('/[^A-Za-z]/i', $breed)) {
        $breed_err = "Invalid breed name <br>";
    }

    // Validate number of meals & their values
    if ($meals < 0 || $meals > 4) {
        $meals_err = "The number of daily meals is invalid <br>";
    } else {
        for ($i = 0; $i < $meals; $i++) {
            $meal_arr[$i] = ValidateInput::work($_POST["meal" . ($i+1)]);

            if ($meal_arr[$i] == "") {
                $meal_arr = "Meal time cannot be empty <br>";
            } else if (!preg_match('/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/', $meal_arr[$i])) {
                $meals_err = "Meal time is incorrect <br>";
            }
        }
    }

    // Validate restrictions
    if (strlen($restrictions) > 255) {
        $restrictions_err = "Error! Restrictions description cannot exceed 255 characters <br>";
    }

    // Validate medical history
    if (strlen($medical_history) > 255) {
        $medical_history_err = "Error! Medical history description cannot exceed 255 characters <br>";
    }

    // Validate relationships
    if (strlen($relationships) > 255) {
        $relationship_err = "Error! Restrictions description cannot exceed 255 characters <br>";
    }

    if (empty($petname_err) && empty($breed_err) && empty($meals_err) && empty($restrictions_err) && empty($medical_history_err) && empty($relationships_err) && empty($successMsg)) {
        DBManager::getInstance()->addPet($_SESSION["id"], $petname, $breed, $meal_arr, $restrictions, $medical_history, $relationships);
        $successMsg = "Pet has been succesfully added <br>";
    }
}

?>

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
    <?php include "shared/header.php" ?>

    <hr>
    <div class="main-content">
        <form class="hazi-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <p class="default-title">Add new pet</p>
            <?php
            if (!empty($petname_err) || !empty($breed_err) || !empty($meals_err) || !empty($restrictions_err) || !empty($medical_history_err) || !empty($relationships_err) || !empty($successMsg)) {
                echo "<p class=\"hazi-alert-paragraph\">";

                if (!empty($petname_err)) {
                    echo $petname_err;
                 }
                 if (!empty($breed_err)) {
                     echo $breed_err;
                 }
                 if (!empty($meals_err)) {
                     echo $meals_err;
                 }
                 if (!empty($restrictions_err)) {
                     echo $restrictions_err;
                 }
                 if (!empty($medical_history_err)) {
                     echo $medical_history_err;
                 }
                 if (!empty($relationships_err)) {
                     echo $relationships_err;
                 }
                 if (!empty($successMsg)) {
                     echo $successMsg;
                 }

                echo "</p>";
            }
            ?>
            <div class="hazi-center-left-align">
                <label for="petname">Pet name: <i>(required)</i></label>
                <input type="text" id="petname" name="petname" minlength="2" maxlength="32" required>
            </div>
            <div class="hazi-center-left-align">
                <label for="breed">Breed: <i>(required)</i></label>
                <input type="text" id="breed" name="breed" minlength="2" maxlength="32" required>
            </div>
            <div>
                <label for="meals">Meals per day: <i>(optional)</i></label>
                <input type="number" name="meals" id="meals" min="0" max="4" onclick="addFields()" value="0">
            </div>
            <div id="hazi-dynamic-fields">
            </div>
            <div class="hazi-center-left-align">
                <label for="restrictions">Restrictions: <i>(optional)</i></label>
                <textarea class="hazi-input-width" name="restrictions" id="restrictions" rows="5" maxlength="255"></textarea>
            </div>
            <div class="hazi-center-left-align">
                <label for="medical-history">Medical history: <i>(optional)</i></label>
                <textarea class="hazi-input-width" name="medical-history" id="medical-history" rows="5" maxlength="255"></textarea>
            </div>
            <div class="hazi-center-left-align">
                <label for="relationships">Relationships: <i>(optional)</i></label>
                <textarea class="hazi-input-width" name="relationships" id="relationships" rows="3" maxlength="255"></textarea>
            </div>
            <input class="default-button" type="submit" value="Register now!">
        </form>
    </div>
    <?php include "shared/footer.php" ?>
</body>

</html>
