<!DOCTYPE html>
<html lang="en">

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

        <div class="main-banner">
            <h1 class="landing-header">Log In</h1>
        </div>


        <main>
        
            <?php
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
            $handle = fopen("passwords.json", "r");
            $contents = fread($handle, 1000);
            $userArray = explode(";", $contents);
            for ($i = 0; $i < count($userArray) -1; $i++) {
                $tempUN = $_POST["username"];
                $tempPW = $_POST["password"];
                if ($tempUN === json_decode($userArray[$i])->username && $tempPW === json_decode($userArray[$i])->password) {
                    echo "Logged in";
                }
            }
            //$tempJson = json_decode($contents);
            
            //var_dump(json_decode($contents));
            ?>




        </main>





    </body>

</html>