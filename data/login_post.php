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
        <title>FIFA 21 — Sign Up</title>
    </head>

    <body>

        <header class="header">
            <nav>
                <a href="../index.php"><img src="../img/logo.png" alt="FIFA 21 logo" class="logo"></a>
                <input class="menu-btn" type="checkbox" id="menu-btn" />
                <label class="menu-icon" for="menu-btn"><span class="navicon"></span></label>
                <ul class="menu">
                    <li><a href="../index.php">Players</a></li>
                    <li><a href="../pages/clubs.php">Clubs</a></li>
                    <li><a href="../pages/national-teams.php">National Teams</a></li>
                    <li><a href="../pages/position.php">Position</a></li>
                    <?php
                    if (isset($_SESSION["username"])) {
                        echo '<li> <a href = "#">' . $_SESSION["username"] . '</a></li>';
                    } else {
                        echo '<li><a href="./pages/login.php">Login</a></li>';
                        echo '<li><a href="./pages/sign-up.php">Sign up</a></li>';

                    }
                ?>
                </ul>
            </nav>
        </header>

        <div class="main-banner">
            <h1 class="landing-header">Log In</h1>
        </div>


        <main>

            <?php

            include("../phpData/logins.php");
            $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
            if ($mysqli->connect_errno) {
                echo "Failed to connect to MySQL: " . $mysqli->connect_error; 
            }
            
            $result = $mysqli->query("SELECT * FROM users");
            if ($result->num_rows > 0)

                while ($row = $result->fetch_assoc()) {
                    if ($_POST["password"] = $row["password"]) {
                        echo "logged in";
                        $_SESSION["username"] = $_POST["username"];
                    }
                }


                //$tempUN = $_POST["username"];
                //$tempPW = $_POST["password"];
               
            ?>




        </main>





    </body>

</html>