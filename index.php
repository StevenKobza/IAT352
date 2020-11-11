<!DOCTYPE html>
<?php
session_start();

if (!isset($_SESSION["started"])) {
    $_SESSION["started"] = "true";
}

// database connection
include("./phpData/dbconnect.php");

$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);


// test if connection succeeded 
if (mysqli_connect_errno()) {
    // if connection failed, skip the rest of the code and print an error 
    die("Database connection failed: " .
        mysqli_connect_error() .
        " (" . mysqli_connect_errno() . ")");
}
?>


<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./css/main.css">
    <title>FIFA 21</title>
</head>

<body>

    <header class="header">
        <nav>
            <a href="./index.php"><img src="./img/logo.png" alt="FIFA 21 logo" class="logo"></a>
            <input class="menu-btn" type="checkbox" id="menu-btn" />
            <label class="menu-icon" for="menu-btn"><span class="navicon"></span></label>
            <ul class="menu">
                <li><a href="./index.php">Players</a></li>
                <li><a href="./pages/clubs.php">Clubs</a></li>
                <li><a href="./pages/leagues.php">Leagues</a></li>
                <li><a href="./pages/position.php">Position</a></li>
                <?php
                if (isset($_SESSION["username"])) {
                    echo '<li> <a href = "#" id="user">' . $_SESSION["username"] . '</a></li>';
                    echo '<li> <a href = "./data/log_out_post.php">Log Out</a></li>';
                } else {
                    echo '<li><a href="./pages/login.php">Login</a></li>';
                    echo '<li><a href="./pages/sign-up.php">Sign up</a></li>';
                }


                ?>
            </ul>
        </nav>
    </header>

    <div class="main-banner">
        <h1 class="landing-header">Players</h1>
    </div>


    <main>

        <div class="filter">

            <?php
            $positionResult = mysqli_query($connection, "SELECT DISTINCT position FROM player");
            $workRateResult = mysqli_query($connection, "SELECT DISTINCT workRates FROM player");
            $strongFootResult = mysqli_query($connection, "SELECT DISTINCT strongFoot FROM player");
            ?>

            <form action="" class="filterForm" method="post">
                <fieldset class="position">
                    <label for="position">Position</label>
                    <select name="position" id="position">
                        <option value="">Select One</option>
                        <?php
                        while ($rows = $positionResult->fetch_assoc()) {
                            $position = $rows['position'];
                            $selected = '';
                            if (!empty($_POST['position']) && $_POST['position'] == $position) {
                                $selected = ' selected="selected"';
                            }
                            echo "<option value='$position'" . $selected;
                            echo ">";
                            echo $position;
                            echo "</option>";
                        }
                        ?>
                    </select>
                </fieldset>

                <fieldset class="workRate">
                    <label for="workRate">Work Rate</label>
                    <select name="workRate" id="workRate">
                        <option value="">Select One</option>
                        <?php
                        while ($rows = $workRateResult->fetch_assoc()) {
                            $workRate = $rows['workRates'];
                            $selected = '';
                            if (!empty($_POST['workRate']) && $_POST['workRate'] == $workRate) {
                                $selected = ' selected="selected"';
                            }
                            echo "<option value='$workRate'" . $selected;
                            echo ">";
                            echo $workRate;
                            echo "</option>";
                        }
                        ?>
                    </select>
                </fieldset>

                <fieldset class="strongFoot">
                    <label for="strongFoot">Strong Foot</label>
                    <select name="strongFoot" id="strongFoot">
                        <option value="">Select One</option>
                        <?php
                        while ($rows = $strongFootResult->fetch_assoc()) {
                            $strongFoot = $rows['strongFoot'];
                            $selected = '';
                            if (!empty($_POST['strongFoot']) && $_POST['strongFoot'] == $strongFoot) {
                                $selected = ' selected="selected"';
                            }
                            echo "<option value='$strongFoot'" . $selected;
                            echo ">";
                            echo $strongFoot;
                            echo "</option>";
                        }
                        ?>
                    </select>
                </fieldset>
                <input type="submit">
            </form>

        </div>


        <table class="table">
            <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col">NAME</th>
                    <th scope="col">CARD RATING</th>
                    <th scope="col">POSITION</th>
                    <th scope="col">CLUB</th>
                    <th scope="col">WORK RATE</th>
                    <th scope="col">STRONG FOOT</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM player";
                $somethingSet = false;
                if (isset($_POST["strongFoot"])) {
                    if ($_POST["strongFoot"] != "") {
                        if ($somethingSet == true) {
                            $query .= " AND ";
                        } else if ($somethingSet == false) {
                            $query .= " where ";
                            $somethingSet = true;
                        }
                        $temp = $_POST["strongFoot"];
                        $temp = "\"$temp\"";
                        $query .= "strongFoot = " . $temp;
                    }
                }
                if (isset($_POST["workRate"])) {
                    if ($_POST["workRate"] != "") {
                        if ($somethingSet == true) {
                            $query .= " AND ";
                        } else if ($somethingSet == false) {
                            $query .= " where ";
                            $somethingSet = true;
                        }
                        $temp = $_POST["workRate"];
                        $temp = "\"$temp\"";
                        $query .= "workRates = " . $temp;
                    }
                }
                if (isset($_POST["position"])) {
                    if ($_POST["position"] != "") {
                        if ($somethingSet == true) {
                            $query .= " AND ";
                        } else if ($somethingSet == false) {
                            $query .= " where ";
                            $somethingSet = true;
                        }
                        $temp = $_POST["position"];
                        $temp = "\"$temp\"";
                        $query .= "position = " . $temp;
                    }
                }


                // learned from: https://www.youtube.com/watch?v=gdEpUPMh63s
                // pagination

                $results_per_page = 20;

                // find the number of results stored in database
                $result = $connection->query($query);

                $number_of_results = mysqli_num_rows($result);

                // determine number of total pages available
                $number_of_pages = ceil($number_of_results / $results_per_page);

                // determine which page number visitor is currently on
                if (!isset($_GET['page'])) {
                    $page = 1;
                } else {
                    $page = $_GET['page'];
                }

                // determine the sql LIMIT starting number for the results on the displaying page
                $this_page_first_result = ($page - 1) * $results_per_page;

                $query .= " LIMIT " . $this_page_first_result . ',' . $results_per_page;
                $result = $connection->query($query);


                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo '<th scope = "row"><img src = "./img/datasetHeads/' . $row["id"] . '.jpg" alt = ""></th>';

                        // learned about passing link data to url from here: https://stackoverflow.com/questions/21890086/store-data-of-link-clicked-using-php-and-transferring-it-to-new-page
                        echo "<td> <a href='./pages/player.php?id=" . $row['id'] . "'>" . $row['playerName'] . "</a></td>";
                        echo '<td>' . $row["cardRating"] . "</td>";
                        echo "<td>" . $row["position"] . "</td>";
                        echo "<td>" . $row["club"] . "</td>";
                        echo "<td>" . $row["workRates"] . "</td>";
                        echo "<td>" . $row["strongFoot"] . "</td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
        <?php

        // learned from: https://stackoverflow.com/questions/28716904/limit-pages-numbers-on-php-pagination
        // limit the number of pages on pagination
        $link = "";
        $limit = 5;

        if ($number_of_pages >= 1 && $page <= $number_of_pages) {
            $counter = 1;
            $link = "";
            if ($page > 1)         // show 1 if on page 2 and after
            {
                $link .= "<a class='pagination' href=\"?page=1\">1 </a> ... ";
            }
            for ($x = $page; $x <= $number_of_pages; $x++) {
                if ($counter < $limit)
                    $link .= "<a class='pagination' href=\"?page=" . $x . "\">" . $x . " </a>";

                $counter++;
            }
            if ($page < $number_of_pages - ($limit / 2)) {
                $link .= "... " . "<a class='pagination' href=\"?page=" . $number_of_pages . "\">" . $number_of_pages . " </a>";
            }
        }

        echo $link;
        ?>





    </main>





</body>

</html>