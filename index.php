<!DOCTYPE html>
<?php
include ("data/createDataset.php");
addPlayers();
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
                <li><a href="./pages/national-teams.php">National Teams</a></li>
                <li><a href="./pages/position.php">Position</a></li>
                <li><a href="./pages/login.php">Login</a></li>
                <li><a href="./pages/sign-up.php">Sign up</a></li>
            </ul>
        </nav>
    </header>

    <div class="main-banner">
        <h1 class="landing-header">Players</h1>
    </div>


    <main>

        <div class="filter">
            <form action="#" class="position">
                <label for="position">Position</label>
                <select name="position" id="position">
                    <option value="lm">LW</option>
                    <option value="rw">RW</option>
                    <option value="st">ST</option>
                    <option value="lf">LF</option>
                    <option value="cf">CF</option>
                    <option value="rf">RF</option>
                    <option value="cam">CAM</option>
                    <option value="lm">LM</option>
                    <option value="cm">CM</option>
                    <option value="rm">RM</option>
                    <option value="cdm">CDM</option>
                    <option value="lwb">LWB</option>
                    <option value="rwb">RWB</option>
                    <option value="lb">LB</option>
                    <option value="rb">RB</option>
                    <option value="gk">GK</option>
                </select>
            </form>

            <form action="#" class="age">
                <label for="age">Age</label>
                <select name="age" id="age">
                    <option value="15">15-17</option>
                    <option value="18">18-20</option>
                    <option value="21">21-23</option>
                    <option value="24">24-26</option>
                    <option value="27">27-29</option>
                    <option value="30">30-32</option>
                    <option value="33">33-35</option>
                    <option value="36">36-38</option>
                    <option value="38">38 and up</option>
                </select>
            </form>

            <form action="#" class="Potential">
                <label for="Potential">Potential</label>
                <select name="Potential" id="Potential">
                    <option value="30">30-40</option>
                    <option value="41">41-50</option>
                    <option value="51">51-60</option>
                    <option value="61">61-70</option>
                    <option value="71">71-80</option>
                    <option value="81">81-90</option>
                    <option value="91">91 and up</option>
                </select>
            </form>

        </div>


        <table class="table">
            <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col">NAME</th>
                    <th scope="col">OVERALL</th>
                    <th scope="col">POTENTIAL</th>
                    <th scope="col">POSITION</th>
                    <th scope="col">CLUB</th>
                    <th scope="col">AGE</th>
                    <th scope="col">NATIONALITY</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row"><img src="./img/1.png" alt=""></th>
                    <td><a href="./pages/player.php">K. Mbappé</a></td>
                    <td>90</td>
                    <td>95</td>
                    <td>ST</td>
                    <td><img src="./img/c7.png" alt="">Paris Saint-Germain</td>
                    <td>21</td>
                    <td><img src="./img/n1.png" alt=""></td>
                </tr>
                <tr>
                    <th scope="row"><img src="./img/2.png" alt=""></th>
                    <td>João Félix</td>
                    <td>81</td>
                    <td>93</td>
                    <td>CF</td>
                    <td><img src="./img/c2.png" alt="">Atlético Madrid</td>
                    <td>20</td>
                    <td><img src="./img/n2.png" alt=""></td>
                </tr>
                <tr>
                    <th scope="row"><img src="./img/3.png" alt=""></th>
                    <td>Vinícius Jr.</td>
                    <td>80</td>
                    <td>93</td>
                    <td>LW</td>
                    <td><img src="./img/c8.png" alt="">Real Madrid</td>
                    <td>19</td>
                    <td><img src="./img/n3.png" alt=""></td>
                </tr>
                <tr>
                    <th scope="row"><img src="./img/4.png" alt=""></th>
                    <td>K. Havertz</td>
                    <td>85</td>
                    <td>93</td>
                    <td>CAM</td>
                    <td><img src="./img/c9.png" alt="">Chelsea</td>
                    <td>21</td>
                    <td><img src="./img/n4.png" alt=""></td>
                </tr>
                <tr>
                    <th scope="row"><img src="./img/5.png" alt=""></th>
                    <td>J. Sancho</td>
                    <td>87</td>
                    <td>93</td>
                    <td>RM</td>
                    <td><img src="./img/c1.png" alt="">Borussia Dortmund</td>
                    <td>20</td>
                    <td><img src="./img/n5.png" alt=""></td>
                </tr>
                <tr>
                    <th scope="row"><img src="./img/6.png" alt=""></th>
                    <td>J. Oblak</td>
                    <td>91</td>
                    <td>93</td>
                    <td>GK</td>
                    <td><img src="./img/c2.png" alt="">Atlético Madrid</td>
                    <td>27</td>
                    <td><img src="./img/n6.png" alt=""></td>
                </tr>
                <tr>
                    <th scope="row"><img src="./img/7.png" alt=""></th>
                    <td>M. ter Stegen</td>
                    <td>90</td>
                    <td>93</td>
                    <td>GK</td>
                    <td><img src="./img/c3.png" alt="">FC Barcelona</td>
                    <td>28</td>
                    <td><img src="./img/n4.png" alt=""></td>
                </tr>
                <tr>
                    <th scope="row"><img src="./img/8.png" alt=""></th>
                    <td>K. Messi</td>
                    <td>93</td>
                    <td>93</td>
                    <td>RW</td>
                    <td><img src="./img/c3.png" alt="">FC Barcelona</td>
                    <td>33</td>
                    <td><img src="./img/n7.png" alt=""></td>
                </tr>
                <tr>
                    <th scope="row"><img src="./img/9.png" alt=""></th>
                    <td>E. Haaland</td>
                    <td>84</td>
                    <td>92</td>
                    <td>ST</td>
                    <td><img src="./img/c1.png" alt="">Borussia Dortmund</td>
                    <td>19</td>
                    <td><img src="./img/n8.png" alt=""></td>
                </tr>
                <tr>
                    <th scope="row"><img src="./img/10.png" alt=""></th>
                    <td>M. de Ligt</td>
                    <td>85</td>
                    <td>92</td>
                    <td>CB</td>
                    <td><img src="./img/c4.png" alt="">Juventus</td>
                    <td>20</td>
                    <td><img src="./img/n9.png" alt=""></td>
                </tr>
                <tr>
                    <th scope="row"><img src="./img/11.png" alt=""></th>
                    <td>T. Alexander-Arnold</td>
                    <td>87</td>
                    <td>92</td>
                    <td>RB</td>
                    <td><img src="./img/c5.png" alt="">Liverpool</td>
                    <td>21</td>
                    <td><img src="./img/n5.png" alt=""></td>
                </tr>
                <tr>
                    <th scope="row"><img src="./img/12.png" alt=""></th>
                    <td>G. Donnarumma</td>
                    <td>85</td>
                    <td>92</td>
                    <td>GK</td>
                    <td><img src="./img/c6.png" alt="">Milan</td>
                    <td>21</td>
                    <td><img src="./img/n10.png" alt=""></td>
                </tr>
                <tr>
                    <th scope="row"><img src="./img/13.png" alt=""></th>
                    <td>Cristiano Ronaldo</td>
                    <td>92</td>
                    <td>92</td>
                    <td>ST</td>
                    <td><img src="./img/c4.png" alt="">Juventus</td>
                    <td>35</td>
                    <td><img src="./img/n2.png" alt=""></td>
                </tr>

            </tbody>
        </table>


        <a href="#" class="pagination">Next</a>





    </main>





</body>

</html>