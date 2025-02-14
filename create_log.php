<?php

include_once "templates/header.php";

$sets = range(1, 10);
$reps = range(1, 30);

?>

<div class="create-form">
    <h1>
        ONE STEP CLOSER TO TRACKING GREATNESS!
    </h1>
    <form name="create" action="<?= $BASE_URL ?>config/process.php" method="POST">
        <input type="hidden" name="type" value="create">
        <div class="form-group">
            <label for="name">Exercise name</label>
            <input id="name" class="form-control" type="text" name="name"
                placeholder="Insert the name of the exercise. ex: Bench press" required>
        </div>
        <div class="form-group">
            <label for="sets">How many sets?</label>
            <select id="sets" class="form-select form-select-sm" name="sets" id="sets" required>
                <?php foreach ($sets as $set): ?>
                    <option class="sets-dropdown" value="<?= $set ?>"><?= $set ?></option>
                <?php endforeach; ?>

            </select>
            <label for="reps">How many reps?</label>
            <select id="reps" class="form-select form-select-sm" name="reps" id="reps" required>
                <?php foreach ($reps as $rep): ?>
                    <option class="reps-dropdown" value="<?= $rep ?>"><?= $rep ?></option>
                <?php endforeach; ?>

            </select>

        </div>
        <div class="form-group">
            <label for="current-weight">How many kilograms do you currently lift? </label>
            <input id="current-weight" class="form-control" class="input-field" type="number" name="currentweight"
                placeholder="Ex: 90kg " required>
        </div>
        <button type="submit">Add exercise</button>
    </form>
</div>