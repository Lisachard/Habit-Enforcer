<?php
require("./authentification.php");
$path = "../assets/profile.css";
$title = "Profile";
include "head.php";
?>

<body>
    <?php include "heade.php"?>

    <p>Nice to see you again <strong><?php echo $_SESSION['pseudo']?><strong> :)</p>

    <h1>Modify your personal informations :</h1>
    <form method="post">
        <input class="box" type="text" placeholder="Nickname" name="nickname" value="" required>
        <input class="box" type="email" placeholder="Email" name="email" value="" required>
        <button class="box" type="submit" name="modification">Save modifications</button>
    </form>
</body>

</html>