<?php
require("./authentification.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/test.css">
    <title>Home</title>
</head>

<body>

    <?php if (isset($_SESSION['LOGGED_USER'])) : ?>
        <header></header>
        <div class="board">
            <section class="left">
            <?php if (isset($_SESSION['party_id']) && $_SESSION['party_id'] != NULL) : ?>
                    <div class="grosContenuTuVaVoir">dulourdquiarrive</div>
                <?php else : ?>
                    <form action="home.php" method="post">
                        <input type="submit" name="createParty" value="Create a Party">
                        <input type="submit" value="Check Invitation">
                    </form>
                <?php endif; ?>
            </section>
            <section class="right">
                <?php if (isset($_SESSION['party_id'])) : ?>
                    <div class="grosContenuTuVaVoir">Let's GOOOOOO</div>
                <?php else : ?>
                    <h2>Vous ne faites actuellement parti d'aucun group 🫤</h2>
                <?php endif; ?>
            </section>
        </div>



        <!-- <h1>Salut <img src="<?php echo $_SESSION['profile_picture'] . $_SESSION['pseudo']; ?>"></h1>
        <form action="./authentification.php" method="post">
            <input type="submit" name="deconnexion" value="Deconnexion">
        </form>
    <?php else : ?>
        <?php Redirect("./login.php") ?>
    <?php endif; ?>
    -->
</body>

</html>