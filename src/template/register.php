<!DOCTYPE html>
<html lang="en">

<?php 
$title = "Register"; 
include "meta.php"; 
?>

<body>
    <form action="../authentification.php" method="post">
        <input type="text" name="username" placeholder="Username">
        <input type="password" name="password" placeholder="Password">
        <input type="submit" name="register" value="Register">
    </form> 
</body>

</html>

