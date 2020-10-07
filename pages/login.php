<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../css/main.css">
        <title>FIFA 21 — Login</title>
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
                    <li><a href="./national-teams.php">National Teams</a></li>
                    <li><a href="./position.php">Position</a></li>
                    <li><a href="./login.php">Login</a></li>
                    <li><a href="./sign-up.php">Sign up</a></li>
                </ul>
            </nav>
        </header>

        <div class="main-banner">
            <h1 class="landing-header">Log In</h1>
        </div>


        <main>

            <form action="../data/login_post.php" class="login" method = "post">
                <div class="input-group-1">
                    <input type="text" id="username" name="username" placeholder="Username">
                    <!--<input type="email" id="email" name="email" placeholder="Email">-->
                </div>

                <div class="input-group-2">
                    <input type="password" id="password" name="password" placeholder="Password">
                    <!--<input type="password" id="re-password" name="re-password" placeholder="Re-enter your password">-->
                </div>

                <div class="input-group-3">
                    <input type="submit" value="Submit">
                </div>
            </form>



        </main>





    </body>

</html>