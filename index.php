<!DOCTYPE html>
<?php
session_start();

if (!isset($_SESSION["started"])) {
    $_SESSION["started"] = "true";
}

// database connection
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "fifa2021";

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
                    echo '<li> <a href = "#">' . $_SESSION["username"] . '</a></li>';
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
            <form action = "" class = "filterForm" method = "post">
                <fieldset class="position">
                    <label for="position">Position</label>
                    <select name="position" id="position">
                        <option value = "">Select One</option>
                        <?php
                        while ($rows = $positionResult->fetch_assoc()) {
                            $order_number = $rows['position'];
                            echo "<option value='$order_number'" . $selected;
                            echo ">";
                            echo $order_number;
                            echo "</option>";
                        }
                        ?>
                    </select>
                </fieldset>

                <fieldset class="workRate">
                    <label for="workRate">Work Rate</label>
                    <select name="workRate" id="workRate">
                        <option value = "">Select One</option>
                        <?php
                        while ($rows = $workRateResult->fetch_assoc()) {
                            $order_number = $rows['workRates'];
                            echo "<option value='$order_number'" . $selected;
                            echo ">";
                            echo $order_number;
                            echo "</option>";
                        }
                        ?>
                    </select>
                </fieldset>

                <fieldset class="strongFoot">
                    <label for="strongFoot">Strong Foot</label>
                    <select name="strongFoot" id="strongFoot">
                        <option value = "">Select One</option>
                        <?php
                        while ($rows = $strongFootResult->fetch_assoc()) {
                            $order_number = $rows['strongFoot'];
                            echo "<option value='$order_number'" . $selected;
                            echo ">";
                            echo $order_number;
                            echo "</option>";
                        }
                        ?>
                    </select>
                </fieldset>
                <input type = "submit">
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
                    $query .= " LIMIT 10";
                    $result = $connection->query($query);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo '<th scope = "row"><img src = "./img/datasetHeads/'. $row["id"] . '.jpg" alt = ""></th>';
                            echo '<td><a href = ./pages/player.php">' . $row["playerName"] . "</a></td>";
                            echo '<td>'. $row["cardRating"] . "</td>";
                            echo "<td>" . $row["position"] . "</td>";
                            echo "<td>" . $row["club"] . "</td>";
                            echo "<td>" . $row["workRates"] . "</td>";
                            echo "<td>" . $row["strongFoot"] . "</td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                <!--<tr>
                    <th scope="row"><img src="./img/1.png" alt=""></th>
                    <td><a href="./pages/player.php">K. Mbappé</a></td>
                    <td>98</td>
                    <td>ST</td>
                    <td>Paris Saint-Germain</td>
                    <td>High/Low</td>
                    <td>Right</td>
                </tr>
                <tr>
                    <th scope="row"><img src="./img/2.png" alt=""></th>
                    <td>João Félix</td>
                    <td>94</td>
                    <td>CF</td>
                    <td>Atletico de Madrid</td>
                    <td>High/Medium</td>
                    <td>Right</td>
                </tr>
                <tr>
                    <th scope="row"><img src="./img/3.png" alt=""></th>
                    <td>Vinícius Jr.</td>
                    <td>95</td>
                    <td>LW</td>
                    <td>Real Madrid</td>
                    <td>High/Medium</td>
                    <td>Right</td>
                </tr>
                <tr>
                    <th scope="row"><img src="./img/10.png" alt=""></th>
                    <td>M. de Ligt</td>
                    <td>96</td>
                    <td>CB</td>
                    <td>Pimeonte Calcio</td>
                    <td>Medium/High</td>
                    <td>Right</td>
                </tr>
                <tr>
                    <th scope="row"><img src="./img/11.png" alt=""></th>
                    <td>T. Alexander-Arnold</td>
                    <td>95</td>
                    <td>RB</td>
                    <td>Liverpool</td>
                    <td>High/High</td>
                    <td>Right</td>
                </tr>-->


            </tbody>
        </table>


        <a href="#" class="pagination">Next</a>





    </main>





</body>

</html>