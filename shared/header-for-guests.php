<header>
    <div class="site_logo">
        <img src="resources/icon.png" alt="Logo">
    </div>
    <div class="site_name"><a class="site_name" href="homepage.php"><strong>Petbook</strong></a></div>
    <ul class="header_options">
        <div class="display_mode">Light/Dark mode</div>
    </ul>
    <script>
        function showUsernameHint(str) {
            if (str.length == 0) {
                document.getElementById("usernameValidation").innerHTML = "";
                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("usernameValidation").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "ajax/validateEmail.php?q=" + str, true);
                xmlhttp.send();
            }
        }
        function showPasswordHint(str) {
            if (str.length == 0) {
                document.getElementById("passwordValidation").innerHTML = "";
                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("passwordValidation").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "ajax/validatePassword.php?q=" + str, true);
                xmlhttp.send();
            }
        }
    </script>
</header>
<nav>
    <ul class="menu">
        <li class="normal option_my_profile"><a class="link_for_menu " href="index.php">Home</a></li>
        <li class="normal option_my_pets"><a class="link_for_menu " href="login.php">Login</a></li>
        <li class="normal option_my_groups"><a class="link_for_menu " href="register.php">Register</a></li>

        <!-- responsive design -->
        <li class="phone option_my_profile">
            <a class="link_for_menu" href="index.php">
                <img src="resources/home.png" alt="home">
            </a>
        </li>
        <li class="phone option_my_pets">
            <a class="link_for_menu " href="login.php">
                <img src="resources/login.png" alt="login">
            </a>
        </li>
        <li class="phone option_my_groups">
            <a class="link_for_menu " href="register.php">
                <img src="resources/register.png" alt="register">
            </a>
        </li>
    </ul>
</nav>