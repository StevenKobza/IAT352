<!DOCTYPE html>

<?php
session_start();

if (!isset($_SESSION["started"])) {
    $_SESSION["started"] = "true";
}

// get player's name from the URL
//Script_name gets the path to the file and then adds ?id= and then takes the total path which includes the id and then removes just the number.
//This is used for club detail, player and league detail
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
    <title>FIFA 21 — League Detail</title>
</head>

<body>

    <header class="header">
        <nav>
            <a href="../index.php"><img src="../img/logo.png" alt="FIFA 21 logo" class="logo"></a>
            <input class="menu-btn" type="checkbox" id="menu-btn" />
            <label class="menu-icon" for="menu-btn"><span class="navicon"></span></label>
            <ul class="menu">
                <li><a href="../players.php">Players</a></li>
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
        <h1 class="landing-header">League</h1>
    </div>


    <main>

        <div class="league-profile">
            <h2><?php echo $leagueName; ?></h2>
        </div>
        <!--Creates a table in HTML to start off with and puts club at the top-->
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">CLUB</th>
                </tr>
            </thead>
            <tbody>

                <?php
                //Querying the database, getting each of the clubnames that are in the league to be displayed later.
                //Can't get the clubid because each one is distinct in and of itself.
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
                        //Grabbing the first clubid that matches with the clubname.
                        $tempClubName = $row["clubname"];
                        $query2 = "SELECT clubid FROM club WHERE clubname = '$tempClubName' LIMIT 1";
                        $result2 = $connection->query($query2);
                        $row2 = $result2->fetch_assoc();
                        echo "<tr>";
                        // passes the info to the clubdetail page where it takes it from there.
                        echo "<td class='name-table'> <a href='../pages/clubdetail.php?id=" . $row2['clubid'] . "'>" . $row['clubname'] . "</a></td>";
                        echo "</tr>";
                    }
                }
                ?>


            </tbody>
        </table>



    </main>





</body>

</html>