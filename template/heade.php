<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.typekit.net/bdt8ycj.css">  
    <link rel="stylesheet" href="../assets/header.css">
    <link rel="icon" href="../assets/img/HabitudeLogo.ico" type="image/ico">
    <title>Header</title>
</head>

<body>
    <header class="site-header">
        <div class="wrapper site-header__wrapper">
            <p><a href="home.php">Home</a><p>
            <p><a href="ranking.php">Ranking</a></p>
            <a href="credits.php">Find out more</a>
            <p class="textHeader">🔔<p>
            <div class="dropdown">
                <button class="dropbutton"><img src="<?php echo $_SESSION['profile_picture'] . $_SESSION['pseudo']; ?>"></button>
                <div class="dropdown-content">
                    <a href="profile.php">Modify profile</a>
                    <a>
                        <form action="./home.php" method="post">
                            <input type="submit" name="deconnexion" value="Deconnexion">
                        </form>
                    </a>
                </div>
            </div>
        </div>
    </header>
</body>

</html>

