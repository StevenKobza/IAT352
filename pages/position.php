<!DOCTYPE html>

<?php
session_start();

if (!isset($_SESSION["started"])) {
    $_SESSION["started"] = "true";
}

// database connection
include("../phpData/dbconnect.php");

$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// test if connection succeeded 
if (mysqli_connect_errno()) {
    // if connection failed, skip the rest of the code and print an error 
    die("Database connection failed: " .
        mysqli_connect_error() .
        " (" . mysqli_connect_errno() . ")");
}

?>


<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <title>FIFA 21 — Position</title>
</head>

<body>

    <header class="header">
        <nav>
            <a href="../index.php"><img src="../img/logo.png" alt="FIFA 21 logo" class="logo"></a>
            <input class="menu-btn" type="checkbox" id="menu-btn" />
            <label class="menu-icon" for="menu-btn"><span class="navicon"></span></label>
            <ul class="menu">
                <li><a href="./players.php">Players</a></li>
                <li><a href="./clubs.php">Clubs</a></li>
                <li><a href="./leagues.php">Leagues</a></li>
                <li><a href="./position.php">Position</a></li>
                <?php
                // display username on navbar if user is logged in
                if (isset($_SESSION["username"])) {
                    echo '<li> <a href = "../pages/userdetail.php" id="user">' . $_SESSION["username"] . '</a></li>';
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
        <h1 class="landing-header">Position</h1>
    </div>


    <main>

        <div class="position-icons-container">
            <div class="forward-icon">Forward</div>
            <div class="midfield-icon">Midfield</div>
            <div class="defence-icon">Defence</div>
        </div>



        <?php

        // checking colour as well as the distinct positions
        $defencePositions = array("LB", "CB", "RB", "LWB", "RWB");
        $midfieldPositions = array("CM", "CAM", "CDM", "LM", "RM");
        $forwardPositions = array("ST", "RW", "LW", "CF", "RF", "LF");

        $positionResult = mysqli_query($connection, "SELECT DISTINCT position FROM player");
        echo '<div class="position-container">';
        while ($rows = $positionResult->fetch_assoc()) {
            $position = trim($rows['position'], " ");       // removing extra space before position name
            echo '<a href = "../pages/positiondetail.php?id=' . $position . '">';
            echo '<div class="position-box"';

            if (in_array($position, $defencePositions)) {          // check if poisiton is defence
                echo ' id="defence" >';
            } else if (in_array($position, $midfieldPositions)) {     // check if position is midfield
                echo ' id="midfield" >';
            } else {                                                  // position is forward
                echo ' id="forward" >';
            }
            echo $position . '</div></a>';
        }
        echo '</div>';
        ?>







    </main>





</body>

</html>