<?php
 // Include config file
 require_once "utils/dbmanager.php";
 require_once "utils/ValidateInput.php";

// Initialize the session
session_start();
 
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
    $relationship       = ValidateInput::work($_POST["relationship"]);
    
    $meal_arr = array("", "", "", "");

    $petname_err = $breed_err = $meals_err = $restrictions_err = $medical_history_err = $relationship_err = "";

    // Validate pet name
    if (empty($petname)) {
        $petname_err = "Pet name is required <br>";
    } else if (strlen($petname) > 20 || preg_match('/[^A-Za-z]/i', $petname)) {
        $petname_err = "Invalid pet name! <br>";
    }

    // Validate breed
    if (empty($breed)) {
        $breed_arr = "Breed is required <br>";
    } else if (!in_array($breed, $breed_arr)) {
        $breed_err = "Invalid breed <br>";
    }

    // Validate number of meals & their values
    if (empty($meals) || $meals < 0 || $meals > 4) {
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
    <hr>
    <div class="main-content">
        <form class="hazi-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <p class="default-title">Add new pet</p>
            <div class="hazi-center-left-align">
                <label for="petname">Pet name: <i>(required)</i></label>
                <input type="text" id="petname" name="petname" required>
            </div>
            <div class="hazi-center-left-align">
                <label for="breed">Select breed: <i>(required)</i></label>
                <select name="breed" class="hazi-select" required>
                    <option value="dog">Dog</option>
                    <option value="cat">Cat</option>
                    <option value="chicken">Chicken</option>
                </select>
            </div>
            <div>
                <label for="meals">Meals per day: <i>(optional)</i></label>
                <input type="number" name="meals" id="meals" min="0" max="4" onclick="addFields()" value="0">
            </div>
            <div id="hazi-dynamic-fields">
            </div>
            <div class="hazi-center-left-align">
                <label for="restrictions">Restrictions: <i>(optional)</i></label>
                <textarea class="hazi-input-width" name="restrictions" id="restrictions" rows="5"></textarea>
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
