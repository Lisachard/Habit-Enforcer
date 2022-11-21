<?php
require("./authentification.php");
$path = "../assets/home.css";
$title = "Home";
include "head.php";
?>

<body>
    <?php include "heade.php"?>

    <?php if (isset($_SESSION['LOGGED_USER'])) : ?>
        <header></header>
        <div class="board">
            <section class="left">
                <?php if (isset($_SESSION['party_id'])) : ?>
                    <h1>Bienvenue dans le groupe <?php echo $_SESSION['party_name'] ?></h1>
                <?php else : ?>
                    <form action="home.php" method="post">
                        <input type="text" name="partyName">
                        <input class="box" type="submit" name="createParty" value="Create a Party">
                        <input class="box" type="submit" name="checkInvitation" value="Check Invitation">
                    </form>
                    <form action="./home.php" method="post">
                        <?php for ($i = 0; $i < count($_SESSION['invitation_party_id']); $i++) : ?>
                            <?php if ($_SESSION['invitation_party_id'][$i] != NULL) : ?>
                                <div class="card">
                                    <?php echo $_SESSION['invitation_party_name'][$i] ?>
                                    <button type="submit" name="party" value="<?php echo $_SESSION['invitation_party_id'][$i] ?>">Join</button>
                                </div>
                            <?php endif ?>
                        <?php endfor ?>
                    </form>

                <?php endif; ?>
            </section>
            <section class="right">
                <?php if (isset($_SESSION['party_id'])) : ?>
                    <?php if (isset($_GET['makeInvitation'])) : ?>
                        <div>
                            <form action="home.php" method="get">
                                <input type="hidden" value="true" name="makeInvitation">
                                <input type="text" name="searching" id="searchbar" value="<?php echo $_GET['searching'] ?>" placeholder="Search your Friends here">
                            </form>
                            <form action="home.php?makeInvitation=true&searching=<?php echo $_GET['searching'] ?>" method="post">
                                <?php
                                if (isset($_GET['searching'])) {
                                    $bdd->searchFriend();
                                }
                                ?>
                            </form>

                        </div>
                    <?php else : ?>
                        <form action="home.php" method="get">
                            <input type="hidden" name="searching">
                            <button type="submit" value="true" name="makeInvitation">Invite Your Friends</button>
                        </form>
                    <?php endif ?>
                <?php else : ?>
                    <h2>Vous ne faites actuellement parti d'aucun groupe 🫤</h2>
                <?php endif; ?>
            </section>
        </div>
    <?php else : ?>
        <?php Redirect("./login.php") ?>
    <?php endif; ?>
</body>

</html>