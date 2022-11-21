<div>
    <?php
    if (isset($_POST['addHabit'])) {
        $bdd->addHabit();
    }
    ?>

    <?php if ($bdd->alreadyCreateHabit()): ?>
    <h1>You already have add a habit today, come tomorrow !</h1>
    <?php else: ?>
    <form action="home.php" method="post" style="visibility:visible;">
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

    <?php endif; ?>

    <form action="home.php" method="post">
        <?php foreach ($bdd->readHabit() as $habit): ?>
        <div class="card" style="border-top: solid <?php echo $habit['color'] ?>; width: 30vw; display: flex;">
            <input type="hidden" name="difficulty" value="<?php echo $habit['difficulty'] ?>">
            <h1>
                <?php echo $habit['label'] ?>
            </h1>
            <h2>
                <?php echo str_repeat("⭐", $habit['difficulty']) ?>
            </h2>
            <h2>
                <?php
            if ($habit['is_daily']) {
                echo "Daily";
            } else {
                echo "Weekly";
            }
                ?>
            </h2>
            <?php if ($habit['checked']): ?>
            <h2><input type="checkbox" value="<?php echo $habit['habit_id']; ?>" id="<?php echo $habit['habit_id']; ?>"
                    name="checked"
                    onchange="document.getElementById('<?php echo $habit['habit_id']; ?>').checked = true; submit();"
                    checked></h2>
            <?php else: ?>
            <h2><input type="checkbox" value="<?php echo $habit['habit_id']; ?>" name="notchecked" onchange="submit();">
            </h2>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </form>
</div>