<?php
function addPlayers() {
    include 'logins.php';
    $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli->connect_error; 
    }
                
    $createPlayerQuery = "CREATE TABLE players (
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

    $createClubQuery = "CREATE TABLE clubs (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        clubName VARCHAR(128) NOT NULL,
        league VARCHAR(128) NOT NULL
    )";

    $createPlaysForQuery = "CREATE TABLE playsFor (
        player_id INT(6) NOT NULL,
        club_id INT(6) NOT NULL,
        FOREIGN_KEY(player_id) REFERENCES players(id),
        FOREIGN_KEY(club_id) REFERENCES clubs(id)
    )";

    $createFavouritePlayersQuery;

    if (!$mysqli->query("DROP TABLE IF EXISTS players") || !$mysqli->query($createPlayerQuery)) {
        echo "Table creation failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }

    /*if (!($stmt = $mysqli->prepare("INSERT INTO users(username, password, email) VALUES (?, ?, ?)"))) {
        echo "Preare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }*/
}
?>