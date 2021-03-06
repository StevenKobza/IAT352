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
    <title>FIFA 21 - Players</title>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs=" crossorigin="anonymous"></script>
    <script src="./js/ajax.js"></script>
</head>

<body>

    <header class="header">
        <nav>
            <a href="./index.php"><img src="./img/logo.png" alt="FIFA 21 logo" class="logo"></a>
            <input class="menu-btn" type="checkbox" id="menu-btn" />
            <label class="menu-icon" for="menu-btn"><span class="navicon"></span></label>
            <ul class="menu">
                <li><a href="./players.php">Players</a></li>
                <li><a href="./pages/clubs.php">Clubs</a></li>
                <li><a href="./pages/leagues.php">Leagues</a></li>
                <li><a href="./pages/position.php">Position</a></li>
                <?php
                // display username on navbar if user is logged in
                if (isset($_SESSION["username"])) {
                    echo '<li> <a href = "./pages/userdetail.php" id="user">' . $_SESSION["username"] . '</a></li>';
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

            // queries for displaying distinct values for each 
            $positionResult = mysqli_query($connection, "SELECT DISTINCT position FROM player");
            $workRateResult = mysqli_query($connection, "SELECT DISTINCT workRates FROM player");
            $strongFootResult = mysqli_query($connection, "SELECT DISTINCT strongFoot FROM player");
            ?>
            <div>
            <label for="position">Position</label>
            <select name="position" id="position" onchange="filter(this.value, 'position', 'pages')">
                <option value="">Select One</option>
                <?php
                // populate position filter with distinct position values and if selected, keep the selected value
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
            </div>


            <div>
            <label for="workRate">Work Rate</label>
            <select name="workRate" id="workRate" onchange="filter(this.value, 'workRate', 'pages')">
                <option value="">Select One</option>
                <?php
                // populate workRate filter with distinct values and if selected, keep the selected value
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
            </div>


            <div>
            <label for="strongFoot">Strong Foot</label>
            <select name="strongFoot" id="strongFoot" onchange="filter(this.value, 'strongFoot', 'pages')">
                <option value="">Select One</option>
                <?php
                // populate strongFoot filter with distinct values and if selected, keep the selected value
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
            </div>


            </form>

        </div>


        <table class="table" id = "table">
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
                // check if the fiters are selected, and add them to the query
                $query = "SELECT player.playerid, player.playerName, player.cardRating, player.position, club.clubname, player.workRates, player.strongFoot 
                FROM player 
                INNER JOIN club ON player.playerid = club.playerid";
                  $results_per_page = 10;

                  // find the number of results stored in database
                  $result = $connection->query($query);
                  $number_of_results = mysqli_num_rows($result);
  
                  // determine number of total pages available and round it
                  $number_of_pages = ceil($number_of_results / $results_per_page);
                  $_SESSION["numPage"] = $number_of_pages;
  
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
                          echo '<th scope = "row"><img src = "./img/datasetHeads/' . $row["playerid"] . '.jpg" alt = ""></th>';
  
                          // learned about passing link data to url from here: https://stackoverflow.com/questions/21890086/store-data-of-link-clicked-using-php-and-transferring-it-to-new-page
                          echo "<td class='name-table'> <a href='./pages/player.php?id=" . $row['playerid'] . "'>" . $row['playerName'] . "</a></td>";
                          echo '<td>' . $row["cardRating"] . "</td>";
                          echo "<td>" . $row["position"] . "</td>";
                          echo "<td>" . $row["clubname"] . "</td>";
                          echo "<td>" . $row["workRates"] . "</td>";
                          echo "<td>" . $row["strongFoot"] . "</td>";
                          echo "</tr>";
                      }
                  }
                  ?>
              </tbody>
          </table>
          <div id = "list">
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
                $link .= "<button id = 'pagination' class = 'pagination' onclick = changePage(this.value) value = 1>1</button>";
                  //$link .= "<a class='pagination' href=\"?page=1\">1 </a> ... ";
              }
              // create links for rest of the pages and add page number based on for-loop index
              for ($x = $page; $x <= $number_of_pages; $x++) {
                  if ($counter < $limit)
                  $link .= "<button id = 'pagination' class='pagination' onclick = changePage(this.value) value = " . $x . ">" . $x . "</button>";
                      //\"?page=" . $x . "\">" . $x . " </a>";
  
                  $counter++;
              }
              // add dots between pages if the page number is less than the total number of pages minus maximum number of pagination numbers allowed, divided by two
              if ($page < $number_of_pages - ($limit / 2)) {
                  
                $link .= "... " . "<button id = 'totalPage' class='pagination' onclick = changePage(this.value) value = " . $_SESSION["numPage"] . ">" . $_SESSION["numPage"] . "</button>";
                  //href=\"?page=" . $number_of_pages . "\">" . $number_of_pages . " </a>";
              }
          }
  
          echo $link;
          ?>
          </div>
  



    </main>

</body>

</html>