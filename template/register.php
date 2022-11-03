<!DOCTYPE html>
<html lang="en">

<?php 
$title = "Register"; 
include_once "meta.php"; 
?>

<body>
    <div class="card">
        <form action="authentification.php" method="post">
            <input type="text" name="username" placeholder="Username">
            <input type="email" name="email" placeholder="Email">
            <input type="password" name="password" placeholder="Password">
            <input type="submit" name="register" value="Register">
        </form> 
    </div>
</body>

</html>

