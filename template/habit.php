<?php
require("./authentification.php");
?>

<?php
if (isset($_POST['addHabit'])) {
    $bdd->addHabit();
}
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.typekit.net/bdt8ycj.css">  
    <link rel="stylesheet" href="../assets/habit.css">
    <link rel="icon" href="../assets/img/HabitudeLogo.ico" type="image/ico">
    <title>Header</title>
</head>

<?php if ($bdd->alreadyCreateHabit()) : ?>
    <h1>You have already add a habit today, come tomorrow ^^</h1>
<?php else : ?>
<form action="habit.php" method="post" style="visibility:visible;">
    <input class="box" type="text" name="label" placeholder="Activity" required>
    <select class="box" type="periodicities" name="periodicity" required value="Periodicity">
        <option selected hidden>Periodicity</option>
        <option value="daily">Daily</option>
        <option value="weekly">Weekly</option>
    </select>
    <select class="box" type="difficulties" name="difficulty" required value="Difficulty">
        <option selected hidden>Difficulty</option>
        <option value="1">⭐</option>
        <option value="2">⭐⭐</option>
        <option value="3">⭐⭐⭐</option>
        <option value="4">⭐⭐⭐⭐</option>
        <option value="5">⭐⭐⭐⭐⭐</option>
    </select>
    <input class="box" type="color" name="color" required>
    <input class="box" type="submit" name="addHabit">
</form>

<?php foreach ($bdd->readHabit() as $habit) : ?>
    <div class="card" style="border-top: solid <?php echo $habit['color'] ?>; width: 30vw;">
        <h1><?php echo $habit['label'] ?></h1>
        <h2><?php echo str_repeat("⭐",  $habit['difficulty']) ?></h2>
    </div>
<?php endforeach ?>

<script src="../script/test.js"></script>