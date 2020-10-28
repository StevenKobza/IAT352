<?php
function addPlayers() {
    set_include_path(".:/opt/lampp/htdocs/dev/p1");
    include("./phpData/logins.php");
    //$mysqli = new mysqli($dbhost, $dbuser, $dbpass);
    

    $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
    
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli->connect_error; 
    }

    
                
    $createPlayerQuery = "CREATE TABLE player (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        playerName VARCHAR(30) NOT NULL,
        position CHAR(4) NOT NULL,
        club VARCHAR(128) NOT NULL,
        league VARCHAR(128) NOT NULL,
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
        strongFoot VARCHAR(5) NOT NULL
    )";

    $createClubQuery = "CREATE TABLE club (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        clubName VARCHAR(128) NOT NULL,
        league VARCHAR(128) NOT NULL
    )";

    $createPlaysForQuery = "CREATE TABLE playsFor (
        playerName VARCHAR(128) NOT NULL PRIMARY KEY,
        player_id INT(6) NOT NULL,
        club_id INT(6) NOT NULL
    )";



    $createFavouritePlayersQuery;

    $file = fopen("./dataset/archive/players.csv", "r", 1);
    if (!$mysqli->query("SELECT * FROM player"))
    {
        if (!$mysqli->query("DROP TABLE IF EXISTS player") || !$mysqli->query($createPlayerQuery)) {
            echo "Table creation failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }
        if (!($playerStmt = $mysqli->prepare("INSERT INTO player(playerName, position,
            club, league, pace, shooting, passing, dribbling, defense, physical,
            cardRating, weakFoot, skillMoves, workRates, strongFoot) VALUES (?, ?,
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))) {
                echo "Preare failed: (" . $mysqli->errno . ") " . $mysqli->error;
        } else {
            $playerStmt->bind_param("ssssiiiiiiiiiss", $playerName, $position, $club,
        $league, $pace, $shooting, $passing, $dribbing, $defense, $physical,
        $cardRating, $weakFoot, $skillMoves, $workRates, $strongFoot);
        }

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
        }

        
    }
    fclose($file);
    

    if (!$mysqli->query("SELECT * FROM club")) {
        if (!$mysqli->query("DROP TABLE IF EXISTS club") || !$mysqli->query($createClubQuery)) {
            echo "Table creation failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }
    }
    if (!$mysqli->query("SELECT * FROM playsFor")) {
        if (!$mysqli->query("DROP TABLE IF EXISTS playsFor") || !$mysqli->query($createPlaysForQuery)) {
            echo "Table creation failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }
    }
    

    /*if (!($stmt = $mysqli->prepare("INSERT INTO users(username, password, email) VALUES (?, ?, ?)"))) {
        echo "Preare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }*/
}
?>