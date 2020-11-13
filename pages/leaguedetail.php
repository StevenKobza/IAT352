<!DOCTYPE html>

<?php
session_start();

if (!isset($_SESSION["started"])) {
    $_SESSION["started"] = "true";
}

// get player's name from the URL
$leagueId = str_replace($_SERVER["SCRIPT_NAME"] . "?id=", "", $_SERVER['REQUEST_URI']);
$leagueId = urldecode($leagueId);

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
$sql_basic = "SELECT club.clubname, league.leagueName FROM league 
INNER JOIN club ON club.leagueid = league.leagueid WHERE league.leagueid = $leagueId";
if ($query_basic = $connection->query($sql_basic)) {

} else {
    echo $connection->errno;
    echo $connection->error;
}
//$query_basic = mysqli_query($connection, $sql_basic) or die("Bad Query: $sql_basic");
$row_basic = mysqli_fetch_assoc($query_basic);
$club =  $row_basic['clubname'];
$leagueName = $row_basic['leagueName'];
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <title>FIFA 21 — National Teams</title>
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
        <h1 class="landing-header">League</h1>
    </div>


    <main>

        <div>
            <div class="profile">
                <div class="general-info">
                    <h2><?php echo $leagueName; ?></h2>
                    <!--<p>Club: <?php// echo $club ?></p>-->
                    <?php //echo '<img src = "../img/datasetHeads/'. $playerId . '.jpg" alt = "">'; ?>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">CLUB</th>
                </tr>
            </thead>
            <tbody>

                <?php
                $query = "SELECT DISTINCT club.clubname
                FROM league
                INNER JOIN club ON club.leagueid = league.leagueid
                WHERE league.leagueid = $leagueId OR league.leagueName = '$leagueName'";
                
                if ($result = $connection->query($query)) {

                } else {
                    echo $connection->errno;
                    echo $connection->error;
                }

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