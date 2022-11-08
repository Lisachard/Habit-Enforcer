<?php 
require("./authentification.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>

<body>
    <?php if (isset($_SESSION['LOGGED_USER'])) : ?>
        <h1>Salut <?php echo $_SESSION['pseudo']; ?></h1>
        <form action="./authentification.php" method="post">
            <input type="submit" name="deconnexion" value="Deconnexion">
        </form>
        <?php else : ?>
            <?php Redirect("./login.php") ?>
    <?php endif; ?>
</body>

</html>