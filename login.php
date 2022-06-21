<?php
// Include config file
require_once "utils/dbmanager.php";
require_once "utils/ValidateInput.php";
require_once "utils/configuration.php";
 
// Check if the user is already logged in, if yes then redirect him to homepage
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: homepage.php");
    exit;
}

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
 
    $username = ValidateInput::work($_POST["username"]);
    $password = ValidateInput::work($_POST["password"]);
    $username_err = $password_err = $login_err = "";
    $id = 0;
 
    // Check if username is empty
    if (empty($username)) {
        $username_err = "Please enter username.";
    } else {
        if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
            $username_err = "Invalid username format! <br>";
        }
    }
    
    // Check if password is empty
    if (empty($password)) {
        $password_err = "Please enter your password.";
    }

    if (empty($username_err) && empty($password_err)) {
        $login_result = DBManager::getInstance()->checkCredentials($username, $password);

        // Successfully logged in
        if ($login_result['id'] > 0) {
            // Password is correct, so start a new session
            session_start();
                            
            // Store data in session variables
            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $login_result['id'];                
                            
            // Redirect user to homepage
            header("location: homepage.php");
        } else {
            // Password is not valid, display a generic error message
            $login_err = "Invalid username or password.";
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
    <title>Login</title>
</head>

<body>
    <?php include "shared/header-for-guests.php" ?>
    <hr>
    <div class="main-content">
        <p class="default-title">Login</p>
        <?php
            if (!empty($username_err) || !empty($password_err) || !empty($login_err)) {
                echo "<p class=\"hazi-alert-paragraph\">";

                if (!empty($username_err)) {
                    echo $username_err;
                }

                if (!empty($password_err)) {
                    echo $password_err;
                }

                if (!empty($login_err)) {
                    echo $login_err;
                }

                echo "</p>";
            }
            ?>
        <form class="hazi-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div>
                <label for="username">Username:</label>
                <input type="email" name="username" id="username" onkeyup="showUsernameHint(this.value)" required>
                <p class="ajax-feedback"><span id="usernameValidation"></span></p>
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>
            <input class="default-button" type="submit" value="Login now!">
            <p class="hazi-login-register-text">Don't have an account? <a href="register.php">Go to Register</a>.</p>
        </form>
    </div>
    <?php include "shared/footer.php" ?>
</body>

</html>
