<?php

include_once "templates/header.php";
include_once "config/connection.php";
include_once "config/url.php";

$sets = range(1, 10);
$reps = range(1, 30);

// 1. Check if an ID is provided in the URL
if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
    $id = $_GET["id"];

    // 2. Prepare and execute a query to fetch the exercise by ID
    $query = "SELECT * FROM exercises WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    $exercise = $stmt->fetch(PDO::FETCH_ASSOC);  // Fetch the exercise data

    // 3. Check if the exercise exists
    if (!$exercise) {
        $_SESSION["msg"] = "Exercise not found!";
        header("Location: " . $BASE_URL . "index.php"); // Or wherever you want to redirect
        exit();
    }


} else {
    // Handle the case where no ID is provided
    $_SESSION["msg"] = "Invalid exercise ID.";
    header("Location: " . $BASE_URL . "index.php");
    exit();
}

?>

<div class="create-form">
    <h1>YOU ARE MAKING PROGRESS!</h1>
    <form action="<?= $BASE_URL ?>config/process.php" method="POST">
        <input type="hidden" name="type" value="edit">
        <input type="hidden" name="id" value="<?= $exercise["id"] ?>">
        <div class="form-group">
            <label for="name">Exercise name</label>
            <input id="name" class="form-control" type="text" name="name" value="<?= $exercise["name"] ?>"
                placeholder="Insert the name of the exercise. ex: Bench press" required>
        </div>
        <div class="form-group">
            <label for="sets">How many sets?</label>
            <select id="sets" class="form-select form-select-sm" name="sets">
                <?php foreach ($sets as $set): ?>
                    <option class="sets-dropdown" value="<?= $set ?>" <?= ($set == $exercise["sets"]) ? 'selected' : ''; ?>>
                        <?= $set ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <label for="reps">How many reps?</label>
            <select id="reps" class="form-select form-select-sm" name="reps">
                <?php foreach ($reps as $rep): ?>
                    <option class="reps-dropdown" value="<?= $rep ?>" <?= ($rep == $exercise["reps"]) ? 'selected' : ''; ?>>
                        <?= $rep ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="current-weight">How many kilograms do you currently lift? </label>
            <input id="current-weight" class="form-control" type="number" name="currentweight"
                value="<?= $exercise["currentweight"] ?>" placeholder="Ex: 90kg " required>
        </div>
        <button type="submit">Update exercise</button>
    </form>
</div>