<?php
require("./authentification.php");
$path = "../assets/credits.css";
$title = "Credits";
include "head.php";
?>

<body>
    <?php include "heade.php"?>

    <p>Nice to see you again <strong><?php echo $_SESSION['pseudo']?><strong> :)</p>
</body>

</html>