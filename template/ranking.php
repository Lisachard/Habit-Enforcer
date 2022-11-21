<?php
require("./authentification.php");
$path = "../assets/common.css";
$title = "Ranking";
include "head.php";
?>

<body>
    <?php include "heade.php"; ?>
    <div class="centeringBlocks">
        <?php foreach ($bdd->listParty() as $party): ?>
        <div>
            <?php echo $party['name'] ?>
        </div>
        <?php endforeach; ?>
    </div>
</body>

</html>