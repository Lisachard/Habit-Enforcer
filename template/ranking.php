<?php
require("./authentification.php");
$path = "../assets/ranking.css";
$title = "Ranking";
include "head.php";
?>

<body>
    <?php include "heade.php";
    foreach ($bdd->listParty() as $party): ?>
    <div>
        <?php echo $party['name'] ?>
    </div>
    <?php endforeach; ?>
</body>

</html>