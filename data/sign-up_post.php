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
                    <li><a href="../index.php">Players</a></li>
                    <li><a href="../pages/clubs.php">Clubs</a></li>
                    <li><a href="../pages/national-teams.php">National Teams</a></li>
                    <li><a href="../pages/position.php">Position</a></li>
                    <li><a href="../pages/login.php">Login</a></li>
                    <li><a href="../pages/sign-up.php">Sign up</a></li>
                </ul>
            </nav>
        </header>

        <main>
            <?php
            include("../phpData/logins.php");
            $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
            if ($mysqli->connect_errno) {
                echo "Failed to connect to MySQL: " . $mysqli->connect_error; 
            }
            
            $createUserQuery = "CREATE TABLE users (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(30) NOT NULL,
                password CHAR(128) NOT NULL,
                email VARCHAR(128) NOT NULL
            )";

            if (!$mysqli->query("DROP TABLE IF EXISTS users") || !$mysqli->query($createUserQuery)) {
                echo "Table creation failed: (" . $mysqli->errno . ") " . $mysqli->error;
            }

            if (!($stmt = $mysqli->prepare("INSERT INTO users(username, password, email) VALUES (?, ?, ?)"))) {
                echo "Preare failed: (" . $mysqli->errno . ") " . $mysqli->error;
            }

            class User {
                public $email;
                public $username;
                public $password;

                function setUp($email, $username, $password) {
                    $this->email = $email;
                    $this->username = $username;
                    $this->password = $password;
                }
            }
            $temp = new User();
            $temp->setUp($_POST["email"], $_POST["username"], $_POST["password"]);
            
            $outputFile = fopen("passwords.json", "a+") or die ("Unable to open file");
            $myJSON = json_encode($temp);
            fwrite($outputFile, $myJSON);
            fwrite($outputFile, ";\n");
            fclose($outputFile);
            ?>
        </main>
    </body>
</html>