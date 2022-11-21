<?php
$path = "../assets/header.css";
$title = "Header";
include "head.php";
?>

<body>
    <header class="site-header">
        <div class="wrapper site-header__wrapper">
            <p><a href="home.php">Home</a>
            <p>
            <p><a href="ranking.php">Ranking</a></p>
            <a href="credits.php">Find out more</a>
            <p class="textHeader">🔔
            <p>
            <div class="dropdown">
                <button class="dropbutton"><img
                        src="<?php echo $_SESSION['profile_picture'] . $_SESSION['pseudo']; ?>"></button>
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