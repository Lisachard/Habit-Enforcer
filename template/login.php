<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<?php
$title = "Login";
include "meta.php"
?>

<body>

    <div class="card">
        <?php if (isset($_SESSION['LOGGED_USER'])) : ?>
            <div class="card__side" style="min-width:100%;">
                <div class="content" style="align-items:center;">
                    <img src="<?php echo $_SESSION['profile_picture'] . $_SESSION['pseudo']?>" class="pp">
                    <p>Bienvenue <strong><?php echo $_SESSION['pseudo']?></strong></p>
                </div>
            </div>
        <?php else : ?>
            <div class="card__side">
                <form action="authentification.php" method="post">
                    <div class="content">
                        <h1>Log in</h1>

                        <label for="identifiant">Email</label>
                        <input type="text" name="identifiant" placeholder="Enter your email">

                        <label for="password">Password</label>
                        <input type="password" name="password" placeholder="• • • • • • • •">

                        <input type="submit" name="login" value="Login">
                    </div>
                </form>
            </div>
            <div class="card__side">
                <img src="https://images.unsplash.com/photo-1569230919100-d3fd5e1132f4?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=736&q=80">
            </div>
        <?php endif; ?>
    </div>
</body>

</html>