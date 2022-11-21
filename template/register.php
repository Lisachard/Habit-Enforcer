<?php
session_start();
$path = "../assets/form.css";
$title = "Register";
include "head.php";
?>

<body>
    <div class="card">
        <div class="card__side">
            <img src="https://images.unsplash.com/photo-1569230919100-d3fd5e1132f4?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=736&q=80">
        </div>
        <div class="card__side">
            <form action="authentification.php" method="post">
                <div class="content">
                    <h1>Sign up</h1>

                    <label for="username">Username</label>
                    <input type="text" name="username" placeholder="Enter your username">

                    <label for="email">Email</label>
                    <input type="email" name="email" placeholder="Enter your email">

                    <label for="password">Password</label>
                    <input type="password" name="password" placeholder="• • • • • • • •">

                    <label for="confirmPassword">Confirm password</label>
                    <input type="password" name="confirmPassword" placeholder="• • • • • • • •">

                    <input type="submit" name="register" value="Register">

                    <a href="../template/login.php">Already have an account ?</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>