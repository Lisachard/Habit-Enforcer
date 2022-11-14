<?php
require("./authentification.php");
?>

<?php
if (isset($_POST['addHabit'])) {
    debug_to_console($_SESSION['member_id']);
    $bdd->addHabit();
}
?>

<form action="habit.php" method="post" style="visibility:visible;">
    <input type="text" name="label" required>
    <input type="text" name="difficulty" required>
    <input type="color" name="color" required   >
    <input type="submit" name="addHabit">
</form>

<?php
$bdd->readHabit();
?>