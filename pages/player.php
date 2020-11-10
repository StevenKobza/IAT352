<!DOCTYPE html>

<?php
session_start();

if (!isset($_SESSION["started"])) {
    $_SESSION["started"] = "true";
}
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <title>FIFA 21 — National Teams</title>
</head>

<body>

    <header class="header">
        <nav>
            <a href="../index.php"><img src="../img/logo.png" alt="FIFA 21 logo" class="logo"></a>
            <input class="menu-btn" type="checkbox" id="menu-btn" />
            <label class="menu-icon" for="menu-btn"><span class="navicon"></span></label>
            <ul class="menu">
            <li><a href="../index.php">Players</a></li>
                <li><a href="./clubs.php">Clubs</a></li>
                <li><a href="./leagues.php">Leagues</a></li>
                <li><a href="./position.php">Position</a></li>
                <?php
                    if (isset($_SESSION["username"])) {
                        echo '<li> <a href = "#">' . $_SESSION["username"] . '</a></li>';
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
        <h1 class="landing-header">Player</h1>
    </div>


    <main>

        <div>
            <div class="profile">
                <div class="general-info">
                    <h2>Kylian Mbappé Lottin</h2>
                    <img src="../img/1.png" alt="">
                </div>
                <p>Club: Paris Saint-Germain</p>
            </div>

            <h2>General</h2>
            <div class="general-stats">
                <div>
                    <h2>Card Rating</h2>
                    <h3>98</h3>
                </div>
                <div>
                    <h2>Position</h2>
                    <h3>ST</h3>
                </div>
                <div>
                    <h2>Work Rate</h2>
                    <h3>High/Low</h3>
                </div>
                <div>
                    <h2>Strong Foot</h2>
                    <h3>Right</h3>
                </div>
                <div>
                    <h2>Value</h2>
                    <h3>€105.5M</h3>
                </div>
            </div>
        </div>

        <h2>Specific</h2>
        <div class="specific-stats">
            <div>
                <h2>PACE</h2>
                <h3>99</h3>
            </div>
            <div>
                <h2>SHOOTING</h2>
                <h3>97</h3>
            </div>
            <div>
                <h2>PASSING</h2>
                <h3>92</h3>
            </div>
            <div>
                <h2>DRIBBLING</h2>
                <h3>98</h3>
            </div>
            <div>
                <h2>DEFENSE</h2>
                <h3>55</h3>
            </div>
            <div>
                <h2>PHYSICAL</h2>
                <h3>90</h3>
            </div>
            <div>
                <h2>WEAK FOOT</h2>
                <h3>4</h3>
            </div>
            <div>
                <h2>SKILL MOVES</h2>
                <h3>5</h3>
            </div>
        </div>







    </main>





</body>

</html>