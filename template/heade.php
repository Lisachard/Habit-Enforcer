<?php
$path = "../assets/header.css";
$title = "Header";
include "head.php";
?>

<body>
    <header class="site-header">
        <div class="wrapper site-header__wrapper">
            <p><a class="redirection" href="home.php">Home</a>
            <p>
            <p><a class="redirection" href="ranking.php">Ranking</a></p>
            <a class="redirection" href="credits.php">Find out more</a>
            <p class="textHeader">🔔
            <p>
            <div class="dropdown">
                <button class="dropbutton">
                    <img src="<?php echo $_SESSION['profile_picture'] . $_SESSION['pseudo']; ?>">   
                </button>
                <div class="dropdown-content">
                    <a class="drop" href="profile.php">Modify profile</a>
                    <form action="./authentification.php" method="post">
                        <button class="drop" type="submit" name="deconnexion" value="Deconnexion">Deconnexion</button>
                    </form>
                </div>
            </div>
        </div>
    </header>
</body>

</html>