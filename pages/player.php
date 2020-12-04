<!DOCTYPE html>

<?php
session_start();

if (!isset($_SESSION["started"])) {
    $_SESSION["started"] = "true";
}

// get player's name from the URL and decode it
$playerId = str_replace($_SERVER["SCRIPT_NAME"] . "?id=", "", $_SERVER['REQUEST_URI']);
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
    <title>FIFA 21 — Player Detail</title>
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
        <h1 class="landing-header">Player</h1>
    </div>


    <main>

        <div class="basic-info">
            <div class="profile">
                <div class="general-info">
                    <h2><?php echo $playerName; ?></h2>
                    <p>Club: <?php echo $club ?></p>
                    <?php echo '<img src = "../img/datasetHeads/' . $playerId . '.jpg" alt = "">'; ?>

                </div>
            </div>
            
            <div class="general-stats">

                <?php
                // perform a query based on player id and display general stats
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



        <h2 class="specific-title">Specific Stats</h2>
        <div class="specific-stats">

            <?php
            // perform a query based on player id and display specific stats
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


                /* color numbers based on low, medium and high barriers (red, yellow and green)
                 scale of 100: 
                    red: 50 or less
                    yellow: between 51 and 80
                    green: 80 and more
                
                scale of 5:
                    red: 1 or less
                    yellow: between 2 and 3
                    green: 4 and more 
                */

                function categorize100s($stat, $name) {
                    if ($stat <= 50) {
                        echo "<div class='low'>";
                    } else if ($stat > 50 && $stat <= 80) {
                        echo "<div class='medium'>";
                    } else {
                        echo "<div class='high'>";
                    }
                    echo     "<h2> $name </h2>";
                    echo     "<h3> $stat </h3>";
                    echo  "</div>";
                }

                function categorize5s($stat, $name) {
                    if ($stat <= 1) {
                        echo "<div class='low'>";
                    } else if ($stat > 1 && $stat < 4) {
                        echo "<div class='medium'>";
                    } else {
                        echo "<div class='high'>";
                    }
                    echo     "<h2> $name </h2>";
                    echo     "<h3> $stat </h3>";
                    echo  "</div>";
                }


                // call color functions
                categorize100s($pace, 'PACE');
                categorize100s($shooting, 'SHOOTING');
                categorize100s($passing, 'PASSING');
                categorize100s($dribbling, 'DRIBBLING');
                categorize100s($defense, 'DEFENSE');
                categorize100s($physical, 'PHYSICAL');
                                
                categorize5s($weakFoot, 'WEAK FOOT');
                categorize5s($skillMoves, 'SKILL MOVES');
            }

            ?>

        </div>
        <!--Only shown if the person is logged in-->
        <?php if (isset($_SESSION["username"])) {
            if (isset($_POST["Fave"])) {
                $tempUN = $_SESSION["username"];
                $getUserIDQuery = "SELECT user.userid FROM user WHERE user.username = '$tempUN'";
                if (!$connection->query($getUserIDQuery)) {
                    echo "creation failed: (" . $connection->errno . ") " . $connection->error;
                } else {
                    $result = $connection->query($getUserIDQuery);
                }
                while ($rows = $result->fetch_assoc()) {
                    $userID = $rows["userid"];
                }
                $query = "INSERT INTO faves(userid, playerid) VALUES ($userID, $playerId)";
                if (!$connection->query($query)) {
                    if ($connection->errno == 1062) {
                        echo "You've already saved them!";
                    }
                }
            }
            if (isset($_POST["unFave"])) {
                $tempUN = $_SESSION["username"];
                $getUserIDQuery = "SELECT user.userid FROM user WHERE user.username = '$tempUN'";
                if (!$connection->query($getUserIDQuery)) {
                    echo "creation failed: (" . $connection->errno . ") " . $connection->error;
                } else {
                    $result = $connection->query($getUserIDQuery);
                }
                while ($rows = $result->fetch_assoc()) {
                    $userID = $rows["userid"];
                }
                $query = "DELETE FROM faves WHERE faves.userid = $userID AND faves.playerid = $playerId";
                if (!$connection->query($query)) {
                    if ($connection->errno == 1062) {
                        echo "You've already saved them!";
                    }
                    //echo "creation failed: (" . $connection->errno . ") " . $connection->error;
                }
            }


            $tempUN = $_SESSION["username"];
            $getUserIDQuery = "SELECT user.userid FROM user WHERE user.username = '$tempUN'";
            if (!$connection->query($getUserIDQuery)) {
                echo "creation failed: (" . $connection->errno . ") " . $connection->error;
            } else {
                $result = $connection->query($getUserIDQuery);
            }
            while ($rows = $result->fetch_assoc()) {
                $userID = $rows["userid"];
            }            

            // check if users have the player as their fave or not and display appropriate buttons
            $faveQuery = "SELECT * FROM faves WHERE faves.userid = $userID AND faves.playerid = $playerId";
            $results =$connection->query($faveQuery) or die("Bad Query: $sql_general");

            if (mysqli_num_rows($results) == 1) {
                // row exists. show the unfave button
                echo "<h2 class='specific-title'>Remove player from your collection</h2>";
                echo "<form method = 'post'>";    
                echo "<input type = 'submit' name = 'unFave' id ='unfave' value = 'Unfave'>";
            }

            else {
                // row doesn't exist, show the fave button
                echo "<h2 class='specific-title'>Add player to your collection</h2>";
                echo "<form method = 'post'>";    
                echo "<input type = 'submit' name = 'Fave' id ='fave' value = 'Fave'>";
            }

            //echo '<a class="fave" id = "fave" href="#">Fave</a>';
        }
        ?>
        <script src="../js/faves.js"></script>
    </main>
</body>
</html>