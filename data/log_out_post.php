<!DOCTYPE html>
<?php 

session_start();

if (!isset($_SESSION["started"])) {
    $_SESSION["started"] = "true";
}
?>

<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../css/main.css">
        <title>FIFA 21 — Log Out</title>
    </head>

    <body>
    <?php
    //Just unsets the username
        unset($_SESSION["username"]);
    ?>
        <header class="header">
            <nav>
                <a href="../index.php"><img src="../img/logo.png" alt="FIFA 21 logo" class="logo"></a>
                <input class="menu-btn" type="checkbox" id="menu-btn" />
                <label class="menu-icon" for="menu-btn"><span class="navicon"></span></label>
                <ul class="menu">
                    <li><a href="../pages/players.php">Players</a></li>
                    <li><a href="../pages/clubs.php">Clubs</a></li>
                    <li><a href="../pages/leagues.php">Leagues</a></li>
                    <li><a href="../pages/position.php">Position</a></li>
                    <?php
                    if (isset($_SESSION["username"])) {
                        echo '<li> <a href = "#">' . $_SESSION["username"] . '</a></li>';
                        echo '<li> <a href = "../data/log_out_post.php">Log Out</a></li>';
                    } else {
                        echo '<li><a href="../pages/login.php">Login</a></li>';
                        echo '<li><a href="../pages/sign-up.php">Sign up</a></li>';

                    }
                ?>
                </ul>
            </nav>
        </header>

        <div class="main-banner">
            <h1 class="landing-header">Logged Out</h1>
        </div>


        <main>

            




        </main>





    </body>

</html>