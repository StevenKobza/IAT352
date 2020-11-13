<!DOCTYPE html>

<?php
session_start();

if (!isset($_SESSION["started"])) {
    $_SESSION["started"] = "true";
}

// get player's name from the URL
$playerId = str_replace("/dev/steven_kobza/pages/player.php?id=", "", $_SERVER['REQUEST_URI']);
$playerId = urldecode($playerId);

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
$sql_basic = "SELECT club.clubname, player.playerName FROM player 
INNER JOIN club ON player.playerid = club.playerid WHERE player.playerid=$playerId";
if ($query_basic = $connection->query($sql_basic)) {

} else {
    echo $connection->errno;
    echo $connection->error;
}
//$query_basic = mysqli_query($connection, $sql_basic) or die("Bad Query: $sql_basic");
$row_basic = mysqli_fetch_assoc($query_basic);
$club =  $row_basic['clubname'];
$playerName = $row_basic['playerName'];
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
        <h1 class="landing-header">Player</h1>
    </div>


    <main>

        <div>
            <div class="profile">
                <div class="general-info">
                    <h2><?php echo $playerName; ?></h2>
                    <p>Club: <?php echo $club ?></p>
                    <?php echo '<img src = "../img/datasetHeads/'. $playerId . '.jpg" alt = "">'; ?>

                </div>
            </div>

            <h2>General</h2>
            <div class="general-stats">

                <?php
                $sql_general = "SELECT cardRating, position, workRates, strongFoot FROM player WHERE playerid='$playerId'";
                $query_general = mysqli_query($connection, $sql_general) or die("Bad Query: $sql_general");

                while ($rows = $query_general->fetch_assoc()) {
                    $cardRating = $rows['cardRating'];
                    $position = $rows['position'];
                    $workRate = $rows['workRates'];
                    $strongFoot = $rows['strongFoot'];

                    echo "<div>
                            <h2> Card Rating </h2>
                            <h3> $cardRating </h3>
                        
                         </div>

                        <div>
                            <h2>Position</h2>
                            <h3> $position </h3>
                        </div>

                        <div>
                            <h2> Work Rate </h2>
                            <h3> $workRate </h3>
                        </div>

                        <div>
                            <h2> Strong Foot </h2>
                            <h3> $strongFoot </h3>
                        </div>
                    ";
                }

                ?>

            </div>
        </div>



        <h2>Specific</h2>
        <div class="specific-stats">

            <?php
            $sql_specific = "SELECT pace, shooting, passing, dribbling, defense, physical, weakFoot, skillMoves FROM player WHERE playerid='$playerId'";
            $query_specific = mysqli_query($connection, $sql_specific) or die("Bad Query: $sql_specific");

            while ($rows = $query_specific->fetch_assoc()) {
                $pace = $rows['pace'];
                $shooting = $rows['shooting'];
                $passing = $rows['passing'];
                $dribbling = $rows['dribbling'];
                $defense = $rows['defense'];
                $physical = $rows['physical'];
                $weakFoot = $rows['weakFoot'];
                $skillMoves = $rows['skillMoves'];


                echo "<div>
                            <h2> PACE </h2>
                            <h3> $pace </h3>
                        
                         </div>

                        <div>
                            <h2> SHOOTING </h2>
                            <h3> $shooting </h3>
                        </div>

                        <div>
                            <h2> PASSING </h2>
                            <h3> $passing </h3>
                        </div>

                        <div>
                            <h2> DRIBBLING </h2>
                            <h3> $dribbling </h3>
                        </div>

                        <div>
                            <h2> DEFENSE </h2>
                            <h3> $defense </h3>
                        </div>

                        <div>
                            <h2> PHYSICAL </h2>
                            <h3> $physical </h3>
                        </div>

                        <div>
                            <h2> WEAK FOOT </h2>
                            <h3> $weakFoot </h3>
                        </div>

                        <div>
                            <h2> SKILL MOVES </h2>
                            <h3> $skillMoves </h3>
                        </div>
                    ";
            }

            ?>

        </div>
            <?php if(isset($_SESSION["username"])) {
        echo "<h2>Add player to your collection</h2>";
        echo '<a class="fave" href="#">Fave</a>';
            }
        ?>







    </main>





</body>

</html>