<?php


include_once "templates/header.php";




?>

<?php if (count($exercises) > 0): ?>
    <div class="homepage-container">
        <?php if (isset($printMsg) && $printMsg != ''): ?>
            <p id="msg"><?= $printMsg ?></p>
        <?php endif; ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Exercise name</th>
                    <th scope="col">Sets</th>
                    <th scope="col">Reps</th>
                    <th scope="col">Current weight</th>
                    <th scope="col"></th>


                </tr>
            </thead>
            <tbody>
                <?php foreach ($exercises as $exercise): ?>
                    <tr>
                        <th scope="row"><?= $exercise["id"] ?></th>
                        <td scope="row"><?= $exercise["name"] ?></td>
                        <td scope="row"><?= $exercise["sets"] ?></td>
                        <td scope="row"><?= $exercise["reps"] ?></td>
                        <td scope="row"><?= $exercise["currentweight"] ?>kg</td>
                        <td class="actions">
                            <a class="action-btn" href="<?= $BASE_URL ?>edit.php?id=<?= $exercise["id"] ?>"><i
                                    class="fa-solid fa-pen-to-square"></i></a>
                            <form class="delete-form" action="<?= $BASE_URL ?>config/process.php" method="POST">
                                <input type="hidden" name="type" value="delete">
                                <input type="hidden" name="id" value="<?= $exercise["id"] ?>">
                                <button type="submit"><i class="fas fa-times delete-icon"></i></button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="add-btn">
            <a class="action-btn" href="<?= $BASE_URL ?>create_log.php">
                <i class="fa-solid fa-square-plus"></i>
            </a>
        </div>
    </div>
<?php else: ?>
    <?php include_once "empty_log.php"; ?>
<?php endif; ?>


<?php

include_once "templates/footer.php";

?>