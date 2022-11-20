<?php require("./authentification.php")?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.typekit.net/bdt8ycj.css">
    <link rel="stylesheet" href="../assets/profile.css">
    <title>Profile</title>
</head>

<body>
    <?php include "heade.php"?>

    <p>Nice to see you again <strong><?php echo $_SESSION['pseudo']?><strong> :)</p>

    <h1>Modify your personal informations :</h1>
    <form method="post">
        <input class="box" type="text" placeholder="Nickname" name="nickname" value="" required>
        <input class="box" type="email" placeholder="Email" name="email" value="" required>
        <button class="box" type="submit" name="modification">Modifier</button>
    </form>
</body>

</html>