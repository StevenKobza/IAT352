<!DOCTYPE html>

<?php
session_start();

if (!isset($_SESSION["started"])) {
    $_SESSION["started"] = "true";
}

// get player's name from the URL
if (strpos($_SERVER['REQUEST_URI'], "id")) {
    $clubId = str_replace($_SERVER["SCRIPT_NAME"] . "?id=", "", $_SERVER['REQUEST_URI']);
    $clubId = urldecode($clubId);
    $_SESSION["clubId"] = $clubId;
} else if (strpos($_SERVER['REQUEST_URI'], "page")) {
    $clubId = $_SESSION["clubId"];
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


// queries
$sql_basic = "SELECT club.clubname, player.playerName FROM club 
INNER JOIN player ON player.playerid = club.playerid WHERE club.clubid = $clubId";
if ($query_basic = $connection->query($sql_basic)) {
} else {
    echo $connection->errno;
    echo $connection->error;
}
$row_basic = mysqli_fetch_assoc($query_basic);
$club =  $row_basic['clubname'];
$playerName = $row_basic['playerName'];
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <title>FIFA 21 — Club Detail</title>
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
        <h1 class="landing-header">Club</h1>
    </div>


    <main>

        <div>
            <div class="profile">
                <div class="general-info">
                    <h2><?php echo $club; ?></h2>
                </div>
            </div>

            <h2>Players</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">NAME</th>
                        <th scope="col">CARD RATING</th>
                        <th scope="col">POSITION</th>
                        <th scope="col">CLUB</th>
                        <th scope="col">WORK RATE</th>
                        <th scope="col">STRONG FOOT</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query2 = "SELECT club.clubname FROM club WHERE club.clubid = $clubId";
                    $result2 = $connection->query($query2);
                    $row = $result2->fetch_assoc();
                    $clubName = $row["clubname"];

                    $query = "SELECT player.playerid, player.playerName, player.cardRating, player.position, club.clubname, player.workRates, player.strongFoot 
                        FROM club
                        INNER JOIN player ON player.playerid = club.playerid
                        WHERE club.clubid = $clubId OR club.clubname = '$clubName'";

                    // learned from: https://www.youtube.com/watch?v=gdEpUPMh63s
                    // pagination

                    $results_per_page = 10;

                    // find the number of results stored in database
                    if ($result = $connection->query($query)) {
                    } else {
                        echo $connection->errno;
                        echo $connection->error;
                    }

                    $number_of_results = mysqli_num_rows($result);

                    // determine number of total pages available
                    $number_of_pages = ceil($number_of_results / $results_per_page);

                    // determine which page number visitor is currently on
                    if (!isset($_GET['page'])) {
                        $page = 1;
                    } else {
                        $page = $_GET['page'];
                    }

                    // determine the sql LIMIT starting number for the results on the displaying page
                    $this_page_first_result = ($page - 1) * $results_per_page;

                    $query .= " LIMIT " . $this_page_first_result . ',' . $results_per_page;
                    $result = $connection->query($query);


                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo '<th scope = "row"><img src = "../img/datasetHeads/' . $row["playerid"] . '.jpg" alt = ""></th>';

                            // learned about passing link data to url from here: https://stackoverflow.com/questions/21890086/store-data-of-link-clicked-using-php-and-transferring-it-to-new-page
                            echo "<td> <a href='../pages/player.php?id=" . $row['playerid'] . "'>" . $row['playerName'] . "</a></td>";
                            echo '<td>' . $row["cardRating"] . "</td>";
                            echo "<td>" . $row["position"] . "</td>";
                            echo "<td>" . $row["clubname"] . "</td>";
                            echo "<td>" . $row["workRates"] . "</td>";
                            echo "<td>" . $row["strongFoot"] . "</td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
            <?php

            // learned from: https://stackoverflow.com/questions/28716904/limit-pages-numbers-on-php-pagination
            // limit the number of pages on pagination
            $link = "";
            $limit = 5;

            if ($number_of_pages >= 1 && $page <= $number_of_pages) {
                $counter = 1;
                $link = "";
                if ($page > 1)         // show 1 if on page 2 and after
                {
                    $link .= "<a class='pagination' href=\"?page=1\">1 </a> ... ";
                }
                for ($x = $page; $x <= $number_of_pages; $x++) {
                    if ($counter < $limit)
                        $link .= "<a class='pagination' href=\"?page=" . $x . "\">" . $x . " </a>";

                    $counter++;
                }
                if ($page < $number_of_pages - ($limit / 2)) {
                    $link .= "... " . "<a class='pagination' href=\"?page=" . $number_of_pages . "\">" . $number_of_pages . " </a>";
                }
            }

            echo $link;
            ?>







    </main>





</body>

</html>