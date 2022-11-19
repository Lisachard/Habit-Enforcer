<?php
require("./authentification.php");
?>

<?php
if (isset($_POST['addHabit'])) {
    $bdd->addHabit();
}
?>

<?php if ($bdd->alreadyCreateHabit()) : ?>
    <h1>You have already add a habit today, come tomorrow ^^</h1>
<?php else : ?>
    <form action="habit.php" method="post" style="visibility:visible;">
        <input type="text" name="label" placeholder="Activity" required>
        <select type="periodicities" name="periodicity" required>
            <option selected hidden>Periodicity</option>
            <option value="daily">Daily</option>
            <option value="weekly">Weekly</option>
        </select>
        <select type="difficulties" name="difficulty" required>
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
<?php endif; ?>

<?php foreach ($bdd->readHabit() as $habit) : ?>
    <div class="card" style="border-top: solid <?php echo $habit['color'] ?>; width: 30vw;">
        <h1><?php echo $habit['label'] ?></h1>
        <h2><?php echo str_repeat("⭐",  $habit['difficulty']) ?></h2>
    </div>
<?php endforeach ?>

<script src="../script/test.js"></script>