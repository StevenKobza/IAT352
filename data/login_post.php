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
    <?php

        include("../phpData/dbconnect.php");
        $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
        if ($mysqli->connect_errno) {
            echo "Failed to connect to MySQL: " . $mysqli->connect_error; 
        }

        $result = $mysqli->query("SELECT * FROM user");
        if ($result->num_rows > 0) {
            $temp = false;
            while ($row = $result->fetch_assoc()) {
                if (password_verify($_POST["password"], $row["password"]) && $_POST["username"] == $row["username"]) {
                    if(isset($_POST["username"])) {
                    $_SESSION["username"] = $_POST["username"];
                    $temp = true;
                    break;
                    }
                }
            }
            if ($temp == false) {
                $_SESSION["wrongPW"] = True;
            }
        }

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
                        echo '<li> <a href = "#" id="user">' . $_SESSION["username"] . '</a></li>';
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
            <h1 class="landing-header">Log In</h1>
        </div>


        <main>
            <?php
            if (isset($_SESSION["wrongPW"])) {
                echo "Your password or username is incorrect";
                unset($_SESSION["wrongPW"]);
            }
            ?>
            
        



        </main>





    </body>

</html>