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
    die("how did you get here");
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

        <div>
            <div class="profile">
                <div class="general-info">
                    <h2><?php echo $_SESSION["username"]; ?></h2>

                </div>
            </div>

            <!-- Input form for changing username and password -->
            <div class="info">
                <form action="userUpdateStuff.php" method="post" class="userInfo">
                    <fieldset class="username">
                        <p>Current Username: <?php echo $_SESSION["username"] ?></p>
                        <label for="usernameForm">Change Username</label>
                        <input type="text" name="usernameForm">
                    </fieldset>
                    <fieldset class="oldPassword">
                        <label for="passwordForm">Current Password</label>
                        <input type="text" name="passwordForm"><br>
                    </fieldset>
                    <fieldset class="newPassword">
                        <label for="newPasswordForm">New Password</label>
                        <input type="text" name="newPasswordForm"><br>
                    </fieldset>
                    <fieldset class="submit">
                        <input type="submit">
                    </fieldset>
                </form>
            </div>
        </div>







    </main>





</body>

</html>