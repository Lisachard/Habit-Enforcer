<?php
require("./authentification.php");
$path = "../assets/ranking.css";
$title = "Ranking";
include "head.php";
?>

<body>
    <?php include "heade.php"?>

    <p>Nice to see you again <strong><?php echo $_SESSION['pseudo']?><strong> :)</p>
</body>

</html>