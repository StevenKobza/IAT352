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
    <title>FIFA 21 — Clubs</title>
</head>

<body>

    <header class="header">
        <nav>
            <a href="../index.php"><img src="../img/logo.png" alt="FIFA 21 logo" class="logo"></a>
            <input class="menu-btn" type="checkbox" id="menu-btn" />
            <label class="menu-icon" for="menu-btn"><span class="navicon"></span></label>
            <ul class="menu">
                <li><a href="../index.php">Players</a></li>
                <li><a href="./clubs.php">Clubs</a></li>
                <li><a href="./leagues.php">Leagues</a></li>
                <li><a href="./position.php">Position</a></li>
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
        <h1 class="landing-header">Clubs</h1>
    </div>


    <main>
        <form action = "" class = filterForm method = "post">
            <input type = "text" name = "search">
            <input type = 'submit'>
        </form>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">CLUB</th>
                </tr>
            </thead>
            <tbody>

                <?php

                $query = "SELECT DISTINCT clubname FROM club";

                if (isset($_POST["search"])) {
                    if ($_POST["search"] != "") {
                        $searchQuery = trim($_POST["search"]);
                        $query .= " WHERE clubname LIKE '%$searchQuery%' ";
                    }
                }
                $result = $connection->query($query);
                

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $tempClubName = $row["clubname"];
                        $query2 = "SELECT clubid FROM club WHERE clubname = '$tempClubName' LIMIT 1";
                        $result2 = $connection->query($query2);
                        $row2 = $result2->fetch_assoc();
                        echo "<tr>";
                        echo "<td> <a href='../pages/clubdetail.php?id=" . $row2['clubid'] . "'>" . $row['clubname'] . "</a></td>";
                        //echo "<td>" . $row["clubname"] . "</td>";
                        echo "</tr>";
                    }
                }
                ?>


            </tbody>
        </table>



    </main>





</body>

</html>