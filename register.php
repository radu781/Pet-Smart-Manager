<?php
include_once 'utils/dbmanager.php';
include_once 'utils/ValidateInput.php';

// Initialize the session
session_start();
 
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
            if (strlen($_POST["password"]) <= 8) {
                $passwordErr = "Your Password Must Contain At Least 8 Characters! <br>";
            }
            elseif(!preg_match("#[0-9]+#", $password)) {
                $passwordErr = "Your Password Must Contain At Least 1 Number! <br>";
            }
            elseif(!preg_match("#[A-Z]+#", $password)) {
                $passwordErr = "Your Password Must Contain At Least 1 Capital Letter! <br>";
            }
            elseif(!preg_match("#[a-z]+#", $password)) {
                $passwordErr = "Your Password Must Contain At Least 1 Lowercase Letter! <br>";
            }
        }


        // Validate first name
        if (empty($fname)) {
            $fnameErr = "First name is required! <br>";
        } else {
            if (!preg_match("/^[a-zA-Z'-]+$/", $fname)) {
                $fnameErr = "Invalid first name format! <br>";
            }
        }

        // Validate middle name
        if (!empty($mname)) {
            if (!preg_match("/^[a-zA-Z'-]+$/", $mname)) {
                $mnameErr = "Invalid first name format! <br>";
            }
        }

        // Validate last name
        if (empty($lname)) {
            $lnameErr = "Last name is required!";
        } else {
            if (!preg_match("/^[a-zA-Z'-]+$/", $lname)) {
                $lnameErr = "Invalid last name format! <br>";
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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="styles/global.css">
    <link rel="stylesheet" href="styles/hazi.css">
</head>

<body>
    <header>
        <div class="site_logo">
            <img src="resources/icon.png" alt="Logo">
        </div>
        <div class="site_name"><a class="site_name" href="homepage.html"><strong>Petbook</strong></a></div>
        <ul class="header_options">
            <div class="display_mode">Light/Dark mode</div>
            <div class="log_out"><img class="log_out" src="resources/logout.png"></div>
        </ul>
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
            <div>
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" required>
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div>
                <label for="fname">First name:</label>
                <input type="text" id="fname" name="fname" required>
            </div>
            <div>
                <label for="mname">Middle name:</label>
                <input type="text" id="mname" name="mname">
            </div>
            <div>
                <label for="lname">Last name:</label>
                <input type="text" id="lname" name="lname" required>
            </div>
            <input class="default-button" type="submit" value="Register now!">
            <p class="hazi-login-register-text">Already have an account? <a href="login.php">Go to Login</a>.</p>
        </form>
    </div>
</body>

</html>