<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="styles/global.css" rel="stylesheet">
    <link href="styles/index.css" rel="stylesheet">
    <link rel="icon" href="../resources/icon.png" type="image/x-icon">
    <title>Petbook</title>
</head>

<body>
    <header>
        <div class="site_logo">
            <img src="resources/icon.png" alt="Logo">
        </div>
        <div class="site_name"><strong>Petbook</strong></div>
        <div class="options">
            <a class="page_link" href="register.php">
                <p class="option register">Register</p>
            </a>
            <a class="page_link" href="login.php">
                <p class="option login">Log in</p>
            </a>
        </div>
    </header>
    <main>
        <section class="intro">
            <div class="span-2-col text">
                <h3 class="subtitle">
                    What is Petbook?
                </h3>
                <p class="description">
                    Petbook is a free website which lets you introduce your pets to the online world. From a feeding
                    calendar to the possibility of sharing photos with them, Petbook is the solution no matter what.
                </p>
            </div>
            <div class="small image">
                <img class="intro" src="resources/landing_page_images/introdraw1.svg" height=400px width=400px></img>
            </div>
        </section>
        <section class="intro">
            <div class="small image">
                <img class="intro" src="resources/landing_page_images/introdraw2.svg" height=400px></img>
            </div>
            <div class="right text">
                <h3 class="subtitle">
                    Start the journey
                </h3>
                <p class="description">We think that no more words are needed, so
                    we let you to convince yourself. Start the journey by <a class="page_link bottom" href="register.php"><i>clicking
                            here</i></a>.
                </p>
            </div>
        </section>
    </main>
    <?php
    include "shared/footer.php"
    ?>
</body>