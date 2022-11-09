<?php
session_start()
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.typekit.net/bdt8ycj.css">  
    <link rel="stylesheet" href="../assets/header.css">
    <title>Header</title>
</head>

<body>
    <header class="site-header">
        <div class="wrapper site-header__wrapper">
            <img class="brand" src="../assets/img/HabitudeLogo.png" alt="Brand Logo"/>
            <p>Classement</p>
            <p>En savoir +</p>
            <img src="../assets/img/Notification.png" alt="Notification logo">
            <img src="<?php echo $_SESSION['profile_picture'] . "60/" . $_SESSION['pseudo']; ?>">
        </div>
    </header>
</body>

</html>