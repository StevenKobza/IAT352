<?php
    session_start();

    if (!isset($_SESSION["started"])) {
        $_SESSION["started"] = "true";
    }
    

    include("../phpData/dbconnect.php");
    $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli->connect_error; 
    }

    if (isset($_SESSION["username"])) {
        $query = "SELECT player.playerid, player.playerName, player.cardRating, player.position, club.clubname, player.workRates, player.strongFoot
        FROM ((faves 
        INNER JOIN player ON player.playerid = faves.playerid)
        INNER JOIN club ON faves.playerid = club.playerid)";
    } else {
        $query = "SELECT player.playerid, player.playerName, player.cardRating, player.position, club.clubname, player.workRates, player.strongFoot 
        FROM player 
        INNER JOIN club ON player.playerid = club.playerid";
    }

