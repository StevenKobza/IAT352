<!DOCTYPE HTML>

<html lang = "en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../css/main.css">
        <title>FIFA 21 — Sign Up</title>
    </head>
    <body>
        <header class="header">
            <nav>
                <a href="../index.php"><img src="../img/logo.png" alt="FIFA 21 logo" class="logo"></a>
                <input class="menu-btn" type="checkbox" id="menu-btn" />
                <label class="menu-icon" for="menu-btn"><span class="navicon"></span></label>
                <ul class="menu">
                    <li><a href="../pages/players.php">Players</a></li>
                    <li><a href="../pages/clubs.php">Clubs</a></li>
                    <li><a href="../pages/national-teams.php">National Teams</a></li>
                    <li><a href="../pages/position.php">Position</a></li>
                    <?php
                if (isset($_SESSION["username"])) {
                    echo '<li> <a href = "#" id="user">' . $_SESSION["username"] . '</a></li>';
                    echo '<li> <a href = "../data/log_out_post.php">Log Out</a></li>';
                } else {
                    echo '<li><a href="../pages/login.php">Login</a></li>';
                    echo '<li><a href="../pages/sign-up.php">Sign up</a></li>';
                }
                ?>
                </ul>
            </nav>
        </header>

        <main>
            <?php
            include("../phpData/dbconnect.php");
            $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
            if ($mysqli->connect_errno) {
                echo "Failed to connect to MySQL: " . $mysqli->connect_error; 
            }
            
            if (!($stmt = $mysqli->prepare("INSERT INTO user(username, email, password) VALUES (?, ?, ?)"))) {
                echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
            }

            $stmt->bind_param("sss", $username, $email, $password);

            $username = $_POST["username"];
            $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
            $email = $_POST["email"];
            $stmt->execute();
            
            ?>
        </main>
    </body>
</html>