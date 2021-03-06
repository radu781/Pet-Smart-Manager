<?php
include_once 'utils/dbmanager.php';
include_once 'utils/ValidateInput.php';
require_once "utils/configuration.php";
 
// Check if the user is already logged in, if yes then redirect him to homepage
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: homepage.php");
    exit;
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $email      = ValidateInput::work($_POST["email"]);
    $password   = ValidateInput::work($_POST["password"]);
    $fname      = ValidateInput::work($_POST["fname"]);
    $mname      = ValidateInput::work($_POST["mname"]);
    $lname      = ValidateInput::work($_POST["lname"]);
    $emailErr = $passwordErr = $fnameErr = $mnameErr = $lnameErr = $successMsg =  "";

    // Validate email
    if (empty($email)) {
        $emailErr = "Email is required! <br>";
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format! <br>";
        }
    }

    // If there is already an account with this email address there is no reason in checking something else
    if (DBManager::getInstance()->checkExistingUser($email)) {
        $emailErr = 'An account with this email address already exists! <br>';
    } else {

        // Validate password
        if (empty($password)) {
            $passwordErr = "Password is required";
        } else {
            if (strlen($password) <= 8) {
                $passwordErr = "Your Password Must Contain At Least 8 Characters! <br>";
            } else if (strlen($password) >= 64) {
                $passwordErr .= "Your Password Must Contain At Most 64 Characters! <br>";
            }

            if(!preg_match("#[0-9]+#", $password)) {
                $passwordErr .= "Your Password Must Contain At Least 1 Number! <br>";
            }
            if(!preg_match("#[A-Z]+#", $password)) {
                $passwordErr .= "Your Password Must Contain At Least 1 Capital Letter! <br>";
            }
            if(!preg_match("#[a-z]+#", $password)) {
                $passwordErr .= "Your Password Must Contain At Least 1 Lowercase Letter! <br>";
            }
        }


        // Validate first name
        if (empty($fname)) {
            $fnameErr = "First name is required! <br>";
        } else {
            if (!preg_match("/^[a-zA-Z'-]+$/", $fname)) {
                $fnameErr = "Invalid first name format! <br>";
            }
            if (strlen($fname) < 2 || strlen($fname) > 64) {
                $fnameErr .= "First name must have between 2-64 characters!";
            }
        }

        // Validate middle name
        if (!empty($mname)) {
            if (!preg_match("/^[a-zA-Z'-]+$/", $mname)) {
                $mnameErr = "Invalid middle name format! <br>";
            }
            if (strlen($mname) < 2 || strlen($mname) > 64) {
                $mnameErr .= "Middle name must have between 2-64 characters!";
            }
        }

        // Validate last name
        if (empty($lname)) {
            $lnameErr = "Last name is required!";
        } else {
            if (!preg_match("/^[a-zA-Z'-]+$/", $lname)) {
                $lnameErr = "Invalid last name format! <br>";
            }
            if (strlen($lname) < 2 || strlen($lname) > 64) {
                $lnameErr .= "Last name must have between 2-64 characters!";
            }
        }

        if (empty($emailErr) && empty($passwordErr) && empty($fnameErr) && empty($mnameErr) && empty($lnameErr)) {
            DBManager::getInstance()->registerUser($email, $password, $fname, $mname, $lname);
            $successMsg = "Your account has been created! <br>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en"><head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="styles/global.css">
    <link rel="stylesheet" href="styles/hazi.css">
</head>
<body>
    <?php include "shared/header-for-guests.php" ?>

    <hr>
    <div class="main-content">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="hazi-form" method="POST">
            <p class="default-title">Register</p>
            <?php
            if (!empty($emailErr) || !empty($passwordErr) || !empty($fnameErr) || !empty($mnameErr) || !empty($lnameErr) || !empty($successMsg)) {
                echo "<p class=\"hazi-alert-paragraph\">";

                if (!empty($emailErr)) {
                    echo $emailErr;
                 }
                 if (!empty($passwordErr)) {
                     echo $passwordErr;
                 }
                 if (!empty($fnameErr)) {
                     echo $fnameErr;
                 }
                 if (!empty($mnameErr)) {
                     echo $mnameErr;
                 }
                 if (!empty($lnameErr)) {
                     echo $lnameErr;
                 }
                 if (!empty($successMsg)) {
                     echo $successMsg;
                 }

                echo "</p>";
            }
            ?>
            <div class="hazi-form-row">
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" value="<?php if (empty($emailErr) && isset($_POST["email"])) echo $_POST["email"];  ?>" onkeyup="showUsernameHint(this.value)" required>
                <p class="ajax-feedback"><span id="usernameValidation"></span></p>
            </div>
            <div class="hazi-form-row">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" onkeyup="showPasswordHint(this.value)" required>
                <p class="ajax-feedback"><span id="passwordValidation"></span></p>
            </div>
            <div class="hazi-form-row">
                <label for="fname">First name:</label>
                <input type="text" id="fname" name="fname" minlength="2" maxlength="64" value="<?php if (empty($fnameErr) && isset($_POST["fname"])) echo $_POST["fname"];  ?>" required>
            </div>
            <div class="hazi-form-row">
                <label for="mname">Middle name:</label>
                <input type="text" id="mname" name="mname" minlength="2" maxlength="64" value="<?php if (empty($mnameErr) && isset($_POST["mname"])) echo $_POST["mname"];  ?>">
            </div>
            <div class="hazi-form-row">
                <label for="lname">Last name:</label>
                <input type="text" id="lname" name="lname" minlength="2" maxlength="64" value="<?php if (empty($lnameErr) && isset($_POST["lname"])) echo $_POST["lname"];  ?>" required>
            </div>
            <input class="default-button" type="submit" value="Register now!">
            <p class="hazi-login-register-text">Already have an account? <a href="login.php">Go to Login</a>.</p>
        </form>
    </div>
    <?php include "shared/footer.php" ?>
</body>
</html>