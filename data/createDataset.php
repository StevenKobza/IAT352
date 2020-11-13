<?php
function addPlayers() {
    set_include_path(".:/opt/lampp/htdocs/steven_kobza");
    include("../phpData/dbconnect.php");
    $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli->connect_error; 
    }

    $createUserQuery = "CREATE TABLE user (
        username VARCHAR(128) NOT NULL,
        email VARCHAR(255) NOT NULL,
        userid INT AUTO_INCREMENT,
        password VARCHAR(128) NOT NULL,
        PRIMARY KEY (userid)
    )";
                
    $createPlayerQuery = "CREATE TABLE player (
        playerid INT AUTO_INCREMENT,
        playerName VARCHAR(30) NOT NULL,
        position CHAR(4) NOT NULL,
        pace TINYINT(2) UNSIGNED NOT NULL,
        shooting TINYINT(2) UNSIGNED NOT NULL,
        passing TINYINT(2) UNSIGNED NOT NULL,
        dribbling TINYINT(2) UNSIGNED NOT NULL,
        defense TINYINT(2) UNSIGNED NOT NULL,
        physical TINYINT(2) UNSIGNED NOT NULL,
        cardRating TINYINT(2) UNSIGNED NOT NULL,
        weakFoot TINYINT(1) UNSIGNED NOT NULL,
        skillMoves TINYINT(1) UNSIGNED NOT NULL,
        workRates VARCHAR(255) NOT NULL,
        strongFoot VARCHAR(5) NOT NULL,
        PRIMARY KEY(playerid)
    )";

    $createLeagueQuery = "CREATE TABLE league (
        leagueName VARCHAR(128) NOT NULL,
        leagueid INT AUTO_INCREMENT,
        PRIMARY KEY(leagueid)
        )";

    $createFavesQuery = "CREATE TABLE faves (
        userid INT NOT NULL,
        playerid INT NOT NULL,
        PRIMARY KEY (userid, playerid),
        FOREIGN KEY (userid) REFERENCES user(userid),
        FOREIGN KEY (playerid) REFERENCES player(playerid)
        )";

    $createClubQuery = "CREATE TABLE club (
        clubid INT AUTO_INCREMENT,
        clubname VARCHAR(128) NOT NULL,
        leagueid INT NOT NULL,
        playerid INT NOT NULL,
        PRIMARY KEY(clubid),
        FOREIGN KEY (leagueid) REFERENCES league(leagueid),
        FOREIGN KEY (playerid) REFERENCES player(playerid)
    )";

    $file = fopen("../dataset/archive/players.csv", "r", 1);
    
    //Dropping all the tables to prevent any foreign key problems
    $mysqli->query("DROP TABLE IF EXISTS club");
    $mysqli->query("DROP TABLE IF EXISTS faves");
    $mysqli->query("DROP TABLE IF EXISTS league");
    $mysqli->query("DROP TABLE IF EXISTS user");
    $mysqli->query("DROP TABLE IF EXISTS player");

        //If for some reason it doesn't work, it drops it again and then creates the table again.
        if (!$mysqli->query("DROP TABLE IF EXISTS user") || !$mysqli->query($createUserQuery)) {
            echo "Table creation failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }
        if (!$mysqli->query("DROP TABLE IF EXISTS player") || !$mysqli->query($createPlayerQuery)) {
            echo "Table creation failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }
        if (!$mysqli->query("DROP TABLE IF EXISTS league") || !$mysqli->query($createLeagueQuery)) {
            echo "Table creation failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }
        if (!$mysqli->query("DROP TABLE IF EXISTS faves") || !$mysqli->query($createFavesQuery)) {
            echo "Table creation failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }
        if (!$mysqli->query("DROP TABLE IF EXISTS club") || !$mysqli->query($createClubQuery)) {
            echo "Table creation failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }


        //Preparing player statement.
        if (!($playerStmt = $mysqli->prepare("INSERT INTO player(playerName, position,
            pace, shooting, passing, dribbling, defense, physical,
            cardRating, weakFoot, skillMoves, workRates, strongFoot) VALUES (?, ?,
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))) {
                echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
        } else {
            $playerStmt->bind_param("ssiiiiiiiiiss", $playerName, $position, 
            $pace, $shooting, $passing, $dribbing, $defense, $physical,
        $cardRating, $weakFoot, $skillMoves, $workRates, $strongFoot);
        }

        //Preparing league statement
        if (!($leagueStmt = $mysqli->prepare("INSERT INTO league(leagueName) VALUES (?)"))) {
            echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
        } else {
            $leagueStmt->bind_param("s", $league);
        }

        //Preparing club statement
        if (!($clubStmt = $mysqli->prepare("INSERT INTO club (clubName, leagueid, playerid) VALUES (?, ?, ?)"))) {
            echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
        } else {
            $clubStmt->bind_param("sii", $club, $leagueid, $playerid);
        }

        $row = 1;
        while (($data = fgetcsv($file, 1000, ",")) != FALSE) {
            if ($row == 1) {
                $row++;
                continue;
            }
            else {
                $row++;
            }
            //This just sets the id to be the same as the row that is being read in.
            //This works with all the indices.
            $leagueid = ($row-2);
            $playerid = ($row-2);

            //Setting the variables for the prepared statements
            $playerName = $data[0];
            $position = $data[1];
            $club = $data[2];
            $league = $data[3];
            $pace = $data[4];
            $shooting = $data[5];
            $passing = $data[6];
            $dribbing = $data[7];
            $defense = $data[8];
            $physical = $data[9];
            $cardRating = $data[10];
            $weakFoot = $data[11];
            $skillMoves = $data[12];
            $workRates = $data[13];
            $strongFoot = $data[14];

            //Executing said prepared statements
            $playerStmt->execute();
            $leagueStmt->execute();
            $clubStmt->execute();
        }

        
    fclose($file);
}

addPlayers();
?>