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
    $query = "SELECT DISTINCT clubname FROM club";

    // searching for clubnames based on user input
    if (isset($_GET["s"])) {
        if ($_GET["s"] != "") {
            $s = $_GET['s'];
            //% because it allows for wildcards on both sides.
            $query .= " WHERE clubname LIKE '%$s%' ";
        }
    }
    $result = $mysqli->query($query);
    
    echo "<thead>";
    echo "<tr>";
    echo '<th scope="col">CLUB</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            //Way to get around the distinct club ids being duplicates.
            $tempClubName = $row["clubname"];
            $query2 = "SELECT clubid FROM club WHERE clubname = '$tempClubName' LIMIT 1";
            $result2 = $mysqli->query($query2);
            $row2 = $result2->fetch_assoc();

            // this is the creation of the club
            echo "<tr>";
            echo "<td> <a href='../pages/clubdetail.php?id=" . $row2['clubid'] . "'>" . $row['clubname'] . "</a></td>";
            echo "</tr>";
        }
    }
    echo '</tbody>';
?>