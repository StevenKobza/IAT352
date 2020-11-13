<?php
function addPlayers() {
    set_include_path(".:/opt/lampp/htdocs/dev/steven_kobza");
    include("../phpData/dbconnect.php");
    $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli->connect_error; 
    }

    /*if(!$mysqli->select_db("fifa2021")) {
        $sql = "CREATE DATABASE fifa2021";

        if ($mysqli->query($sql) != FALSE) {
            $mysqli->select_db("fifa2021");
        }
    }*/

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

    /*$createPlaysForQuery = "CREATE TABLE playsFor (
        playerName VARCHAR(128) NOT NULL PRIMARY KEY,
        clubName VARCHAR(128) NOT NULL
    )";*/



    $createFavouritePlayersQuery;

    $file = fopen("../dataset/archive/players.csv", "r", 1);
    $mysqli->query("DROP TABLE IF EXISTS club");
    $mysqli->query("DROP TABLE IF EXISTS faves");
    $mysqli->query("DROP TABLE IF EXISTS league");
    $mysqli->query("DROP TABLE IF EXISTS user");
    $mysqli->query("DROP TABLE IF EXISTS player");
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
        if (!($leagueStmt = $mysqli->prepare("INSERT INTO league(leagueName) VALUES (?)"))) {
            echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
        } else {
            $leagueStmt->bind_param("s", $league);
        }
        if (!($clubStmt = $mysqli->prepare("INSERT INTO club (clubName, leagueid, playerid) VALUES (?, ?, ?)"))) {
            echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
        } else {
            $clubStmt->bind_param("sii", $club, $leagueid, $playerid);
        }
        /*if (!($playsForStmt = $mysqli->prepare("INSERT INTO playsFor(playerName, clubName) VALUES (?, ?)"))) {
            echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
        } else {
            $playsForStmt->bind_param("ss", $playerName, $club);
        }*/

        $row = 1;
        while (($data = fgetcsv($file, 1000, ",")) != FALSE) {
            $num = count($data);
            if ($row == 1) {
                $row++;
                continue;
            }
            else {
                $row++;
            }
            $leagueid = ($row-2);
            $playerid = ($row-2);
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
            $playerStmt->execute();
            $leagueStmt->execute();
            $clubStmt->execute();
            //$playsForStmt->execute();
        }

        
    fclose($file);
    


    

    /*if (!($stmt = $mysqli->prepare("INSERT INTO users(username, password, email) VALUES (?, ?, ?)"))) {
        echo "Preare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }*/
}

addPlayers();
?>