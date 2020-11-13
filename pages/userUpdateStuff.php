<!DOCTYPE html>

<?php
session_start();

if (!isset($_SESSION["started"])) {
    $_SESSION["started"] = "true";
}

// database connection
include("../phpData/dbconnect.php");

$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// test if connection succeeded 
if (mysqli_connect_errno()) {
    // if connection failed, skip the rest of the code and print an error 
    die("Database connection failed: " .
        mysqli_connect_error() .
        " (" . mysqli_connect_errno() . ")");
}


// queries
if (isset($_SESSION["username"]) == false) {
    die("How did you get here");
}
$username = $_SESSION["username"];

$sql_basic = "SELECT user.username, user.password, user.email FROM user WHERE user.username = '$username'";
if ($query_basic = $connection->query($sql_basic)) {
} else {
    echo $connection->errno;
    echo $connection->error;
}

$row_basic = mysqli_fetch_assoc($query_basic);

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <title>FIFA 21 — User Detail</title>
</head>

<body>
    <?php
    $atLeastOne = false;
    $tempUsername;
    $runQuery = false;
    $updateUserName = false;
    if (isset($_POST["usernameForm"]) || (isset($_POST["passwordForm"]) && isset($_POST["newPassword"]))) {
        if (isset($_POST["usernameForm"])) {
            if ($_POST["usernameForm"] != "") {
                $runQuery = true;
                $updateUserName = true;
                $tempUsername = $_POST["usernameForm"];
                if ($atLeastOne == false) {
                    $query = "UPDATE user SET username = '$tempUsername'";
                    $atLeastOne = true;
                } else {
                    $query .= ", username = '$tempUsername'";
                }
            }
        }
        if (isset($_POST["newPasswordForm"]) && isset($_POST["passwordForm"])) {
            if ($_POST["newPasswordForm"] != "" && $_POST["passwordForm"] != "") {
                if (password_verify($_POST["passwordForm"], $row_basic["password"])) {
                    $pw = password_hash($_POST["newPasswordForm"], PASSWORD_DEFAULT);
                    $pw = $connection->real_escape_string($pw);
                    $runQuery = true;
                    if ($atLeastOne == false) {
                        $query = "UPDATE user SET password = \"$pw\"";
                        $atLeastOne = true;
                    } else {
                        $query .= ", password = \"$pw\"";
                    }
                } else {
                    echo "Your old password needs to be the same as it was before";
                }
            }
        }
        if ($runQuery) {
            $query .= " WHERE username = '$username'";

            if ($result = $connection->query($query)) {
                if ($updateUserName) {
                    $_SESSION["username"] = $_POST["usernameForm"];
                }
            } else {
                echo $connection->errno;
                echo $connection->error;
            }
        }
    }
    ?>
    <header class="header">
        <nav>
            <a href="../index.php"><img src="../img/logo.png" alt="FIFA 21 logo" class="logo"></a>
            <input class="menu-btn" type="checkbox" id="menu-btn" />
            <label class="menu-icon" for="menu-btn"><span class="navicon"></span></label>
            <ul class="menu">
                <li><a href="./players.php">Players</a></li>
                <li><a href="./clubs.php">Clubs</a></li>
                <li><a href="./leagues.php">Leagues</a></li>
                <li><a href="./position.php">Position</a></li>
                <?php
                // display username on navbar if user is logged in
                if (isset($_SESSION["username"])) {
                    echo '<li> <a href = "../pages/userdetail.php" id="user">' . $_SESSION["username"] . '</a></li>';
                    echo '<li> <a href = "../data/log_out_post.php">Log Out</a></li>';
                } else {
                    echo '<li><a href="../pages/login.php">Login</a></li>';
                    echo '<li><a href="../pages/sign-up.php">Sign up</a></li>';
                }
                ?>
            </ul>
        </nav>
    </header>

    <div class="main-banner">
        <h1 class="landing-header">User</h1>
    </div>


    <main>







    </main>





</body>

</html>