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
    if (isset($_GET["f"])) {
        $temp = $_GET["f"];
    } else {
        $temp = "n";
    }
    $query = "SELECT player.playerid, player.playerName, player.cardRating, player.position, club.clubname, player.workRates, player.strongFoot 
    FROM player 
    INNER JOIN club ON player.playerid = club.playerid";
    
    if (isset($_GET["pos"])) {
        if ($_GET["pos"] == "") {

        } else {
        $temp = "'". $_GET['pos'] . "'";
        }
    }
    $moreThanOne = false;
    if ($_GET["pos"] != "") {
        $query .= " WHERE position = " . "$temp";
        $moreThanOne = true;
    } 
    $temp = "'" . $_GET["work"]. "'";
    if ($_GET["work"] != "") {
        if ($moreThanOne) {
            $query .= " AND ";
        } else {
            $query .= " WHERE ";
        }
        $query .= " workRates = " . "$temp";
        $moreThanOne = true;
    }
    $temp = "'" . $_GET["strong"]. "'";
    if ($_GET["strong"] != "") {
        if ($moreThanOne) {
            $query .= " AND ";
        } else {
            $query .= " WHERE ";
        }
        $query .= " strongFoot = " . "$temp";
    }

    //echo $query;
    // learned from: https://www.youtube.com/watch?v=gdEpUPMh63s
    // pagination

    $results_per_page = 10;
    $_SESSION["resPerPage"] = 10;

    // find the number of results stored in database
    if (!$mysqli->query($query)) {
        echo $mysqli->connect_errno . $mysqli->connect_error;
    }
    $result = $mysqli->query($query);
    if ($mysqli->connect_errno) {
        echo $mysqli->connect_errno;
        echo "Failed to connect to MySQL: " . $mysqli->connect_error; 
    }
    $number_of_results = mysqli_num_rows($result);
    $_SESSION["numRes"] = $number_of_results;

    // determine number of total pages available and round it
    $number_of_pages = ceil($number_of_results / $results_per_page);
    $_SESSION["numPage"] = $number_of_pages;

    //echo $_GET["page"];
    if (!isset($_GET['page'])) {
        $page = 1;
    } else {
        $page = $_GET['page'];
    }

    echo "<thead>";
    echo "<tr>";
        echo '<th scope="col"></th>';
        echo '<th scope="col">NAME</th>';
        echo '<th scope="col">CARD RATING</th>';
        echo '<th scope="col">POSITION</th>';
        echo '<th scope="col">CLUB</th>';
        echo '<th scope="col">WORK RATE</th>';
        echo '<th scope="col">STRONG FOOT</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    $this_page_first_result = ($page - 1) * $results_per_page;

    $query .= " LIMIT " . $this_page_first_result . ',' . $results_per_page;
    $result = $mysqli->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            if (isset($_GET["b"])) {
                echo '<th scope = "row"><img src = "../img/datasetHeads/' . $row["playerid"] . '.jpg" alt = ""></th>';
            } else {
                echo '<th scope = "row"><img src = "./img/datasetHeads/' . $row["playerid"] . '.jpg" alt = ""></th>';
            }

            // learned about passing link data to url from here: https://stackoverflow.com/questions/21890086/store-data-of-link-clicked-using-php-and-transferring-it-to-new-page
            if (isset($_GET["b"])) {
                echo "<td> <a href='../pages/player.php?id=" . $row['playerid'] . "'>" . $row['playerName'] . "</a></td>";
            } else {
            echo "<td class='name-table'> <a href='./pages/player.php?id=" . $row['playerid'] . "'>" . $row['playerName'] . "</a></td>";
            }
            echo '<td>' . $row["cardRating"] . "</td>";
            echo "<td>" . $row["position"] . "</td>";
            echo "<td>" . $row["clubname"] . "</td>";
            echo "<td>" . $row["workRates"] . "</td>";
            echo "<td>" . $row["strongFoot"] . "</td>";
            echo "</tr>";
        }
    }

    echo '</tbody>';
    echo '</table>';

        echo "IAT352";
        $link = "";
        $limit = 5;

        if ($_SESSION["numPage"] >= 1 && $page <= $_SESSION["numPage"]) {
            $counter = 1;
            $link = "";
            if ($page > 1)         // show 1 if on page 2 and after
            {
                if (isset($_GET["b"])) {
                $link .= "<button id = 'pagination' class = 'pagination' onclick = \"changePage(this.value, 'pages')\" value = 1>1</button>";
                } else {
                    $link .= "<button id = 'pagination' class = 'pagination' onclick = \"changePage(this.value, 'base')\" value = 1>1</button>";
                }
                //$link .= "<a class='pagination' href=\"?page=1\">1 </a> ... ";
            }
            // create links for rest of the pages and add page number based on for-loop index
            for ($x = $page; $x <= $_SESSION["numPage"]; $x++) {
                if ($counter < $limit)
                    if(isset($_GET["b"])) {
                    $link .= "<button id = 'pagination' class='pagination' onclick = \"changePage(this.value, 'pages')\" value = " . $x . ">" . $x . "</button>";
                    } else {
                        $link .= "<button id = 'pagination' class='pagination' onclick = \"changePage(this.value, 'base')\" value = " . $x . ">" . $x . "</button>";
                    }
                    //\"?page=" . $x . "\">" . $x . " </a>";

                $counter++;
            }
            // add dots between pages if the page number is less than the total number of pages minus maximum number of pagination numbers allowed, divided by two
            if ($page < $_SESSION["numPage"] - ($limit / 2)) {
                if (isset($_GET["b"])) {
                $link .= "... " . "<button id = 'totalPage' class='pagination' onclick = \"changePage(this.value, 'pages')\" value = " . $_SESSION["numPage"] . ">" . $_SESSION["numPage"] . "</button>";
                } else {
                    $link .= "... " . "<button id = 'totalPage' class='pagination' onclick = \"changePage(this.value, 'base')\" value = " . $_SESSION["numPage"] . ">" . $_SESSION["numPage"] . "</button>";
                }
                //href=\"?page=" . $number_of_pages . "\">" . $number_of_pages . " </a>";
            }
        }

        echo $link;
